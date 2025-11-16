@extends('dashboard.master')

@section('title', 'صفحة من نحن')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between bg-primary bg-gradient rounded-3 p-3 p-md-4 text-white shadow-sm">
            <div>
                <h4 class="mb-1">
                    <i class="iconoir-info-circle me-2"></i>
                    صفحة من نحن
                </h4>
                <p class="mb-0 text-white-50">إدارة محتوى صفحة من نحن الذي يظهر في واجهة الموقع بطريقة منظمة واحترافية</p>
            </div>
            <div class="mt-3 mt-md-0">
                <span class="badge bg-light text-primary fw-semibold px-3 py-2">
                    <i class="iconoir-edit-pencil me-1"></i>
                    يمكن تحرير كل قسم بشكل مستقل
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3 py-md-3">
                <div class="row text-center g-3 g-md-0">
                    <div class="col-6 col-md-3">
                        <div class="d-flex flex-column align-items-center">
                            <span class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                <i class="iconoir-info-circle"></i>
                            </span>
                            <small class="fw-semibold">القسم الرئيسي</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="d-flex flex-column align-items-center">
                            <span class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                <i class="iconoir-target"></i>
                            </span>
                            <small class="fw-semibold">الرسالة</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mt-2 mt-md-0">
                        <div class="d-flex flex-column align-items-center">
                            <span class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                <i class="iconoir-eye-alt"></i>
                            </span>
                            <small class="fw-semibold">الرؤية</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mt-2 mt-md-0">
                        <div class="d-flex flex-column align-items-center">
                            <span class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                <i class="iconoir-stats-report"></i>
                            </span>
                            <small class="fw-semibold">الإحصائيات</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
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

                <div class="row">
                    <!-- فورم القسم الرئيسي -->
                    <div class="col-lg-6 mb-4">
                        <form action="{{ route('settings.about-us.update') }}" method="POST" class="h-100">
                            @csrf
                            @method('PUT')
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-primary mb-3">
                                        <i class="iconoir-info-circle me-2"></i>القسم الرئيسي
                                    </h5>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">العنوان الرئيسي</label>
                                        <input type="text" class="form-control" name="main_title" value="{{ old('main_title', $about->main_title ?? '') }}">
                                        <small class="text-muted">عنوان جذاب يعرّف بالموقع أو الشركة</small>
                                    </div>
                                    <div class="mb-3 flex-grow-1">
                                        <label class="form-label fw-bold">الوصف الرئيسي</label>
                                        <textarea class="form-control" name="main_description" rows="4">{{ old('main_description', $about->main_description ?? '') }}</textarea>
                                        <small class="text-muted">نص تعريفي عن من أنتم وما الذي تقدمونه</small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                        <small class="text-muted">آخر تحديث: {{ optional($about)->updated_at ? $about->updated_at->format('Y-m-d H:i') : 'لم يتم الحفظ بعد' }}</small>
                                        <button type="submit" class="btn btn-primary btn-sm px-4">
                                            <i class="iconoir-check me-2"></i>حفظ القسم الرئيسي
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- فورم الرسالة -->
                    <div class="col-lg-6 mb-4">
                        <form action="{{ route('settings.about-us.update') }}" method="POST" class="h-100">
                            @csrf
                            @method('PUT')
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-success mb-3">
                                        <i class="iconoir-target me-2"></i>الرسالة
                                    </h5>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">عنوان الرسالة</label>
                                        <input type="text" class="form-control" name="mission_title" value="{{ old('mission_title', $about->mission_title ?? '') }}">
                                    </div>
                                    <div class="mb-3 flex-grow-1">
                                        <label class="form-label fw-bold">نص الرسالة</label>
                                        <textarea class="form-control" name="mission_description" rows="4">{{ old('mission_description', $about->mission_description ?? '') }}</textarea>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                        <small class="text-muted">يمكنك توضيح سبب وجودكم وما تقدمونه للمستخدمين</small>
                                        <button type="submit" class="btn btn-success btn-sm px-4">
                                            <i class="iconoir-check me-2"></i>حفظ بيانات الرسالة
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- فورم الرؤية -->
                    <div class="col-lg-6 mb-4">
                        <form action="{{ route('settings.about-us.update') }}" method="POST" class="h-100">
                            @csrf
                            @method('PUT')
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-info mb-3">
                                        <i class="iconoir-eye-alt me-2"></i>الرؤية
                                    </h5>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">عنوان الرؤية</label>
                                        <input type="text" class="form-control" name="vision_title" value="{{ old('vision_title', $about->vision_title ?? '') }}">
                                    </div>
                                    <div class="mb-3 flex-grow-1">
                                        <label class="form-label fw-bold">نص الرؤية</label>
                                        <textarea class="form-control" name="vision_description" rows="4">{{ old('vision_description', $about->vision_description ?? '') }}</textarea>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                        <small class="text-muted">صف رؤيتك المستقبلية للمشروع أو المنصة</small>
                                        <button type="submit" class="btn btn-info text-white btn-sm px-4">
                                            <i class="iconoir-check me-2"></i>حفظ بيانات الرؤية
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- فورم الإحصائيات -->
                    <div class="col-lg-6 mb-4">
                        <form action="{{ route('settings.about-us.update') }}" method="POST" class="h-100">
                            @csrf
                            @method('PUT')
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-warning mb-3">
                                        <i class="iconoir-stats-report me-2"></i>الإحصائيات السريعة
                                    </h5>

                                    <div class="row g-3 flex-grow-1">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">عنوان الإحصائية 1</label>
                                            <input type="text" class="form-control" name="stat_1_label" value="{{ old('stat_1_label', $about->stat_1_label ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">قيمة الإحصائية 1</label>
                                            <input type="text" class="form-control" name="stat_1_value" value="{{ old('stat_1_value', $about->stat_1_value ?? '') }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">عنوان الإحصائية 2</label>
                                            <input type="text" class="form-control" name="stat_2_label" value="{{ old('stat_2_label', $about->stat_2_label ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">قيمة الإحصائية 2</label>
                                            <input type="text" class="form-control" name="stat_2_value" value="{{ old('stat_2_value', $about->stat_2_value ?? '') }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">عنوان الإحصائية 3</label>
                                            <input type="text" class="form-control" name="stat_3_label" value="{{ old('stat_3_label', $about->stat_3_label ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">قيمة الإحصائية 3</label>
                                            <input type="text" class="form-control" name="stat_3_value" value="{{ old('stat_3_value', $about->stat_3_value ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                        <small class="text-muted">اعرض أرقاماً تعبر عن إنجازاتكم (عملاء، إعلانات، مدن...)</small>
                                        <button type="submit" class="btn btn-warning btn-sm px-4">
                                            <i class="iconoir-check me-2"></i>حفظ الإحصائيات
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

