@extends('dashboard.master')

@section('title', 'تفاصيل الفئة')

@push('styles')
<style>
    .info-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .info-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    .section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px 12px 0 0;
        margin: -1.25rem -1.25rem 1.5rem -1.25rem;
    }
    .category-image {
        width: 100%;
        height: 200px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f3f4;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
    }
    .info-value {
        color: #212529;
        font-size: 0.95rem;
    }
    .status-badge {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
    }
    .action-buttons .btn {
        margin: 0.25rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .action-buttons .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .stats-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid #dee2e6;
    }
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    .stats-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }
    .description-box {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        border-left: 4px solid #667eea;
        margin: 1rem 0;
    }
</style>
@endpush

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">تفاصيل الفئة</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">لوحة التحكم</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('categories.index') }}">الفئات</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $category->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                        <i class="iconoir-arrow-left me-1"></i> العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Overview -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- صورة الفئة -->
            <div class="card info-card mb-4">
                <div class="card-body text-center">
                    <div class="section-header">
                        <h6 class="mb-0">صورة الفئة</h6>
                    </div>
                    @if($category->logo)
                        <img src="{{ asset('storage/' . $category->logo) }}" 
                             alt="{{ $category->name }}" 
                             class="category-image mb-3">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light rounded" 
                             style="height: 200px;">
                            <div class="text-center">
                                <i class="iconoir-folder fs-1 text-muted mb-2"></i>
                                <p class="text-muted mb-0">لا توجد صورة</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- معلومات الفئة -->
            <div class="card info-card">
                <div class="card-body">
                    <div class="section-header">
                        <h6 class="mb-0">معلومات الفئة</h6>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold text-muted" style="width: 30%;">
                                        <i class="iconoir-tag me-2"></i>اسم الفئة
                                    </td>
                                    <td class="fw-bold">{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="iconoir-text me-2"></i>الوصف
                                    </td>
                                    <td>{{ $category->description ?? 'لا يوجد وصف' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="iconoir-list me-2"></i>عدد الإعلانات
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $category->ads_count ?? 0 }} إعلان</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="iconoir-calendar me-2"></i>تاريخ الإنشاء
                                    </td>
                                    <td>{{ $category->created_at->format('d/m/Y - h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="iconoir-refresh me-2"></i>آخر تحديث
                                    </td>
                                    <td>{{ $category->updated_at->format('d/m/Y - h:i A') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- أزرار الإجراءات -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card info-card">
                <div class="card-body">
                    <div class="section-header">
                        <h6 class="mb-0">إجراءات الفئة</h6>
                    </div>
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <!-- عرض الإعلانات -->
                        @if($category->ads_count > 0)
                            <a href="{{ route('categories.ads', $category) }}" class="btn btn-primary">
                                <i class="iconoir-eye me-1"></i> عرض الإعلانات ({{ $category->ads_count }})
                            </a>
                        @endif
                        
                        <!-- تعديل -->
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                            <i class="iconoir-edit-pencil me-1"></i> تعديل الفئة
                        </a>

                        <!-- حذف -->
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger"
                                    onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟ هذا الإجراء لا يمكن التراجع عنه.')">
                                <i class="iconoir-trash me-1"></i> حذف الفئة
                            </button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // تأكيد الحذف
    document.querySelectorAll('form[action*="destroy"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('هل أنت متأكد من حذف هذه الفئة؟ سيتم حذف جميع البيانات المرتبطة بها.')) {
                e.preventDefault();
            }
        });
    });

    // تأكيد تغيير الحالة
    document.querySelectorAll('form[action*="toggle-status"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const isActive = {{ $category->status ? 'true' : 'false' }};
            const action = isActive ? 'تعطيل' : 'تفعيل';
            if (!confirm(`هل أنت متأكد من ${action} هذه الفئة؟`)) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
