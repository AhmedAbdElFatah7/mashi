<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // إحصائيات عامة
        $totalAds = Ad::count();
        $totalCategories = Category::count();
        $totalUsers = User::where('role', 'user')->count();
        $featuredAds = Ad::where('is_featured', true)->count();

        // آخر الإعلانات
        $recentAds = Ad::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        // آخر المستخدمين
        $recentUsers = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        // إحصائيات الإعلانات حسب الفئة
        $adsByCategory = Category::withCount('ads')
            ->orderBy('ads_count', 'desc')
            ->take(6)
            ->get();

        // إحصائيات الإعلانات حسب الشهر (آخر 6 شهور)
        $adsPerMonth = Ad::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('dashboard.index', compact(
            'totalAds',
            'totalCategories', 
            'totalUsers',
            'featuredAds',
            'recentAds',
            'recentUsers',
            'adsByCategory',
            'adsPerMonth'
        ));
    }
}
