@extends('dashboard.master')

@section('title', 'لوحة التحكم')

@push('styles')
    <style>
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-card.success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .stats-card.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stats-card.info {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .chart-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .avatar-sm {
            width: 40px;
            height: 40px;
            font-size: 16px;
            font-weight: 600;
        }
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.12);
            transition: all 0.3s ease;
        }
    </style>
@endpush

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ $totalAds }}</h4>
                            <p class="mb-0">إجمالي الإعلانات</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="iconoir-megaphone fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ $totalCategories }}</h4>
                            <p class="mb-0">الفئات</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="iconoir-list fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ $totalUsers }}</h4>
                            <p class="mb-0">المستخدمين</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="iconoir-user fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ $featuredAds }}</h4>
                            <p class="mb-0">الإعلانات المميزة</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="iconoir-star fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-xl-8">
            <div class="card chart-container">
                <div class="card-header">
                    <h5 class="card-title mb-0">الإعلانات شهرياً</h5>
                </div>
                <div class="card-body">
                    <canvas id="adsChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4">
            <div class="card chart-container">
                <div class="card-header">
                    <h5 class="card-title mb-0">الإعلانات حسب الفئة</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Content Row -->
    <div class="row">
        <!-- Recent Ads Cards -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">الإعلانات المميزة الحديثة</h5>
                    <span class="badge bg-primary">{{ $recentAds->count() }} إعلان</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($recentAds->take(4) as $ad)
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center">
                                                <i class="iconoir-megaphone"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1 fw-semibold">{{ Str::limit($ad->title, 25) }}</h6>
                                            <p class="text-muted mb-2 small">{{ Str::limit($ad->description ?? 'لا يوجد وصف', 40) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-success-subtle text-success">{{ $ad->category->name ?? 'عام' }}</span>
                                                @if($ad->price)
                                                    <span class="fw-bold text-primary">${{ number_format($ad->price, 0) }}</span>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $ad->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-4">
                                <i class="iconoir-megaphone fs-1 text-muted mb-3"></i>
                                <p class="text-muted">لا توجد إعلانات حديثة</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity & Stats -->
        <div class="col-xl-4">
            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">النشاط الأخير</h5>
                </div>
                <div class="card-body">
                    @forelse($recentUsers->take(3) as $user)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 fs-14">{{ $user->name }}</h6>
                            <small class="text-muted">انضم {{ $user->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="badge bg-success-subtle text-success">جديد</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-3">
                        <i class="iconoir-user fs-2 text-muted mb-2"></i>
                        <p class="text-muted mb-0">لا يوجد نشاط حديث</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare data for charts
    @php
        $monthlyDataArray = array_fill(1, 12, 0);
        foreach($adsPerMonth as $item) {
            $monthlyDataArray[$item->month] = $item->count;
        }
    @endphp
    const monthlyData = {!! json_encode(array_values($monthlyDataArray)) !!};
    const categoryLabels = {!! json_encode($adsByCategory->pluck('name')) !!};
    const categoryData = {!! json_encode($adsByCategory->pluck('ads_count')) !!};

    // Ads Per Month Chart
    const adsCtx = document.getElementById('adsChart').getContext('2d');
    const adsChart = new Chart(adsCtx, {
        type: 'line',
        data: {
            labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
            datasets: [{
                label: 'الإعلانات المنشأة',
                data: monthlyData,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                backgroundColor: [
                    '#667eea',
                    '#4facfe',
                    '#f093fb',
                    '#43e97b',
                    '#ffeaa7',
                    '#fd79a8'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush








