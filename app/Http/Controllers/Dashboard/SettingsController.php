<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * عرض صفحة الإعدادات
     */
    public function index()
    {
        $settings = Setting::getSiteSettings();
        return view('dashboard.settings.index', compact('settings'));
    }

    /**
     * عرض صفحة من نحن (About Us)
     */
    public function aboutUs()
    {
        $about = AboutUs::getData();
        return view('dashboard.settings.about-us', compact('about'));
    }

    /**
     * تحديث الإعدادات
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        // التعامل مع رفع الشعار
        if ($request->hasFile('logo')) {
            $settings = Setting::getSiteSettings();
            
            // حذف الشعار القديم إذا كان موجوداً
            if ($settings && $settings->logo && Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }
            
            // رفع الشعار الجديد
            $logoPath = $request->file('logo')->store('settings', 'public');
            $data['logo'] = $logoPath;
        }

        Setting::updateSiteSettings($data);

        return redirect()->back()->with('success', 'تم تحديث إعدادات الموقع بنجاح');
    }

    /**
     * تحديث بيانات صفحة من نحن (About Us)
     */
    public function updateAboutUs(Request $request)
    {
        $data = $request->validate([
            'main_title' => 'nullable|string|max:255',
            'main_description' => 'nullable|string',
            'mission_title' => 'nullable|string|max:255',
            'mission_description' => 'nullable|string',
            'vision_title' => 'nullable|string|max:255',
            'vision_description' => 'nullable|string',
            'stat_1_label' => 'nullable|string|max:255',
            'stat_1_value' => 'nullable|string|max:255',
            'stat_2_label' => 'nullable|string|max:255',
            'stat_2_value' => 'nullable|string|max:255',
            'stat_3_label' => 'nullable|string|max:255',
            'stat_3_value' => 'nullable|string|max:255',
        ]);

        // تجاهل الحقول غير المرسلة (null) حتى لا يتم مسح البيانات من الفورمات الأخرى
        $data = array_filter($data, function ($value) {
            return !is_null($value);
        });

        AboutUs::updateData($data);

        return redirect()->back()->with('success', 'تم تحديث بيانات صفحة من نحن بنجاح');
    }

    /**
     * حذف الشعار
     */
    public function deleteLogo()
    {
        $settings = Setting::getSiteSettings();
        
        if ($settings && $settings->logo) {
            // حذف الملف من التخزين
            if (Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }
            
            // تحديث قاعدة البيانات
            $settings->update(['logo' => null]);
            
            return redirect()->back()->with('success', 'تم حذف الشعار بنجاح');
        }
        
        return redirect()->back()->with('error', 'لا يوجد شعار لحذفه');
    }
}
