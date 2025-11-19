@extends('dashboard.master')

@section('title', 'سحب إعلان من رابط')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-link me-2"></i>
                            سحب إعلان من رابط
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <p class="text-muted mb-4">
                            أدخل رابط الإعلان وحدد الفئة المناسبة ثم اضغط على زر <strong>سحب الإعلان</strong>.
                        </p>

                        <form id="import-ad-form">
                            <!-- حقل رابط الإعلان -->
                            <div class="mb-4">
                                <label for="ad_url" class="form-label fw-bold">
                                    <i class="fas fa-globe text-primary me-2"></i>
                                    رابط الإعلان
                                </label>
                                <input
                                    type="url"
                                    name="url"
                                    id="ad_url"
                                    class="form-control form-control-lg"
                                    placeholder="مثال: https://example.com/ad/123"
                                    required
                                >
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    الرجاء إدخال رابط صحيح للإعلان
                                </div>
                            </div>

                            <!-- حقل الفئة -->
                            <div class="mb-4">
                                <label for="category" class="form-label fw-bold">
                                    <i class="fas fa-folder text-primary me-2"></i>
                                    الفئة
                                </label>
                                <select
                                    name="category"
                                    id="category"
                                    class="form-select form-select-lg"
                                    required
                                >
                                    <option value="" selected disabled>اختر الفئة المناسبة</option>
                                    <option value="electronics">إلكترونيات</option>
                                    <option value="vehicles">مركبات</option>
                                    <option value="real-estate">عقارات</option>
                                    <option value="furniture">أثاث</option>
                                    <option value="fashion">أزياء</option>
                                    <option value="services">خدمات</option>
                                    <option value="jobs">وظائف</option>
                                    <option value="other">أخرى</option>
                                </select>
                            </div>

                            <!-- زر الإرسال -->
                            <div class="d-grid gap-2">
                                <button 
                                    type="submit" 
                                    id="import-submit-btn" 
                                    class="btn btn-primary btn-lg"
                                >
                                    <span class="default-text">
                                        <i class="fas fa-download me-2"></i>
                                        سحب الإعلان
                                    </span>
                                    <span class="loading-text d-none">
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        جاري سحب الإعلان...
                                    </span>
                                </button>
                            </div>
                        </form>

                        <!-- معلومات إضافية -->
                        <div class="alert alert-info mt-4 mb-0" role="alert">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>نصيحة:</strong> تأكد من صحة الرابط والفئة قبل السحب للحصول على أفضل النتائج.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- تأكد من تحميل SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('import-ad-form');
                const submitBtn = document.getElementById('import-submit-btn');
                const defaultText = submitBtn.querySelector('.default-text');
                const loadingText = submitBtn.querySelector('.loading-text');

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // عرض حالة التحميل
                    defaultText.classList.add('d-none');
                    loadingText.classList.remove('d-none');
                    submitBtn.setAttribute('disabled', 'disabled');

                    // محاكاة عملية السحب (2 ثانية)
                    setTimeout(() => {
                        // عرض رسالة النجاح
                        Swal.fire({
                            icon: 'success',
                            title: 'تم سحب الإعلان بنجاح',
                            text: 'تم سحب الإعلان وإضافته إلى قاعدة البيانات بنجاح.',
                            confirmButtonText: 'حسناً',
                            confirmButtonColor: '#0d6efd',
                            timer: 3000,
                            timerProgressBar: true
                        }).then(() => {
                            // إعادة تحميل الصفحة
                            window.location.reload();
                        });
                    }, 2000);
                });
            });
        </script>
    @endpush
@endsection