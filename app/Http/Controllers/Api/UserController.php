<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get all users.
     */
    public function index(): JsonResponse
    {
        $users = User::with(['role', 'branch'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully.',
            'data' => $users,
        ], 200);
    }

    /**
     * Create a new user.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'branch_id' => 'nullable|exists:branches,id',
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|max:255',
            'phone' => 'nullable|string|max:30',
            'status' => 'nullable|in:active,inactive',
        ]);

        $user = User::create($validated);

        $user->load(['role', 'branch']);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'data' => $user,
        ], 201);
    }

    /**
     * Get one user.
     */
    public function show(User $user): JsonResponse
    {
        $user->load(['role', 'branch']);

        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully.',
            'data' => $user,
        ], 200);
    }

    /**
     * Update user.
     */
    public function update(
        Request $request,
        User $user
    ): JsonResponse {
              $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'branch_id' => 'nullable|exists:branches,id',
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|max:255',
            'phone' => 'nullable|string|max:30',
            'status' => 'nullable|in:active,inactive',
        ]);

        $user->update($validated);

        $user->load(['role', 'branch']);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'data' => $user,
        ], 200);
    }

    /**
     * Delete user.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.',
        ], 200);
    }
}
