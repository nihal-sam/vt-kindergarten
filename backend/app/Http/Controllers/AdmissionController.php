<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admission;

class AdmissionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'child_name'      => 'required|string|max:255',
            'dob'             => 'required|date',
            'gender'          => 'required|in:Male,Female',
            'program'         => 'required|string|max:100',
            'parent_name'     => 'required|string|max:255',
            'relation'        => 'required|string|max:50',
            'phone'           => 'required|string|max:20',
            'email'           => 'nullable|email|max:255',
            'address'         => 'required|string|max:500',
            'previous_school' => 'nullable|string|max:255',
            'message'         => 'nullable|string|max:1000',
        ]);

        $admission = Admission::create($validated);

        return response()->json([
            'message' => 'Admission application submitted successfully.',
            'data'    => $admission
        ], 201);
    }

    // Admin: list all admissions
    public function index(Request $request)
    {
        $query = Admission::latest();

        if ($request->search) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('child_name', 'like', "%$s%")
                  ->orWhere('parent_name', 'like', "%$s%")
                  ->orWhere('phone', 'like', "%$s%");
            });
        }

        if ($request->program) {
            $query->where('program', $request->program);
        }

        return response()->json([
            'data'  => $query->get(),
            'total' => $query->count()
        ]);
    }

    // Admin: show single
    public function show($id)
    {
        $admission = Admission::findOrFail($id);
        return response()->json($admission);
    }

    // Admin: update status
    public function update(Request $request, $id)
    {
        $admission = Admission::findOrFail($id);
        $admission->update($request->only(['status', 'notes']));
        return response()->json(['message' => 'Updated successfully.', 'data' => $admission]);
    }

    // Admin: delete
    public function destroy($id)
    {
        Admission::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }
}
