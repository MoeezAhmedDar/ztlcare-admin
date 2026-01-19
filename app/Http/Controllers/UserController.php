<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('roles')
                     ->latest()
                     ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::all();      

        $permissions = \Spatie\Permission\Models\Permission::orderBy('name')->get();

        return view('users.create', compact('roles', 'permissions'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Create the user
        $user = User::create([
            'first_name'  => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name'   => $validated['last_name'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'phone'       => $validated['phone'] ?? null,
            'postcode'    => $validated['postcode'] ?? null,
            'dob'         => $validated['dob'] ?? null,
        ]);

        // Assign the selected role (required field)
        $roleName = $validated['role'];
        $user->assignRole($roleName);

        // Handle direct permissions — ONLY if role is 'admin'
        if ($roleName === 'admin') {
            $permissions = $request->input('permissions', []); // array or empty array

            if (!empty($permissions)) {
                // Validate that submitted permissions actually exist
                $validPermissions = \Spatie\Permission\Models\Permission::whereIn('name', $permissions)
                    ->pluck('name')
                    ->toArray();

                if (!empty($validPermissions)) {
                    $user->givePermissionTo($validPermissions);

                    // Optional: log for audit/debug
                    \Log::info('Direct permissions assigned to new admin user', [
                        'user_id' => $user->id,
                        'email'   => $user->email,
                        'permissions' => $validPermissions,
                    ]);
                }
            }
        }

        // Optional: more descriptive success message
        $message = "User created successfully as {$roleName}.";

        return redirect()
            ->route('users.index')
            ->with('success', $message);
    }

    public function show(User $user): View
    {
        // If you want a view instead of API resource, change return type to View
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        $permissions = \Spatie\Permission\Models\Permission::orderBy('name')->get();

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        // Prepare data to update
        $updateData = [
            'first_name'  => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? $user->middle_name,
            'last_name'   => $validated['last_name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'] ?? $user->phone,
            'postcode'    => $validated['postcode'] ?? $user->postcode,
            'dob'         => $validated['dob'] ?? $user->dob,
        ];

        // Update password only if a new one was provided
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Apply all updates at once
        $user->update($updateData);

        // Sync role (removes old roles and assigns the new one)
        $roleName = $validated['role'] ?? null;
        if ($roleName) {
            $user->syncRoles($roleName);
        }

        // Handle direct permissions — only relevant/allowed if role is 'admin'
        if ($roleName === 'admin') {
            // Get submitted permissions (array or empty)
            $submittedPermissions = $request->input('permissions', []);

            // Only keep permissions that actually exist in the database
            $validPermissions = \Spatie\Permission\Models\Permission::whereIn('name', $submittedPermissions)
                ->pluck('name')
                ->toArray();

            // Sync: adds new, removes any that were unchecked
            $user->syncPermissions($validPermissions);

            // Optional: log for debugging / audit trail
            \Log::info('Direct permissions updated for admin user', [
                'user_id'     => $user->id,
                'email'       => $user->email,
                'permissions' => $validPermissions,
                'changed_by'  => auth()->id(),
            ]);
        } else {
            // Role is not admin anymore → remove all direct permissions
            $user->syncPermissions([]);

            // Optional log
            \Log::info('Direct permissions removed (role changed from admin)', [
                'user_id'    => $user->id,
                'email'      => $user->email,
                'new_role'   => $roleName,
            ]);
        }

        return redirect()
            ->route('users.index')
            ->with('success', "User updated successfully as {$roleName}.");
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}