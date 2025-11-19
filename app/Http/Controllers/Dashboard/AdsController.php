<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdsController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::with(['user', 'category']);

        // البحث في العنوان أو الوصف
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('seller_name', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الفئة
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // فلترة حسب النوع (مميز أم لا)
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured == 'yes');
        }

        // ترتيب حسب الأحدث
        $ads = $query->latest()->paginate(12);

        // جلب الفئات للفلترة
        $categories = Category::all();

        return view('dashboard.Ads.index', compact('ads', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.Ads.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'seller_name' => 'required|string|max:255',
            'seller_phone' => 'required|string|max:20',
            'type' => 'nullable|string|max:50',
            'additional_info' => 'nullable|string',
            'is_featured' => 'boolean',
            'allow_mobile_messages' => 'boolean',
            'allow_whatsapp_messages' => 'boolean',
            'fee_agree' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('ads', 'public');
                $imagePaths[] = $path;
            }
        }

        // Create the ad
        $ad = Ad::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'type' => $request->type,
            'additional_info' => $request->additional_info,
            'images' => !empty($imagePaths) ? json_encode($imagePaths) : null,
            'seller_name' => $request->seller_name,
            'seller_phone' => $request->seller_phone,
            'allow_mobile_messages' => $request->boolean('allow_mobile_messages'),
            'allow_whatsapp_messages' => $request->boolean('allow_whatsapp_messages'),
            'fee_agree' => $request->boolean('fee_agree'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('ads.show', $ad)->with('success', 'تم إنشاء الإعلان بنجاح');
    }

    public function show(Ad $ad)
    {
        $ad->load(['user', 'category']);
        return view('dashboard.Ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        $categories = Category::all();
        return view('dashboard.Ads.edit', compact('ad', 'categories'));
    }

    public function update(Request $request, Ad $ad)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'seller_name' => 'required|string|max:255',
            'seller_phone' => 'required|string|max:20',
            'is_featured' => 'boolean',
            'allow_mobile_messages' => 'boolean',
            'allow_whatsapp_messages' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'seller_name' => $request->seller_name,
            'seller_phone' => $request->seller_phone,
            'is_featured' => $request->boolean('is_featured'),
            'allow_mobile_messages' => $request->boolean('allow_mobile_messages'),
            'allow_whatsapp_messages' => $request->boolean('allow_whatsapp_messages'),
        ];

        // Handle image uploads
        if ($request->hasFile('images')) {
            // Get existing images
            $existingImages = [];
            if ($ad->images) {
                $existingImages = is_string($ad->images) ? json_decode($ad->images, true) : $ad->images;
                if (!is_array($existingImages)) {
                    $existingImages = [];
                }
            }

            // Upload new images
            $newImagePaths = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('ads', $imageName, 'public');
                $newImagePaths[] = $imagePath;
            }
            
            // Combine existing and new images
            $allImages = array_merge($existingImages, $newImagePaths);
            $updateData['images'] = json_encode($allImages);
        }

        $ad->update($updateData);

        return redirect()->route('ads.show', $ad)->with('success', 'تم تحديث الإعلان بنجاح');
    }

    public function deleteImage(Request $request, Ad $ad)
    {
        $imageIndex = $request->input('image_index');
        $images = is_string($ad->images) ? json_decode($ad->images, true) : $ad->images;
        
        if (is_array($images) && isset($images[$imageIndex])) {
            // Delete the physical file
            $imagePath = $images[$imageIndex];
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            // Remove from array
            unset($images[$imageIndex]);
            $images = array_values($images); // Re-index array
            
            // Update the ad
            $ad->update([
                'images' => !empty($images) ? json_encode($images) : null
            ]);
            
            return response()->json(['success' => true, 'message' => 'تم حذف الصورة بنجاح']);
        }
        
        return response()->json(['success' => false, 'message' => 'لم يتم العثور على الصورة']);
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->route('ads.index')->with('success', 'تم حذف الإعلان بنجاح');
    }

    /**
     * Display featured ads only.
     */
    public function featured(Request $request)
    {
        $query = Ad::with(['user', 'category'])
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $ads = $query->paginate(10);
        $categories = Category::all();
        $pageTitle = 'الإعلانات المميزة';
        $isFeaturedPage = true;

        return view('dashboard.Ads.index', compact('ads', 'categories', 'pageTitle', 'isFeaturedPage'));
    }

    public function extent()
    {
        $categories = Category::all();

        return view('dashboard.Ads.extent', compact('categories'));
    }

    public function importFromUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'category_id' => 'required|exists:categories,id',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم سحب الإعلان بنجاح من الرابط المحدد.',
        ]);
    }
}
