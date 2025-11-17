<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CotegoriesController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::select('name', 'description', 'logo')
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'description' => $category->description,
                    'image' => $category->logo ? asset('storage/' . $category->logo) : null,
                ];
            });

        return response()->json([
            'data' => $categories,
        ]);
    }
}
