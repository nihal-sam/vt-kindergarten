<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;

class EnquiryController extends Controller
{
    // Public: store new enquiry
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
            'program' => 'nullable|string|max:100',
            'message' => 'required|string|max:2000',
        ]);

        $enquiry = Enquiry::create($validated);

        return response()->json([
            'message' => 'Enquiry submitted successfully.',
            'data'    => $enquiry
        ], 201);
    }

    // Admin: list all enquiries
    public function index(Request $request)
    {
        $query = Enquiry::latest();

        if ($request->search) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('phone', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%");
            });
        }

        return response()->json([
            'data'  => $query->get(),
            'total' => $query->count()
        ]);
    }

    // Admin: show single
    public function show($id)
    {
        return response()->json(Enquiry::findOrFail($id));
    }

    // Admin: delete
    public function destroy($id)
    {
        Enquiry::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }
}
