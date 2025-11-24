<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $data = $user->toArray();

        $data['image_url'] = $user->image ? asset('storage/' . $user->image) : null;

        return response()->json([
            'status' => true,
            'message' => 'Profile data',
            'data' => $data,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم تحديث البيانات الشخصية بنجاح',
            'data' => $user,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم تغيير كلمة المرور بنجاح',
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $imagePath = $request->file('image')->store('users', 'public');

        $user->update([
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم تحديث الصورة الشخصية بنجاح',
            'data' => [
                'image_url' => asset('storage/' . $imagePath),
            ],
        ]);
    }

    public function updateLocation(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'city' => ['nullable', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update([
            'city' => $request->city,
            'area' => $request->area,
            'location' => $request->location,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم تحديث الموقع بنجاح',
            'data' => $user,
        ]);
    }
}
