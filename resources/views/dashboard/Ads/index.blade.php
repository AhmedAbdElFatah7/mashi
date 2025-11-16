@extends('dashboard.master')

@section('title', isset($pageTitle) ? $pageTitle : 'إدارة الإعلانات')

@push('styles')
<style>
    .search-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        color: white;
    }
    .ad-card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .ad-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    .badge-featured {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    .price-tag {
        font-size: 1.1rem;
        font-weight: 600;
        color: #28a745;
    }
    .pagination {
        margin-bottom: 0;
    }
    .pagination .page-link {
        color: #667eea;
        border-color: #dee2e6;
    }
    .pagination .page-item.active .page-link {
        background-color: #667eea;
        border-color: #667eea;
    }
    .pagination .page-link:hover {
        color: #495057;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    /* Fix pagination arrows size and appearance */
    .pagination .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.25;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
    }
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 0.875rem;
    }
    /* Override any conflicting styles */
    .pagination .page-link svg {
        width: 16px;
        height: 16px;
    }
    /* Reset pagination to default Bootstrap style */
    .pagination .page-item:first-child .page-link::before,
    .pagination .page-item:last-child .page-link::before {
        display: none;
    }
    .pagination .page-item:first-child .page-link::after,
    .pagination .page-item:last-child .page-link::after {
        display: none;
    }
    .pagination .page-link {
        position: relative;
        font-size: inherit !important;
    }
    /* Ensure proper text rendering */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        text-decoration: none;
    }
    /* Custom pagination style */
    .pagination .page-link {
        border: 1px solid #dee2e6;
        color: #6c757d;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    .pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
        color: #495057;
    }
</style>
@endpush

@section('content')
    <!-- Search & Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card search-card">
                <div class="card-body">
                    <form method="GET" action="{{ isset($isFeaturedPage) ? route('ads.featured') : route('ads.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">البحث</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="ابحث في العنوان أو الوصف أو اسم البائع..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">الفئة</label>
                                <select name="category" class="form-select">
                                    <option value="">جميع الفئات</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">النوع</label>
                                <select name="featured" class="form-select">
                                    <option value="">جميع الإعلانات</option>
                                    <option value="yes" {{ request('featured') == 'yes' ? 'selected' : '' }}>
                                        الإعلانات المميزة
                                    </option>
                                    <option value="no" {{ request('featured') == 'no' ? 'selected' : '' }}>
                                        الإعلانات العادية
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-light">
                                        <i class="iconoir-search me-1"></i> بحث
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Header -->
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0">{{ isset($pageTitle) ? $pageTitle : 'الإعلانات' }} ({{ $ads->total() }} إعلان)</h4>
        </div>
        <div class="col-md-6 text-end">
            <div class="btn-group">
                @if(!isset($isFeaturedPage))
                    <a href="{{ route('ads.create') }}" class="btn btn-primary">
                        <i class="iconoir-plus me-1"></i> إضافة إعلان جديد
                    </a>
                @else
                    <a href="{{ route('ads.index') }}" class="btn btn-outline-primary">
                        <i class="iconoir-list me-1"></i> جميع الإعلانات
                    </a>
                @endif
                @if(request()->hasAny(['search', 'category', 'featured']))
                    <a href="{{ isset($isFeaturedPage) ? route('ads.featured') : route('ads.index') }}" class="btn btn-outline-secondary">
                        <i class="iconoir-refresh me-1"></i> إعادة تعيين
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Ads Grid -->
    <div class="row">
        @forelse($ads as $ad)
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card ad-card h-100">
                <!-- Ad Image -->
                <div class="position-relative">
                    @php
                        $images = is_string($ad->images) ? json_decode($ad->images, true) : $ad->images;
                        $firstImage = is_array($images) && !empty($images) ? $images[0] : null;
                    @endphp
                    
                    @if($firstImage)
                        <img src="{{ asset('storage/' . $firstImage) }}" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover;" 
                             alt="{{ $ad->title }}">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 
                             style="height: 200px;">
                            <i class="iconoir-megaphone fs-1 text-muted"></i>
                        </div>
                    @endif
                    
                    @if($ad->is_featured)
                        <span class="badge badge-featured position-absolute top-0 end-0 m-2">مميز</span>
                    @endif
                </div>

                <div class="card-body">
                    <!-- Basic Info -->
                    <h5 class="card-title mb-2">{{ Str::limit($ad->title, 30) }}</h5>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <span class="badge bg-primary">{{ $ad->category->name ?? 'غير محدد' }}</span>
                        </div>
                        <div class="col-6 text-end">
                            <div class="price-tag">
                                @if($ad->price)
                                    ${{ number_format($ad->price, 0) }}
                                @else
                                    <span class="text-muted">غير محدد</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Seller Name -->
                    <p class="text-muted mb-2">
                        <i class="iconoir-user me-1"></i>
                        {{ $ad->seller_name }}
                    </p>

                    <!-- Date -->
                    <p class="text-muted small mb-3">
                        <i class="iconoir-calendar me-1"></i>
                        {{ $ad->created_at->format('d/m/Y') }}
                    </p>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('ads.show', $ad) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="iconoir-eye me-1"></i> مشاهدة
                        </a>
                        <a href="{{ route('ads.edit', $ad) }}" class="btn btn-outline-warning btn-sm">
                            <i class="iconoir-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('ads.destroy', $ad) }}" 
                              class="d-inline" 
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا الإعلان؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="iconoir-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="iconoir-megaphone fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">لا توجد إعلانات</h5>
                    <p class="text-muted">لم يتم العثور على أي إعلانات تطابق معايير البحث</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($ads->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                <nav>
                    <ul class="pagination">
                        @foreach ($ads->getUrlRange(1, $ads->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $ads->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}" 
                                   style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 2px; border-radius: 6px;">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    @endif
@endsection