<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Get all branches.
     */
    public function index(): JsonResponse

    {
        $branches = Branch::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Branches retrieved successfully.',
            'data' => $branches,
        ], 200);
    }

    /**
     * Create a new branch.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:30|unique:branches,code',
            'name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'address' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);

        $branch = Branch::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Branch created successfully.',
            'data' => $branch,
        ], 201);
    }

    /**
     * Get one branch.
     */
    public function show(Branch $branch): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Branch retrieved successfully.',
            'data' => $branch,
        ], 200);
    }

    /**
     * Update a branch.
     */
    public function update(Request $request, Branch $branch): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:30|unique:branches,code,' . $branch->id,
            'name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'address' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);

        $branch->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Branch updated successfully.',
            'data' => $branch->fresh(),
        ], 200);
    }

    /**
     * Delete a branch.
     */
    public function destroy(Branch $branch): JsonResponse
    {
        $branch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully.',
        ], 200);
    }
}
