@extends('dashboard.master')

@section('title', 'إضافة مدير جديد')

@push('styles')
<style>
    .form-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-radius: 12px;
    }
    .section-header {
        background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px 12px 0 0;
        margin: -1.25rem -1.25rem 1.5rem -1.25rem;
    }
    .form-floating > .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }
    .form-floating > .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    .form-floating > label {
        color: #6c757d;
    }
    .btn-create {
        background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-create:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }
    .form-check-input:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .role-card {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .role-card:hover {
        border-color: #dc3545;
        background-color: #fff5f5;
    }
    .role-card.selected {
        border-color: #dc3545;
        background-color: #fff5f5;
    }
    .role-card input[type="radio"] {
        display: none;
    }
</style>
@endpush

@section('content')
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">المديرين</a></li>
                    <li class="breadcrumb-item active">إضافة مدير جديد</li>
                </ol>
            </nav>
            <h2 class="mb-0">إضافة مدير جديد</h2>
            <p class="text-muted">أضف مدير جديد إلى النظام</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary">
                <i class="iconoir-arrow-right me-1"></i> العودة للقائمة
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card">
                <div class="section-header">
                    <h5 class="mb-0"><i class="iconoir-user-star me-2"></i>معلومات المدير الجديد</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admins.store') }}">
                        @csrf
                        
                        <div class="row">
                            <!-- الاسم -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="الاسم الكامل" 
                                           required>
                                    <label for="name">الاسم الكامل *</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- البريد الإلكتروني -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="البريد الإلكتروني" 
                                           required>
                                    <label for="email">البريد الإلكتروني *</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- رقم الهاتف -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}" 
                                           placeholder="رقم الهاتف" 
                                           required>
                                    <label for="phone">رقم الهاتف *</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- كلمة المرور -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="كلمة المرور" 
                                           required>
                                    <label for="password">كلمة المرور *</label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- تأكيد كلمة المرور -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="تأكيد كلمة المرور" 
                                           required>
                                    <label for="password_confirmation">تأكيد كلمة المرور *</label>
                                </div>
                            </div>
                        </div>

                        <!-- اختيار الصلاحية -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold mb-3">
                                    <i class="iconoir-crown me-1 text-danger"></i>
                                    اختر صلاحية المدير *
                                </label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="role-card" for="role_admin">
                                            <input type="radio" 
                                                   id="role_admin" 
                                                   name="role" 
                                                   value="admin" 
                                                   {{ old('role', 'admin') == 'admin' ? 'checked' : '' }}>
                                            <div class="text-center">
                                                <i class="iconoir-user-star fs-1 text-primary mb-2"></i>
                                                <h6 class="fw-bold">مدير</h6>
                                                <small class="text-muted">
                                                    صلاحيات إدارية أساسية<br>
                                                    إدارة المحتوى والمستخدمين
                                                </small>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="role-card" for="role_super_admin">
                                            <input type="radio" 
                                                   id="role_super_admin" 
                                                   name="role" 
                                                   value="super_admin" 
                                                   {{ old('role') == 'super_admin' ? 'checked' : '' }}>
                                            <div class="text-center">
                                                <i class="iconoir-crown fs-1 text-danger mb-2"></i>
                                                <h6 class="fw-bold">مدير عام</h6>
                                                <small class="text-muted">
                                                    صلاحيات كاملة<br>
                                                    إدارة النظام والمديرين
                                                </small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @error('role')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- حالة المدير -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="status" 
                                           name="status" 
                                           value="1" 
                                           {{ old('status', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="status">
                                        <i class="iconoir-check-circle me-1 text-success"></i>
                                        تفعيل المدير
                                    </label>
                                    <small class="text-muted d-block">إذا كان مفعلاً، يمكن للمدير تسجيل الدخول واستخدام النظام</small>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between gap-3">
                                    <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                        <i class="iconoir-cancel me-2"></i> إلغاء
                                    </a>
                                    <button type="submit" class="btn btn-success btn-lg px-4 shadow">
                                        <i class="iconoir-user-star me-2"></i> إضافة المدير
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // تأكيد كلمة المرور
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        
        if (password !== confirmPassword) {
            this.setCustomValidity('كلمات المرور غير متطابقة');
        } else {
            this.setCustomValidity('');
        }
    });

    // تحديث تأكيد كلمة المرور عند تغيير كلمة المرور الأصلية
    document.getElementById('password').addEventListener('input', function() {
        const confirmPassword = document.getElementById('password_confirmation');
        if (confirmPassword.value) {
            confirmPassword.dispatchEvent(new Event('input'));
        }
    });

    // Role card selection
    document.querySelectorAll('.role-card').forEach(function(card) {
        card.addEventListener('click', function() {
            // Remove selected class from all cards
            document.querySelectorAll('.role-card').forEach(function(c) {
                c.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            this.classList.add('selected');
            
            // Check the radio button
            this.querySelector('input[type="radio"]').checked = true;
        });
    });

    // Initialize selected card on page load
    document.addEventListener('DOMContentLoaded', function() {
        const checkedRadio = document.querySelector('input[name="role"]:checked');
        if (checkedRadio) {
            checkedRadio.closest('.role-card').classList.add('selected');
        }
    });
</script>
@endpush
