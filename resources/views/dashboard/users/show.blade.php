@extends('dashboard.master')

@section('title', 'تفاصيل المستخدم')

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
    }
    .section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px 12px 0 0;
        margin: -1.25rem -1.25rem 1.5rem -1.25rem;
    }
    .info-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    .info-value {
        font-size: 1.1rem;
        color: #212529;
        font-weight: 500;
    }
    .user-avatar-large {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3.5rem;
        font-weight: 700;
        margin: 0 auto 1.5rem auto;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        border: 4px solid white;
    }
    .status-indicator {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        box-shadow: 0 0 0 3px rgba(255,255,255,0.8);
    }
    .status-active {
        background-color: #28a745;
    }
    .status-inactive {
        background-color: #dc3545;
    }
    .stats-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid #dee2e6;
    }
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.5rem;
    }
    .stats-label {
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 500;
    }
    .ad-mini-card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        background: white;
        position: relative;
    }
    .ad-mini-card::after {
        content: '';
        position: absolute;
        bottom: -0.75rem;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, #dee2e6 20%, #dee2e6 80%, transparent 100%);
    }
    .ad-mini-card:last-child::after {
        display: none;
    }
    .ad-mini-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
        border-color: #667eea;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f8f9fa;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
    }
    .password-form {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        border: 1px solid #e9ecef;
    }
</style>
@endpush

@section('content')
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">المستخدمين</a></li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                </ol>
            </nav>
            <h2 class="mb-0">تفاصيل المستخدم</h2>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $user->status ? 'btn-warning' : 'btn-success' }}">
                        <i class="iconoir-{{ $user->status ? 'pause' : 'play' }} me-1"></i>
                        {{ $user->status ? 'إلغاء التفعيل' : 'تفعيل' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('users.destroy', $user) }}" 
                      class="d-inline" 
                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟ سيتم حذف جميع إعلاناته أيضاً.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="iconoir-trash me-1"></i> حذف المستخدم
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Top Row: Profile and Contact Info -->
    <div class="row mb-4">
        <!-- Profile Card -->
        <div class="col-lg-6">
            <!-- Profile Card -->
            <div class="card info-card h-100">
                <div class="card-body text-center">
                    @if($user->avatar)
                        <div class="user-avatar-large" style="background: none; padding: 0;">
                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                 alt="{{ $user->name }}" 
                                 class="rounded-circle"
                                 style="width: 140px; height: 140px; object-fit: cover; border: 4px solid white; box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);">
                        </div>
                    @else
                        <div class="user-avatar-large">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                    <h3 class="mb-2">{{ $user->name }}</h3>
                    <p class="text-muted mb-3 fs-6">{{ $user->email }}</p>
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <span class="status-indicator {{ $user->status ? 'status-active' : 'status-inactive' }}"></span>
                        <span class="fw-semibold fs-5">{{ $user->status ? 'نشط' : 'غير نشط' }}</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stats-card">
                                <div class="stats-number">{{ $user->ads->count() }}</div>
                                <div class="stats-label">إعلان</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card">
                                <div class="stats-number">{{ $user->created_at->format('d/m/Y') }}</div>
                                <div class="stats-label">تاريخ الانضمام</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="col-lg-6">
            <div class="card info-card h-100">
                <div class="section-header">
                    <h5 class="mb-0"><i class="iconoir-phone me-2"></i>معلومات الاتصال</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold text-muted" style="width: 40%;">
                                        <i class="iconoir-mail me-2 text-primary"></i>البريد الإلكتروني
                                    </td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="iconoir-phone me-2 text-success"></i>رقم الهاتف
                                    </td>
                                    <td>{{ $user->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="iconoir-map-pin me-2 text-warning"></i>المدينة
                                    </td>
                                    <td>{{ $user->city ?? 'غير محدد' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="iconoir-calendar me-2 text-info"></i>تاريخ الانضمام
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y - h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="iconoir-refresh me-2 text-secondary"></i>آخر تحديث
                                    </td>
                                    <td>{{ $user->updated_at->format('d/m/Y - h:i A') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Change Section -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Change Password -->
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title mb-3">تغيير كلمة المرور</h5>
                    
                    <form method="POST" action="{{ route('users.update-password', $user) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور الجديدة</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="iconoir-lock me-1"></i> تحديث كلمة المرور
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- User Ads Section -->
    <div class="row">
        <div class="col-12">
            <div class="card info-card">
                <div class="section-header">
                    <h5 class="mb-0"><i class="iconoir-media-image-list me-2"></i>إعلانات المستخدم ({{ $ads->total() }} إعلان)</h5>
                </div>
                <div class="card-body p-0">
                    @if($ads->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>الإعلان</th>
                                        <th>الفئة</th>
                                        <th>السعر</th>
                                        <th>الحالة</th>
                                        <th>تاريخ النشر</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ads as $ad)
                                    <tr>
                                        <!-- Number -->
                                        <td>{{ $loop->iteration }}</td>

                                        <!-- Ad Info -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $images = is_string($ad->images) ? json_decode($ad->images, true) : $ad->images;
                                                    $firstImage = is_array($images) && !empty($images) ? $images[0] : null;
                                                @endphp
                                                
                                                <div class="me-3" style="width: 50px; height: 50px;">
                                                    @if($firstImage)
                                                        <img src="{{ asset('storage/' . $firstImage) }}" 
                                                             class="img-fluid rounded" 
                                                             style="height: 50px; width: 50px; object-fit: cover;" 
                                                             alt="{{ $ad->title }}">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                             style="height: 50px; width: 50px;">
                                                            <i class="iconoir-media-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ Str::limit($ad->title, 30) }}</div>
                                                    <small class="text-muted">{{ Str::limit($ad->description, 40) }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Category -->
                                        <td>
                                            <span class="badge bg-primary">
                                                <i class="iconoir-tag me-1"></i>{{ $ad->category->name ?? 'غير محدد' }}
                                            </span>
                                        </td>

                                        <!-- Price -->
                                        <td>
                                            @if($ad->price)
                                                <span class="fw-bold text-success">
                                                    <i class="iconoir-dollar-circle me-1"></i>${{ number_format($ad->price, 0) }}
                                                </span>
                                            @else
                                                <span class="text-muted">
                                                    <i class="iconoir-minus-circle me-1"></i>غير محدد
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @if($ad->is_featured)
                                                <span class="badge bg-warning">
                                                    <i class="iconoir-star me-1"></i>مميز
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="iconoir-circle me-1"></i>عادي
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Date -->
                                        <td>
                                            <small class="text-muted">
                                                <i class="iconoir-calendar me-1"></i>{{ $ad->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('ads.show', $ad) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="عرض الإعلان">
                                                    <i class="iconoir-eye"></i>
                                                </a>
                                                <a href="{{ route('ads.edit', $ad) }}" 
                                                   class="btn btn-outline-warning btn-sm" 
                                                   title="تعديل الإعلان">
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
                            <i class="iconoir-media-image-list fs-1 text-muted mb-3"></i>
                            <h6 class="text-muted">لا يوجد إعلانات</h6>
                            <p class="text-muted">لم ينشر هذا المستخدم أي إعلانات بعد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
