@extends('dashboard.master')

@section('title', 'تعديل الإعلان')

@push('styles')
<style>
    .form-card {
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 15px;
        overflow: hidden;
    }
    .form-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    .form-section:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .section-title {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        border-bottom: 3px solid #667eea;
        padding-bottom: 0.75rem;
        display: flex;
        align-items: center;
    }
    .section-title i {
        margin-right: 0.5rem;
        color: #667eea;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .image-upload-area {
        border: 3px dashed #dee2e6;
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        position: relative;
        overflow: hidden;
    }
    .image-upload-area:hover {
        border-color: #667eea;
        background: linear-gradient(135deg, #f0f4ff 0%, #ffffff 100%);
        transform: translateY(-2px);
    }
    .image-upload-area.dragover {
        border-color: #667eea;
        background: linear-gradient(135deg, #f0f4ff 0%, #ffffff 100%);
        transform: scale(1.02);
    }
    .image-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    .image-preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .image-preview-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    .image-preview-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }
    .image-remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .image-remove-btn:hover {
        background: #dc3545;
        transform: scale(1.1);
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    .btn-secondary {
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .required-asterisk {
        color: #dc3545;
        font-weight: bold;
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
                    <li class="breadcrumb-item"><a href="{{ route('ads.show', $ad) }}">{{ Str::limit($ad->title, 20) }}</a></li>
                    <li class="breadcrumb-item active">تعديل</li>
                </ol>
            </nav>
            <h2 class="mb-0">تعديل الإعلان</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('ads.show', $ad) }}" class="btn btn-secondary">
                <i class="iconoir-arrow-left me-1"></i> العودة
            </a>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('ads.update', $ad) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="iconoir-edit-pencil"></i>
                        المعلومات الأساسية
                    </h5>
                    
                    <div class="mb-4">
                        <label for="title" class="form-label">
                            عنوان الإعلان <span class="required-asterisk">*</span>
                        </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $ad->title) }}" 
                               placeholder="أدخل عنوان الإعلان..." required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">وصف الإعلان</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $ad->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="price" class="form-label">السعر</label>
                            <div class="input-group">
                                <span class="input-group-text">💰</span>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price', $ad->price) }}" 
                                       step="0.01" min="0" placeholder="0.00">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="category_id" class="form-label">
                                الفئة <span class="required-asterisk">*</span>
                            </label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">اختر الفئة</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $ad->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Images Section -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="iconoir-media-image"></i>
                        صور الإعلان
                    </h5>
                    
                    <!-- Upload Images -->
                    <div class="mb-4">
                        <label class="form-label">إضافة صور جديدة</label>
                        <div class="image-upload-area" onclick="document.getElementById('images').click()">
                            <input type="file" 
                                   id="images" 
                                   name="images[]" 
                                   class="d-none @error('images') is-invalid @enderror"
                                   accept="image/*"
                                   multiple
                                   onchange="previewImages(this)">
                            <div id="upload-content">
                                <i class="iconoir-cloud-upload fs-1 text-muted mb-3"></i>
                                <h5 class="text-muted mb-2">اضغط لرفع الصور أو اسحب الصور هنا</h5>
                                <p class="text-muted mb-0">
                                    <small>
                                        الصيغ المدعومة: JPG, PNG, GIF, WEBP<br>
                                        الحد الأقصى: 5MB لكل صورة | حد أقصى 10 صور<br>
                                        <strong>ملاحظة: الصور الجديدة ستُضاف للصور الموجودة</strong>
                                    </small>
                                </p>
                            </div>
                            <div id="new-images-preview" class="image-preview-container" style="display: none;"></div>
                        </div>
                        @error('images')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Seller Information -->
                <div class="form-section">
                    <h5 class="section-title">معلومات البائع</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="seller_name" class="form-label">اسم البائع <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('seller_name') is-invalid @enderror" 
                                   id="seller_name" name="seller_name" value="{{ old('seller_name', $ad->seller_name) }}" required>
                            @error('seller_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="seller_phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('seller_phone') is-invalid @enderror" 
                                   id="seller_phone" name="seller_phone" value="{{ old('seller_phone', $ad->seller_phone) }}" required>
                            @error('seller_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                                   {{ old('is_featured', $ad->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                إعلان مميز
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="allow_mobile_messages" name="allow_mobile_messages" value="1"
                                   {{ old('allow_mobile_messages', $ad->allow_mobile_messages) ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_mobile_messages">
                                السماح برسائل الجوال
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="allow_whatsapp_messages" name="allow_whatsapp_messages" value="1"
                                   {{ old('allow_whatsapp_messages', $ad->allow_whatsapp_messages) ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_whatsapp_messages">
                                السماح برسائل واتساب
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Current Images -->
                @php
                    $images = is_string($ad->images) ? json_decode($ad->images, true) : $ad->images;
                @endphp
                
                @if(is_array($images) && !empty($images))
                <div class="form-section">
                    <h5 class="section-title">الصور الحالية</h5>
                    <div class="row g-2" id="currentImages">
                        @foreach($images as $index => $image)
                        <div class="col-6 image-item" data-index="{{ $index }}">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     class="img-fluid rounded" 
                                     style="height: 100px; object-fit: cover; width: 100%;" 
                                     alt="صورة الإعلان">
                                <button type="button" 
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-image-btn"
                                        data-index="{{ $index }}"
                                        style="padding: 2px 6px; font-size: 12px;">
                                    <i class="iconoir-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <small class="text-muted">انقر على أيقونة الحذف لإزالة الصورة نهائياً</small>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="form-section">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="iconoir-check me-1"></i> حفظ التغييرات
                        </button>
                        <a href="{{ route('ads.show', $ad) }}" class="btn btn-outline-secondary">
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
// Preview new images
function previewImages(input) {
    const previewContainer = document.getElementById('new-images-preview');
    const uploadContent = document.getElementById('upload-content');
    
    if (input.files && input.files.length > 0) {
        previewContainer.innerHTML = '';
        previewContainer.style.display = 'grid';
        uploadContent.style.display = 'none';
        
        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageItem = document.createElement('div');
                    imageItem.className = 'image-preview-item';
                    imageItem.setAttribute('data-index', index);
                    imageItem.innerHTML = `
                        <img src="${e.target.result}" alt="معاينة الصورة">
                        <button type="button" class="image-remove-btn" data-index="${index}">
                            <i class="iconoir-xmark"></i>
                        </button>
                    `;
                    previewContainer.appendChild(imageItem);
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        previewContainer.style.display = 'none';
        uploadContent.style.display = 'block';
    }
}

// Remove new image from preview
function removeNewImage(index) {
    const input = document.getElementById('images');
    const dt = new DataTransfer();
    
    // Create new file list without the removed file
    Array.from(input.files).forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    // Update input files
    input.files = dt.files;
    
    // Re-render preview with updated files
    previewImages(input);
}

// Handle remove button clicks for new images
document.addEventListener('click', function(e) {
    if (e.target.closest('.image-remove-btn')) {
        const button = e.target.closest('.image-remove-btn');
        const index = parseInt(button.getAttribute('data-index'));
        removeNewImage(index);
    }
});

// Handle delete button clicks for existing images
document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-image-btn')) {
        e.preventDefault();
        e.stopPropagation();
        
        const button = e.target.closest('.delete-image-btn');
        const index = parseInt(button.getAttribute('data-index'));
        const imageItem = button.closest('.image-item');
        
        if (confirm('هل أنت متأكد من حذف هذه الصورة؟ لا يمكن التراجع عن هذا الإجراء.')) {
            // Show loading state
            button.innerHTML = '<i class="iconoir-loading"></i>';
            button.disabled = true;
            
            // Send AJAX request to delete image
            fetch(`{{ route('ads.delete-image', $ad) }}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    image_index: index
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the image item with animation
                    imageItem.style.transition = 'all 0.3s ease';
                    imageItem.style.opacity = '0';
                    imageItem.style.transform = 'scale(0.8)';
                    
                    setTimeout(() => {
                        imageItem.remove();
                        
                        // Re-index remaining images
                        const remainingImages = document.querySelectorAll('.image-item');
                        remainingImages.forEach((item, newIndex) => {
                            item.setAttribute('data-index', newIndex);
                            const deleteBtn = item.querySelector('.delete-image-btn');
                            if (deleteBtn) {
                                deleteBtn.setAttribute('data-index', newIndex);
                            }
                        });
                        
                        // Check if no images left
                        if (remainingImages.length === 0) {
                            const currentImagesSection = document.querySelector('#currentImages').closest('.form-section');
                            if (currentImagesSection) {
                                currentImagesSection.remove();
                            }
                        }
                    }, 300);
                    
                    // Show success message
                    showMessage(data.message || 'تم حذف الصورة بنجاح', 'success');
                } else {
                    // Show error message
                    showMessage(data.message || 'حدث خطأ أثناء حذف الصورة', 'error');
                    
                    // Reset button
                    button.innerHTML = '<i class="iconoir-trash"></i>';
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('حدث خطأ أثناء حذف الصورة', 'error');
                
                // Reset button
                button.innerHTML = '<i class="iconoir-trash"></i>';
                button.disabled = false;
            });
        }
    }
});

// Show message function
function showMessage(message, type) {
    // Create alert element
    const alert = document.createElement('div');
    alert.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert at top of page
    const container = document.querySelector('.container-xxl') || document.querySelector('.container');
    if (container) {
        container.insertBefore(alert, container.firstChild);
        
        // Auto dismiss after 3 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 3000);
    }
}

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.querySelector('.image-upload-area');
    const fileInput = document.getElementById('images');
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    // Handle dropped files
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight(e) {
        uploadArea.classList.add('dragover');
    }
    
    function unhighlight(e) {
        uploadArea.classList.remove('dragover');
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        fileInput.files = files;
        previewImages(fileInput);
    }
});
</script>
@endpush

