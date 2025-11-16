@extends('dashboard.master')

@section('title', 'الملف الشخصي')

@push('styles')
<style>
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .profile-avatar:hover {
        border-color: #007bff;
        transform: scale(1.05);
    }
    
    .avatar-upload-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .avatar-upload-btn:hover {
        background: #0056b3;
        transform: scale(1.1);
    }
    
    .form-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 25px;
        border: 1px solid #e9ecef;
    }
    
    .section-title {
        color: #495057;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
    }
    
    .logo-container {
        position: relative;
        display: inline-block;
        cursor: pointer;
        overflow: hidden;
        border-radius: 50%;
    }
    
    .logo-container img {
        transition: all 0.3s ease;
    }
    
    .logo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 50%;
    }
    
    .logo-container:hover .logo-overlay {
        opacity: 1;
    }
    
    .logo-overlay i {
        font-size: 20px;
        margin-bottom: 5px;
    }
    
    .logo-overlay span {
        font-size: 12px;
    }
    
    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endpush

@section('content')
{{-- Page Title --}}
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">الملف الشخصي</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active">الملف الشخصي</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Success Messages --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Profile Avatar Section --}}
<div class="row justify-content-center mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body text-center">
                <div class="profile-avatar-container mb-3">
                    <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets-dashboard/images/users/avatar-1.jpg') }}" 
                         alt="Profile Avatar" 
                         class="rounded-circle" 
                         width="150" 
                         height="150"
                         id="profileAvatarPreview"
                         style="object-fit: cover; border: 4px solid #f8f9fa;">
                    
                    <button type="button" class="avatar-upload-btn" onclick="document.getElementById('avatarInput').click()">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
                
                <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                <p class="text-muted mb-3">{{ Auth::user()->email }}</p>
                
                {{-- Avatar Upload Form --}}
                <form action="{{ route('dashboard.profile.updateAvatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    <input type="file" 
                           name="image" 
                           id="avatarInput" 
                           accept="image/*" 
                           class="d-none"
                           onchange="previewAndSubmitAvatar(this)">
                </form>
                
                @if(Auth::user()->image)
                    <form action="{{ route('dashboard.profile.deleteAvatar') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف الصورة؟')">
                            <i class="fas fa-trash me-1"></i>
                            حذف الصورة
                        </button>
                    </form>
                @endif
                
                @error('image')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

{{-- Profile Forms Section --}}
<div class="row">
    <div class="col-lg-6 mb-4">
        {{-- Personal Information Form --}}
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    البيانات الشخصية
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.profile.updateProfile') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">الاسم الكامل</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', Auth::user()->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', Auth::user()->email) }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">رقم الهاتف</label>
                        <input type="text" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', Auth::user()->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="city" class="form-label">المدينة</label>
                        <input type="text" 
                               class="form-control @error('city') is-invalid @enderror" 
                               id="city" 
                               name="city" 
                               value="{{ old('city', Auth::user()->city) }}">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        {{-- Password Change Form --}}
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-lock me-2"></i>
                    تغيير كلمة المرور
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.profile.updatePassword') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" 
                               name="current_password" 
                               required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">كلمة المرور الجديدة</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" 
                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-1"></i>
                            تغيير كلمة المرور
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewAndSubmitAvatar(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSizeMB = 2;
        const fileSizeMB = file.size / 1024 / 1024; // Convert to MB
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('نوع الملف غير مدعوم. يرجى اختيار صورة بصيغة JPG, PNG, أو WebP.');
            return false;
        }
        
        // Validate file size
        if (fileSizeMB > maxSizeMB) {
            alert(`حجم الملف كبير جداً. الحد الأقصى المسموح هو ${maxSizeMB} ميجابايت.`);
            return false;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profileAvatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
        
        // Auto-submit the form after preview
        document.getElementById('avatarForm').submit();
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            // You can add visual feedback here
        });
    }
    
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.setCustomValidity('كلمات المرور غير متطابقة');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            if (alert.querySelector('.btn-close')) {
                alert.querySelector('.btn-close').click();
            }
        });
    }, 5000);
});

function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    return strength;
}
</script>
@endpush