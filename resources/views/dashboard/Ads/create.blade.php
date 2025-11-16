@extends('dashboard.master')

@section('title', 'إضافة إعلان جديد')

@push('styles')
<style>
    .form-card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }
    .form-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .section-title {
        color: #495057;
        font-weight: 600;
        margin-bottom: 1rem;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 0.5rem;
    }
    .image-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .image-upload-area:hover {
        border-color: #007bff;
        background: #e3f2fd;
    }
    .image-upload-area.dragover {
        border-color: #28a745;
        background: #d4edda;
    }
    .image-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1rem;
    }
    .image-preview-item {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #dee2e6;
    }
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .image-remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        font-size: 12px;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('ads.index') }}">الإعلانات</a></li>
                    <li class="breadcrumb-item active">إضافة إعلان جديد</li>
                </ol>
            </nav>
            <h2 class="mb-0">إضافة إعلان جديد</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('ads.index') }}" class="btn btn-secondary">
                <i class="iconoir-arrow-left me-1"></i> العودة للإعلانات
            </a>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('ads.store') }}" enctype="multipart/form-data" id="adForm">
        @csrf
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="form-section">
                    <h5 class="section-title">المعلومات الأساسية</h5>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان الإعلان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">وصف الإعلان</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="اكتب وصفاً مفصلاً للإعلان...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="price" class="form-label">السعر</label>
                            <div class="input-group">
                                <span class="input-group-text">ريال</span>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price') }}" 
                                       step="0.01" min="0" placeholder="0.00">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">الفئة</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id">
                                <option value="">اختر الفئة</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="type" class="form-label">نوع الإعلان</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                            <option value="">اختر النوع</option>
                            <option value="للبيع" {{ old('type') == 'للبيع' ? 'selected' : '' }}>للبيع</option>
                            <option value="للشراء" {{ old('type') == 'للشراء' ? 'selected' : '' }}>للشراء</option>
                            <option value="للإيجار" {{ old('type') == 'للإيجار' ? 'selected' : '' }}>للإيجار</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Images Section -->
                <div class="form-section">
                    <h5 class="section-title">صور الإعلان</h5>
                    
                    <div class="image-upload-area" id="imageUploadArea">
                        <i class="iconoir-camera fs-1 text-muted mb-3"></i>
                        <h6>اسحب الصور هنا أو انقر للاختيار</h6>
                        <p class="text-muted mb-0">يمكنك رفع حتى 5 صور (JPG, PNG, GIF - حد أقصى 2MB لكل صورة)</p>
                        <input type="file" id="imageInput" name="images[]" multiple accept="image/*" style="display: none;">
                    </div>
                    
                    <div class="image-preview" id="imagePreview"></div>
                    
                    @error('images.*')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Seller Information -->
                <div class="form-section">
                    <h5 class="section-title">معلومات البائع</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="seller_name" class="form-label">اسم البائع <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('seller_name') is-invalid @enderror" 
                                   id="seller_name" name="seller_name" value="{{ old('seller_name') }}" required>
                            @error('seller_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="seller_phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('seller_phone') is-invalid @enderror" 
                                   id="seller_phone" name="seller_phone" value="{{ old('seller_phone') }}" 
                                   placeholder="05xxxxxxxx" required>
                            @error('seller_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="form-section">
                    <h5 class="section-title">معلومات إضافية</h5>
                    
                    <div class="mb-3">
                        <label for="additional_info" class="form-label">معلومات إضافية</label>
                        <textarea class="form-control @error('additional_info') is-invalid @enderror" 
                                  id="additional_info" name="additional_info" rows="3" 
                                  placeholder="أي معلومات إضافية تريد إضافتها...">{{ old('additional_info') }}</textarea>
                        @error('additional_info')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Settings -->
                <div class="form-section">
                    <h5 class="section-title">إعدادات الإعلان</h5>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                   {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                إعلان مميز
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="allow_mobile_messages" name="allow_mobile_messages" value="1"
                                   {{ old('allow_mobile_messages', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_mobile_messages">
                                السماح برسائل الجوال
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="allow_whatsapp_messages" name="allow_whatsapp_messages" value="1"
                                   {{ old('allow_whatsapp_messages', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_whatsapp_messages">
                                السماح برسائل واتساب
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="fee_agree" name="fee_agree" value="1"
                                   {{ old('fee_agree') ? 'checked' : '' }}>
                            <label class="form-check-label" for="fee_agree">
                                الموافقة على الرسوم
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-section">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="iconoir-check me-1"></i> نشر الإعلان
                        </button>
                        <a href="{{ route('ads.index') }}" class="btn btn-outline-secondary">
                            إلغاء
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageUploadArea = document.getElementById('imageUploadArea');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    let selectedFiles = [];

    // Click to upload
    imageUploadArea.addEventListener('click', function() {
        imageInput.click();
    });

    // Drag and drop functionality
    imageUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        imageUploadArea.classList.add('dragover');
    });

    imageUploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        imageUploadArea.classList.remove('dragover');
    });

    imageUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        imageUploadArea.classList.remove('dragover');
        
        const files = Array.from(e.dataTransfer.files);
        handleFiles(files);
    });

    // File input change
    imageInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        handleFiles(files);
    });

    function handleFiles(files) {
        // Filter image files only
        const imageFiles = files.filter(file => file.type.startsWith('image/'));
        
        // Limit to 5 images total
        const remainingSlots = 5 - selectedFiles.length;
        const filesToAdd = imageFiles.slice(0, remainingSlots);
        
        filesToAdd.forEach(file => {
            if (file.size > 2 * 1024 * 1024) { // 2MB limit
                alert(`الملف ${file.name} كبير جداً. الحد الأقصى 2MB`);
                return;
            }
            
            selectedFiles.push(file);
            displayImagePreview(file, selectedFiles.length - 1);
        });
        
        updateFileInput();
    }

    function displayImagePreview(file, index) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'image-preview-item';
            previewItem.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="image-remove-btn" onclick="removeImage(${index})">
                    <i class="iconoir-xmark"></i>
                </button>
            `;
            imagePreview.appendChild(previewItem);
        };
        reader.readAsDataURL(file);
    }

    window.removeImage = function(index) {
        selectedFiles.splice(index, 1);
        updateImagePreview();
        updateFileInput();
    };

    function updateImagePreview() {
        imagePreview.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            displayImagePreview(file, index);
        });
    }

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => {
            dt.items.add(file);
        });
        imageInput.files = dt.files;
    }
});
</script>
@endpush
