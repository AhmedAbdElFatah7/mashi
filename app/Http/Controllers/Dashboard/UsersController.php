<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        // البحث في الاسم أو الإيميل أو الهاتف
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // فلترة حسب المدينة
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status == 'active');
        }

        // ترتيب حسب الأحدث
        $users = $query->withCount('ads')->latest()->paginate(12);

        // جلب المدن للفلترة
        $cities = User::where('role', 'user')
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->sort();

        return view('dashboard.users.index', compact('users', 'cities'));
    }

    public function show(User $user)
    {

        // جلب إعلانات المستخدم مع العلاقات
        $ads = $user->ads()->paginate(10);
        return view('dashboard.users.show', compact('user', 'ads'));
    }

    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'city' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'boolean'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'city' => $request->city,
            'area' => $request->area,
            'location' => $request->location,
            'role' => 'user',
            'status' => $request->status ?? true,
        ]);

        return redirect()->route('users.index')->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('users.show', $user)
            ->with('success', 'تم تحديث كلمة المرور بنجاح');
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => !$user->status
        ]);

        $message = $user->status ? 'تم تفعيل المستخدم بنجاح' : 'تم إلغاء تفعيل المستخدم بنجاح';

        return redirect()->back()
            ->with('success', $message);
    }

    public function destroy(User $user)
    {
        // التأكد من أن المستخدم له role = user
        if ($user->role !== 'user') {
            abort(404);
        }

        // حذف إعلانات المستخدم أولاً
        $user->ads()->delete();

        // حذف المستخدم
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'تم حذف المستخدم وجميع إعلاناته بنجاح');
    }
}
