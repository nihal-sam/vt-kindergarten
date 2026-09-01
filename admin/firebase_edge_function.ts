import { serve } from "https://deno.land/std@0.168.0/http/server.ts"

// Note: You need to store your firebase-admin.json content securely
// in Supabase Secrets under the name 'FIREBASE_SERVICE_ACCOUNT'
// You also need to get an OAuth2 token. Since generating OAuth2 tokens in Edge Functions 
// can be complex without full Node.js libraries, the easiest modern way to send FCM from Deno
// is using a REST API call with a JWT.

// We will use a library to sign the JWT for Google OAuth2
import { create } from "https://deno.land/x/djwt@v2.8/mod.ts";

serve(async (req) => {
  try {
    // 1. Parse the incoming webhook from Supabase (New Enquiry or Admission)
    const payload = await req.json();
    const record = payload.record;
    
    // Distinguish based on parent_name (just like React app does)
    const isAdmission = record.parent_name && record.parent_name.trim() !== '';
    const type = isAdmission ? 'Admission' : 'Enquiry';
    
    const name = record.child_name || record.name || 'Unknown';
    const phone = record.phone || 'No phone provided';
    
    const title = `New ${type} has been registered!`;
    const body = `Child Name: ${name}\nPhone: ${phone}`;

    // 2. Get Firebase Credentials from Supabase Secrets
    const serviceAccountStr = Deno.env.get('FIREBASE_SERVICE_ACCOUNT');
    if (!serviceAccountStr) throw new Error('Missing FIREBASE_SERVICE_ACCOUNT secret');
    
    const serviceAccount = JSON.parse(serviceAccountStr);

    // 3. Generate OAuth2 Token for Firebase Cloud Messaging
    const jwtPayload = {
      iss: serviceAccount.client_email,
      scope: "https://www.googleapis.com/auth/firebase.messaging",
      aud: "https://oauth2.googleapis.com/token",
      exp: Math.floor(Date.now() / 1000) + 3600,
      iat: Math.floor(Date.now() / 1000),
    };

    // Import the private key
    const privateKeyStr = serviceAccount.private_key.replace(/\\n/g, '\n');
    const privateKey = await crypto.subtle.importKey(
      "pkcs8",
      str2ab(pemToRaw(privateKeyStr)),
      { name: "RSASSA-PKCS1-v1_5", hash: "SHA-256" },
      false,
      ["sign"]
    );

    const jwt = await create({ alg: "RS256", typ: "JWT" }, jwtPayload, privateKey);

    const tokenRes = await fetch("https://oauth2.googleapis.com/token", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `grant_type=urn%3Aietf%3Aparams%3Aoauth%3Agrant-type%3Ajwt-bearer&assertion=${jwt}`
    });
    
    const tokenData = await tokenRes.json();
    const accessToken = tokenData.access_token;

    // 4. Send the Push Notification via FCM HTTP v1 API
    const fcmUrl = `https://fcm.googleapis.com/v1/projects/${serviceAccount.project_id}/messages:send`;
    
    const fcmPayload = {
      message: {
        topic: "admin_alerts", // The Flutter app will subscribe to this topic
        notification: {
          title: title,
          body: body,
        },
        android: {
          priority: "high",
        },
        data: {
          type: type,
          id: String(record.id)
        }
      }
    };

    const fcmRes = await fetch(fcmUrl, {
      method: "POST",
      headers: {
        "Authorization": `Bearer ${accessToken}`,
        "Content-Type": "application/json"
      },
      body: JSON.stringify(fcmPayload)
    });

    const fcmResult = await fcmRes.json();

    return new Response(JSON.stringify({ success: true, result: fcmResult }), {
      headers: { "Content-Type": "application/json" },
      status: 200,
    });
    
  } catch (err) {
    return new Response(JSON.stringify({ error: err.message }), {
      headers: { "Content-Type": "application/json" },
      status: 500,
    });
  }
});

// Helper functions for crypto
function pemToRaw(pem: string) {
  return atob(pem.replace(/-----BEGIN PRIVATE KEY-----|-----END PRIVATE KEY-----|\n|\r/g, ""));
}
function str2ab(str: string) {
  const buf = new ArrayBuffer(str.length);
  const bufView = new Uint8Array(buf);
  for (let i = 0, strLen = str.length; i < strLen; i++) {
    bufView[i] = str.charCodeAt(i);
  }
  return buf;
}
