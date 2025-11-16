@extends('dashboard.master')

@section('title', 'إدارة الفئات')

@push('styles')
<style>
    .search-card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border-radius: 12px;
    }
    .category-card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    .category-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    .category-image {
        width: 60px;
        height: 60px;
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
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    .pagination {
        margin-bottom: 0;
    }
    .btn-group .btn {
        border-radius: 6px;
    }
    .btn-group .btn:not(:last-child) {
        margin-right: 0.5rem;
    }
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
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
    .description-text {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
@endpush

@section('content')
    <!-- Search & Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card search-card">
                <div class="card-body">
                    <form method="GET" action="{{ route('categories.index') }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">البحث</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="ابحث في اسم الفئة أو الوصف..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
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
            <h4 class="mb-0">الفئات ({{ $categories->total() }} فئة)</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('categories.create') }}" class="btn btn-success me-2">
                <i class="iconoir-plus me-1"></i> إضافة فئة جديدة
            </a>
            @if(request()->has('search'))
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                    <i class="iconoir-refresh me-1"></i> إعادة تعيين
                </a>
            @endif
        </div>
    </div>

    <!-- Categories Table -->
    <div class="row">
        <div class="col-12">
            <div class="card category-card">
                <div class="card-body p-0">
                    @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>الفئة</th>
                                        <th>الوصف</th>
                                        <th>عدد الإعلانات</th>
                                        <th>تاريخ الإنشاء</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <!-- Category Info -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-semibold">{{ $category->name }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Description -->
                                        <td>
                                            @if($category->description)
                                                <div class="description-text" title="{{ $category->description }}">
                                                    {{ $category->description }}
                                                </div>
                                            @else
                                                <span class="text-muted">لا يوجد وصف</span>
                                            @endif
                                        </td>

                                        <!-- Ads Count -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary me-2">{{ $category->ads_count }} إعلان</span>
                                                @if($category->ads_count > 0)
                                                    <a href="{{ route('categories.ads', $category) }}" 
                                                       class="btn btn-outline-primary btn-sm" 
                                                       title="عرض الإعلانات">
                                                        <i class="iconoir-eye"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Created Date -->
                                        <td>
                                            <small class="text-muted">
                                                <i class="iconoir-calendar me-1"></i>
                                                {{ $category->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('categories.show', $category) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="عرض التفاصيل">
                                                    <i class="iconoir-eye"></i>
                                                </a>
                                                <a href="{{ route('categories.edit', $category) }}" 
                                                   class="btn btn-outline-warning btn-sm" 
                                                   title="تعديل">
                                                    <i class="iconoir-edit-pencil"></i>
                                                </a>

                                                <!-- Delete -->
                                                <form method="POST" action="{{ route('categories.destroy', $category) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger btn-sm" 
                                                            title="حذف"
                                                            onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟ هذا الإجراء لا يمكن التراجع عنه.')">
                                                        <i class="iconoir-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($categories->hasPages())
                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-center">
                                    <nav>
                                        <ul class="pagination">
                                            @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                                                <li class="page-item {{ $page == $categories->currentPage() ? 'active' : '' }}">
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
                            <i class="iconoir-folder fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد فئات</h5>
                            <p class="text-muted">لم يتم العثور على أي فئات مطابقة لمعايير البحث</p>
                            @if(request()->has('search'))
                                <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
                                    <i class="iconoir-refresh me-1"></i> إعادة تعيين البحث
                                </a>
                            @else
                                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                    <i class="iconoir-plus me-1"></i> إضافة فئة جديدة
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Additional scripts can be added here if needed
</script>
@endpush
