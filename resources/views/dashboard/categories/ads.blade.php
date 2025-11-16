@extends('dashboard.master')

@section('title', 'إعلانات ' . $category->name)

@push('styles')
<style>
    .ads-card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    .ads-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    .ad-image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
    }
    .table th {
        background-color: #f8f9fa;
        border: none;
        font-weight: 600;
        color: #495057;
    }
    .table td {
        border: none;
        vertical-align: middle;
    }
    .table tbody tr {
        border-bottom: 1px solid #e9ecef;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .ad-image { display: none !important; }
</style>
@endpush

@section('content')
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">الفئات</a></li>
                    <li class="breadcrumb-item active">إعلانات {{ $category->name }}</li>
                </ol>
            </nav>
            <h2 class="mb-0">إعلانات {{ $category->name }}</h2>
            <p class="text-muted">إجمالي {{ $ads->total() }} إعلان</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                <i class="iconoir-arrow-right me-1"></i> العودة للفئات
            </a>
        </div>
    </div>

    <!-- Ads Table -->
    <div class="row">
        <div class="col-12">
            <div class="card ads-card">
                <div class="card-body p-0">
                    @if($ads->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>الإعلان</th>
                                        <th>المعلن</th>
                                        <th>السعر</th>
                                        <th>تاريخ النشر</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ads as $ad)
                                    <tr>
                                        <!-- Ad Info -->
                                        <td>
                                            <div>
                                                            <div class="fw-semibold">{{ $ad->title }}</div>
                                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($ad->description, 50) }}</small>
                                            </div>
                                        </td>

                                        <!-- User -->
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $ad->user->name }}</div>
                                                <small class="text-muted">{{ $ad->user->email }}</small>
                                            </div>
                                        </td>

                                        <!-- Price -->
                                        <td>
                                            <span class="badge bg-success">{{ number_format($ad->price) }} ج.م</span>
                                        </td>

                                        <!-- Created Date -->
                                        <td>
                                            <small class="text-muted">
                                                <i class="iconoir-calendar me-1"></i>
                                                {{ $ad->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('ads.show', $ad) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="عرض التفاصيل">
                                                    <i class="iconoir-eye"></i>
                                                </a>
                                                <a href="{{ route('ads.edit', $ad) }}" 
                                                   class="btn btn-outline-warning btn-sm" 
                                                   title="تعديل">
                                                    <i class="iconoir-edit-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($ads->hasPages())
                            <div class="card-footer bg-transparent">
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
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-5">
                            <i class="iconoir-media-image fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد إعلانات</h5>
                            <p class="text-muted">لم يتم نشر أي إعلانات في هذه الفئة بعد</p>
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
                                <i class="iconoir-arrow-right me-1"></i> العودة للفئات
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
