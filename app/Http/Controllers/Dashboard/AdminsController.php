<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminsController extends Controller
{
    /**
     * Display a listing of admins.
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'super_admin'])
                    ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role') && in_array($request->role, ['admin', 'super_admin'])) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('status', $status);
        }

        $admins = $query->paginate(10);

        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        return view('dashboard.admins.create');
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,super_admin',
            'status' => 'boolean'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status ?? true,
        ]);

        return redirect()->route('admins.index')->with('success', 'تم إنشاء المدير بنجاح');
    }

    /**
     * Display the specified admin.
     */
    public function show(User $admin)
    {
        // التأكد من أن المستخدم له role = admin أو super_admin
        if (!in_array($admin->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        return view('dashboard.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(User $admin)
    {
        // التأكد من أن المستخدم له role = admin أو super_admin
        if (!in_array($admin->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        return view('dashboard.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, User $admin)
    {
        // التأكد من أن المستخدم له role = admin أو super_admin
        if (!in_array($admin->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'phone' => 'required|string|max:20',
            'role' => 'required|in:admin,super_admin',
            'status' => 'boolean'
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'status' => $request->status ?? true,
        ]);

        return redirect()->route('admins.index')->with('success', 'تم تحديث بيانات المدير بنجاح');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy(User $admin)
    {
        // التأكد من أن المستخدم له role = admin أو super_admin
        if (!in_array($admin->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        // منع حذف المدير الحالي
        if ($admin->id === auth()->id()) {
            return redirect()->route('admins.index')->with('error', 'لا يمكنك حذف حسابك الخاص');
        }

        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'تم حذف المدير بنجاح');
    }

    /**
     * Update admin password.
     */
    public function updatePassword(Request $request, User $admin)
    {
        // التأكد من أن المستخدم له role = admin أو super_admin
        if (!in_array($admin->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admins.show', $admin)->with('success', 'تم تحديث كلمة المرور بنجاح');
    }

    /**
     * Toggle admin status.
     */
    public function toggleStatus(User $admin)
    {
        // التأكد من أن المستخدم له role = admin أو super_admin
        if (!in_array($admin->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        // منع تعطيل المدير الحالي
        if ($admin->id === auth()->id()) {
            return redirect()->route('admins.index')->with('error', 'لا يمكنك تعطيل حسابك الخاص');
        }

        $admin->update([
            'status' => !$admin->status
        ]);

        $message = $admin->status ? 'تم تفعيل المدير بنجاح' : 'تم تعطيل المدير بنجاح';
        return redirect()->route('admins.index')->with('success', $message);
    }
}
