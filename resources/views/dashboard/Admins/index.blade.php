@extends('dashboard.master')

@section('title', 'إدارة المديرين')

@push('styles')
<style>
    .search-card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border-radius: 12px;
    }
    .admin-card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    .admin-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    .admin-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
    }
    .role-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
    }
    .role-super_admin {
        background-color: #dc3545 !important;
        color: white !important;
        border: 1px solid #dc3545;
    }
    .role-admin {
        background-color: #0d6efd !important;
        color: white !important;
        border: 1px solid #0d6efd;
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
</style>
@endpush

@section('content')
    <!-- Search & Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card search-card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admins.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">البحث</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="ابحث في الاسم أو الإيميل أو الهاتف..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">الصلاحية</label>
                                <select name="role" class="form-select">
                                    <option value="">جميع الصلاحيات</option>
                                    <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>
                                        مدير عام
                                    </option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                                        مدير
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="">جميع المديرين</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                        نشط
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        غير نشط
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
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
            <h4 class="mb-0">المديرين ({{ $admins->total() }} مدير)</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admins.create') }}" class="btn btn-success me-2">
                <i class="iconoir-user-plus me-1"></i> إضافة مدير جديد
            </a>
            @if(request()->hasAny(['search', 'role', 'status']))
                <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary">
                    <i class="iconoir-refresh me-1"></i> إعادة تعيين
                </a>
            @endif
        </div>
    </div>

    <!-- Admins Table -->
    <div class="row">
        <div class="col-12">
            <div class="card admin-card">
                <div class="card-body p-0">
                    @if($admins->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>المدير</th>
                                        <th>معلومات الاتصال</th>
                                        <th>الصلاحية</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الانضمام</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admins as $admin)
                                    <tr>
                                        <!-- Admin Info -->
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-semibold">{{ $admin->name }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Contact Info -->
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $admin->email }}</div>
                                                <small class="text-muted">{{ $admin->phone }}</small>
                                            </div>
                                        </td>

                                        <!-- Role -->
                                        <td>
                                            @if($admin->role === 'super_admin')
                                                <span class="badge bg-danger text-white">
                                                    <i class="iconoir-crown me-1"></i>مدير عام
                                                </span>
                                            @else
                                                <span class="badge bg-primary text-white">
                                                    <i class="iconoir-user-star me-1"></i>مدير
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @if($admin->status)
                                                <span class="badge bg-success status-badge">
                                                    <i class="iconoir-check-circle me-1"></i>نشط
                                                </span>
                                            @else
                                                <span class="badge bg-danger status-badge">
                                                    <i class="iconoir-cancel me-1"></i>غير نشط
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Join Date -->
                                        <td>
                                            <small class="text-muted">
                                                <i class="iconoir-calendar me-1"></i>
                                                {{ $admin->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('users.show', $admin) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="عرض التفاصيل">
                                                    <i class="iconoir-eye"></i>
                                                </a>
                                                <a href="{{ route('admins.edit', $admin) }}" 
                                                   class="btn btn-outline-warning btn-sm" 
                                                   title="تعديل">
                                                    <i class="iconoir-edit-pencil"></i>
                                                </a>
                                                
                                                @if($admin->id !== auth()->id())
                                                    <!-- Toggle Status -->
                                                    <form method="POST" action="{{ route('admins.toggle-status', $admin) }}" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="btn btn-outline-{{ $admin->status ? 'warning' : 'success' }} btn-sm"
                                                                title="{{ $admin->status ? 'تعطيل' : 'تفعيل' }}"
                                                                onclick="return confirm('هل أنت متأكد من {{ $admin->status ? 'تعطيل' : 'تفعيل' }} هذا المدير؟')">
                                                            <i class="iconoir-{{ $admin->status ? 'pause' : 'play' }}"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Delete -->
                                                    <form method="POST" action="{{ route('admins.destroy', $admin) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-outline-danger btn-sm" 
                                                                title="حذف"
                                                                onclick="return confirm('هل أنت متأكد من حذف هذا المدير؟ هذا الإجراء لا يمكن التراجع عنه.')">
                                                            <i class="iconoir-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-info">حسابك</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($admins->hasPages())
                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-center">
                                    <nav>
                                        <ul class="pagination">
                                            @foreach ($admins->getUrlRange(1, $admins->lastPage()) as $page => $url)
                                                <li class="page-item {{ $page == $admins->currentPage() ? 'active' : '' }}">
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
                            <i class="iconoir-user-star fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد مديرين</h5>
                            <p class="text-muted">لم يتم العثور على أي مديرين مطابقين لمعايير البحث</p>
                            @if(request()->hasAny(['search', 'role', 'status']))
                                <a href="{{ route('admins.index') }}" class="btn btn-outline-primary">
                                    <i class="iconoir-refresh me-1"></i> إعادة تعيين البحث
                                </a>
                            @else
                                <a href="{{ route('admins.create') }}" class="btn btn-primary">
                                    <i class="iconoir-user-plus me-1"></i> إضافة مدير جديد
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
    // Auto-submit form on filter change
    document.querySelectorAll('select[name="role"], select[name="status"]').forEach(function(select) {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush