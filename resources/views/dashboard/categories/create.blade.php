@extends('dashboard.master')

@section('title', 'إضافة فئة جديدة')

@push('styles')
<style>
    .form-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-radius: 12px;
    }
    .section-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    .form-floating > label {
        color: #6c757d;
    }
    .image-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    .image-upload-area:hover {
        border-color: #28a745;
        background: #f0fff4;
    }
    .image-upload-area.dragover {
        border-color: #28a745;
        background: #f0fff4;
    }
    .image-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        margin-top: 1rem;
    }
    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>
@endpush

@section('content')
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">الفئات</a></li>
                    <li class="breadcrumb-item active">إضافة فئة جديدة</li>
                </ol>
            </nav>
            <h2 class="mb-0">إضافة فئة جديدة</h2>
            <p class="text-muted">أضف فئة جديدة إلى النظام</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                <i class="iconoir-arrow-right me-1"></i> العودة للقائمة
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card">
                <div class="section-header">
                    <h5 class="mb-0"><i class="iconoir-plus me-2"></i>معلومات الفئة الجديدة</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- اسم الفئة -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="اسم الفئة" 
                                           required>
                                    <label for="name">اسم الفئة *</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- الوصف -->
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              placeholder="وصف الفئة"
                                              style="height: 100px">{{ old('description') }}</textarea>
                                    <label for="description">وصف الفئة</label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- رفع الصورة -->
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label fw-semibold mb-3">
                                    <i class="iconoir-media-image me-1 text-success"></i>
                                    صورة الفئة
                                </label>
                                <div class="image-upload-area" onclick="document.getElementById('logo').click()">
                                    <input type="file" 
                                           id="logo" 
                                           name="logo" 
                                           class="d-none @error('logo') is-invalid @enderror"
                                           accept="image/*"
                                           onchange="previewImage(this)">
                                    <div id="upload-content">
                                        <i class="iconoir-cloud-upload fs-1 text-muted mb-2"></i>
                                        <h6 class="text-muted">اضغط لرفع صورة أو اسحب الصورة هنا</h6>
                                        <small class="text-muted">
                                            الصيغ المدعومة: JPG, PNG, GIF, SVG, WEBP<br>
                                            الحد الأقصى: 2MB
                                        </small>
                                    </div>
                                    <div id="image-preview" class="d-none">
                                        <img id="preview-img" class="image-preview" alt="معاينة الصورة">
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeImage()">
                                                <i class="iconoir-trash me-1"></i>إزالة الصورة
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @error('logo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- حالة الفئة -->
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
                                        تفعيل الفئة
                                    </label>
                                    <small class="text-muted d-block">إذا كانت مفعلة، ستظهر الفئة في الموقع</small>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between gap-3">
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                        <i class="iconoir-cancel me-2"></i> إلغاء
                                    </a>
                                    <button type="submit" class="btn btn-success btn-lg px-4 shadow">
                                        <i class="iconoir-plus me-2"></i> إضافة الفئة
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
    // Image preview function
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('upload-content').classList.add('d-none');
                document.getElementById('image-preview').classList.remove('d-none');
                document.getElementById('preview-img').src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove image function
    function removeImage() {
        document.getElementById('image').value = '';
        document.getElementById('upload-content').classList.remove('d-none');
        document.getElementById('image-preview').classList.add('d-none');
        document.getElementById('preview-img').src = '';
    }

    // Drag and drop functionality
    const uploadArea = document.querySelector('.image-upload-area');
    
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('image').files = files;
            previewImage(document.getElementById('image'));
        }
    });
</script>
@endpush
