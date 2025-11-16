@extends('dashboard.master')

@section('title', 'إدارة المستخدمين')

@push('styles')
<style>
    .search-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        color: white;
    }
    .user-card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .user-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    .user-avatar {
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
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
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
</style>
@endpush

@section('content')
    <!-- Search & Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card search-card">
                <div class="card-body">
                    <form method="GET" action="{{ route('users.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">البحث</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="ابحث في الاسم أو الإيميل أو الهاتف أو المدينة..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">المدينة</label>
                                <select name="city" class="form-select">
                                    <option value="">جميع المدن</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" 
                                                {{ request('city') == $city ? 'selected' : '' }}>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="">جميع المستخدمين</option>
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
            <h4 class="mb-0">المستخدمين ({{ $users->total() }} مستخدم)</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('users.create') }}" class="btn btn-success me-2">
                <i class="iconoir-user-plus me-1"></i> إضافة مستخدم جديد
            </a>
            @if(request()->hasAny(['search', 'city', 'status']))
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    <i class="iconoir-refresh me-1"></i> إعادة تعيين
                </a>
            @endif
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card user-card">
                <div class="card-body p-0">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>المستخدم</th>
                                        <th>الهاتف</th>
                                        <th>المدينة</th>
                                        <th>عدد الإعلانات</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الانضمام</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <!-- User Info -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-semibold">{{ $user->name }}</div>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Phone -->
                                        <td>{{ $user->phone }}</td>

                                        <!-- City -->
                                        <td>{{ $user->city ?? 'غير محدد' }}</td>

                                        <!-- Ads Count -->
                                        <td>
                                            <span class="badge bg-primary">{{ $user->ads_count }} إعلان</span>
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @if($user->status)
                                                <span class="badge bg-success">نشط</span>
                                            @else
                                                <span class="badge bg-danger">غير نشط</span>
                                            @endif
                                        </td>

                                        <!-- Join Date -->
                                        <td>
                                            <small class="text-muted">
                                                <i class="iconoir-calendar me-1"></i>
                                                {{ $user->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('users.show', $user) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="عرض التفاصيل">
                                                    <i class="iconoir-eye"></i>
                                                </a>
                                                
                                                <!-- Toggle Status -->
                                                <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="btn btn-outline-{{ $user->status ? 'warning' : 'success' }} btn-sm"
                                                            title="{{ $user->status ? 'تعطيل' : 'تفعيل' }} المستخدم"
                                                            onclick="return confirm('هل أنت متأكد من {{ $user->status ? 'تعطيل' : 'تفعيل' }} هذا المستخدم؟')">
                                                        <i class="iconoir-{{ $user->status ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                </form>

                                                <!-- Delete -->
                                                <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger btn-sm"
                                                            title="حذف المستخدم"
                                                            onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟ سيتم حذف جميع إعلاناته أيضاً.')">
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
                        @if($users->hasPages())
                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-center">
                                    <nav>
                                        <ul class="pagination">
                                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                                <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
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
                            <i class="iconoir-user fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">لا يوجد مستخدمين</h5>
                            <p class="text-muted">لم يتم العثور على أي مستخدمين يطابقون معايير البحث</p>
                            @if(request()->hasAny(['search', 'city', 'status']))
                                <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
                                    <i class="iconoir-refresh me-1"></i> إعادة تعيين البحث
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection