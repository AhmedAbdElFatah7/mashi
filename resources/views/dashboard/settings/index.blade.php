@extends('dashboard.master')

@section('title', 'إعدادات الموقع')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">إعدادات الموقع</h4>
                        <p class="text-muted mb-0">إدارة الإعدادات الأساسية للموقع</p>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- عنوان الموقع -->
                        <div class="col-md-6 mb-4">
                            <div class="card border">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <i class="iconoir-text me-2"></i>عنوان الموقع
                                    </h5>
                                    <label class="form-label fw-bold">عنوان الموقع</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="title" 
                                           value="{{ old('title', $settings->title ?? '') }}" 
                                           required>
                                    <small class="text-muted">العنوان الرئيسي للموقع</small>
                                </div>
                            </div>
                        </div>

                        <!-- وصف الموقع -->
                        <div class="col-md-6 mb-4">
                            <div class="card border">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <i class="iconoir-text-box me-2"></i>وصف الموقع
                                    </h5>
                                    <label class="form-label fw-bold">وصف الموقع</label>
                                    <textarea class="form-control" 
                                              name="description" 
                                              rows="4">{{ old('description', $settings->description ?? '') }}</textarea>
                                    <small class="text-muted">وصف مختصر عن الموقع وخدماته</small>
                                </div>
                            </div>
                        </div>

                        <!-- شعار الموقع -->
                        <div class="col-12 mb-4">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="card-title text-primary mb-1">
                                                <i class="iconoir-media-image me-2"></i>شعار الموقع
                                            </h5>
                                            <small class="text-muted">الشعار الرئيسي للموقع (يفضل PNG أو JPG)</small>
                                        </div>
                                        @if($settings && $settings->logo)
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteLogo()">
                                                <i class="iconoir-trash me-1"></i>حذف الشعار
                                            </button>
                                        @endif
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">رفع شعار جديد</label>
                                            <input type="file" 
                                                   class="form-control" 
                                                   name="logo" 
                                                   accept="image/*">
                                        </div>
                                        
                                        @if($settings && $settings->logo)
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">الشعار الحالي</label>
                                                <div class="border rounded p-3 text-center">
                                                    <img src="{{ asset('storage/' . $settings->logo) }}" 
                                                         alt="شعار الموقع" 
                                                         class="img-fluid"
                                                         style="max-height: 100px;">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="iconoir-check me-2"></i>حفظ الإعدادات
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
function deleteLogo() {
    if (confirm('هل أنت متأكد من حذف الشعار؟')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("settings.delete-logo") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
