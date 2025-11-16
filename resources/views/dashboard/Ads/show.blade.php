@extends('dashboard.master')

@section('title', 'تفاصيل الإعلان')

@push('styles')
<style>
    .image-gallery img {
        border-radius: 10px;
        transition: transform 0.3s ease;
    }
    .image-gallery img:hover {
        transform: scale(1.05);
    }
    .info-card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }
    .info-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.9rem;
    }
    .info-value {
        font-size: 1rem;
        color: #212529;
    }
    .price-display {
        font-size: 2rem;
        font-weight: 700;
        color: #28a745;
    }
    .featured-badge {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        font-size: 1rem;
        padding: 0.5rem 1rem;
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
                    <li class="breadcrumb-item active">{{ Str::limit($ad->title, 30) }}</li>
                </ol>
            </nav>
            <h2 class="mb-0">{{ $ad->title }}</h2>
            @if($ad->is_featured)
                <span class="badge featured-badge mt-2">إعلان مميز</span>
            @endif
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('ads.edit', $ad) }}" class="btn btn-warning">
                    <i class="iconoir-edit me-1"></i> تعديل
                </a>
                <form method="POST" action="{{ route('ads.destroy', $ad) }}" 
                      class="d-inline" 
                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الإعلان؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="iconoir-trash me-1"></i> حذف
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Images Section -->
        <div class="col-lg-8">
            <div class="card info-card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">صور الإعلان</h5>
                    @php
                        $images = is_string($ad->images) ? json_decode($ad->images, true) : $ad->images;
                    @endphp
                    
                    @if(is_array($images) && !empty($images))
                        <div class="image-gallery">
                            <div class="row g-3">
                                @foreach($images as $index => $image)
                                <div class="col-md-6">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         class="img-fluid w-100" 
                                         style="height: 250px; object-fit: cover;" 
                                         alt="صورة الإعلان {{ $index + 1 }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5 bg-light rounded">
                            <i class="iconoir-camera fs-1 text-muted mb-3"></i>
                            <p class="text-muted">لا توجد صور لهذا الإعلان</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="card info-card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">وصف الإعلان</h5>
                    @if($ad->description)
                        <p class="mb-0">{{ $ad->description }}</p>
                    @else
                        <p class="text-muted mb-0">لا يوجد وصف لهذا الإعلان</p>
                    @endif
                </div>
            </div>

            <!-- Additional Info -->
            @if($ad->additional_info)
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title mb-3">معلومات إضافية</h5>
                    @php
                        $additionalInfo = is_string($ad->additional_info) ? json_decode($ad->additional_info, true) : $ad->additional_info;
                    @endphp
                    
                    @if(is_array($additionalInfo) && !empty($additionalInfo))
                        <div class="row g-3">
                            @foreach($additionalInfo as $key => $value)
                            <div class="col-md-6">
                                <div class="info-label">{{ $key }}</div>
                                <div class="info-value">{{ $value }}</div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">{{ $ad->additional_info }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Details Sidebar -->
        <div class="col-lg-4">
            <!-- Price & Category -->
            <div class="card info-card mb-4">
                <div class="card-body text-center">
                    @if($ad->price)
                        <div class="price-display mb-3">${{ number_format($ad->price, 2) }}</div>
                    @else
                        <div class="price-display mb-3 text-muted">السعر غير محدد</div>
                    @endif
                    
                    <span class="badge bg-primary fs-6 px-3 py-2">
                        {{ $ad->category->name ?? 'فئة غير محددة' }}
                    </span>
                </div>
            </div>

            <!-- Seller Information -->
            <div class="card info-card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">معلومات البائع</h5>
                    
                    <div class="mb-3">
                        <div class="info-label">اسم البائع</div>
                        <div class="info-value">{{ $ad->seller_name }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="info-label">رقم الهاتف</div>
                        <div class="info-value">{{ $ad->seller_phone }}</div>
                    </div>

                    <!-- Contact Options -->
                    <div class="mb-3">
                        <div class="info-label">خيارات التواصل</div>
                        <div class="mt-2">
                            @if($ad->allow_mobile_messages)
                                <span class="badge bg-success me-1">رسائل الجوال</span>
                            @endif
                            @if($ad->allow_whatsapp_messages)
                                <span class="badge bg-success">واتساب</span>
                            @endif
                            @if(!$ad->allow_mobile_messages && !$ad->allow_whatsapp_messages)
                                <span class="text-muted">غير محدد</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="card info-card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">معلومات المستخدم</h5>
                    
                    <div class="mb-3">
                        <div class="info-label">الاسم</div>
                        <div class="info-value">{{ $ad->user->name }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="info-label">البريد الإلكتروني</div>
                        <div class="info-value">{{ $ad->user->email }}</div>
                    </div>

                    @if($ad->user->phone)
                    <div class="mb-3">
                        <div class="info-label">الهاتف</div>
                        <div class="info-value">{{ $ad->user->phone }}</div>
                    </div>
                    @endif

                    @if($ad->user->city)
                    <div class="mb-3">
                        <div class="info-label">المدينة</div>
                        <div class="info-value">{{ $ad->user->city }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Ad Meta -->
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title mb-3">تفاصيل الإعلان</h5>
                    
                    <div class="mb-3">
                        <div class="info-label">تاريخ النشر</div>
                        <div class="info-value">{{ $ad->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="info-label">آخر تحديث</div>
                        <div class="info-value">{{ $ad->updated_at->format('d/m/Y H:i') }}</div>
                    </div>

                    @if($ad->type)
                    <div class="mb-3">
                        <div class="info-label">نوع الإعلان</div>
                        <div class="info-value">{{ $ad->type }}</div>
                    </div>
                    @endif

                    <div class="mb-0">
                        <div class="info-label">حالة الإعلان</div>
                        <div class="info-value">
                            @if($ad->is_featured)
                                <span class="badge bg-warning">مميز</span>
                            @else
                                <span class="badge bg-secondary">عادي</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
