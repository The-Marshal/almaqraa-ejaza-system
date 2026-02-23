@extends('layouts.mainapp')

@section('content')
@admin
<style>
    /* ==========================================================================
       1. تنسيقات العرض على المتصفح (Screen Styles)
       ========================================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');
    
    .report-wrapper { font-family: 'Inter', 'Segoe UI', Tahoma, sans-serif; background-color: #fcfcfc; }
    
    .report-card { 
        border: 1px solid #eef2f6; 
        border-radius: 20px; 
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); 
        background: #fff;
        overflow: hidden;
    }

    .header-section {
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        padding: 25px 30px;
    }
    .report-title { color: #1e293b; font-weight: 800; font-size: 1.25rem; }

    .filter-bar { background: #f8fafc; border-radius: 15px; padding: 20px; margin: 20px 30px; border: 1px solid #f1f5f9; }
    .form-select-custom {
        border-radius: 10px; border: 1px solid #e2e8f0; padding: 10px 15px; font-weight: 600; color: #475569;
    }

    .table-modern thead th {
        background: #f8fafc; color: #64748b; font-weight: 700; font-size: 0.75rem;
        text-transform: uppercase; padding: 18px; border: none;
    }
    .table-modern tbody td { 
        padding: 20px 18px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;
        color: #334155; font-size: 0.95rem;
    }

    .student-fullname { font-weight: 800; color: #0f172a; font-size: 1rem; margin-bottom: 4px; display: block; }

    /* كود النشط الذكي (النقطة المضيئة) */
    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 12px;
        margin-bottom: 4px;
    }
    .status-active { color: #10b981; background: rgba(16, 185, 129, 0.1); }
    .status-inactive { color: #94a3b8; background: rgba(148, 163, 184, 0.1); }

    .dot {
        width: 8px; height: 8px; border-radius: 50%; display: inline-block;
    }
    .dot-active {
        background-color: #10b981;
        box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
        animation: pulse-green 2s infinite;
    }
    .dot-inactive { background-color: #94a3b8; }

    @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    
    /* مربعات الإنجاز (الأيقونات فقط) */
    .achievement-icon-box {
        display: flex;
        align-items: center;
        gap: 5px;
        background: #f8fafc;
        padding: 5px 12px;
        border-radius: 8px;
        border: 1px solid #eef2f6;
        min-width: 65px;
        justify-content: center;
    }
    .achievement-val { font-weight: 800; font-size: 1rem; }
    .ach-icon { font-size: 0.85rem; opacity: 0.8; }
    .text-pages { color: #3b82f6; }
    .text-ayahs { color: #10b981; }

    .id-wrapper { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 6px; }
    .id-badge {
        display: inline-flex; align-items: center; background: #fdfdfd; border: 1px solid #e2e8f0;
        border-radius: 8px; padding: 4px 10px; font-size: 0.75rem;
    }
    .id-badge i { margin-left: 6px; font-size: 0.85rem; }
    .icon-residence { color: #ef4444; } 
    .icon-nationality { color: #3b82f6; } 

    .date-text { font-weight: 700; color: #1e293b; background: #f8fafc; padding: 6px 12px; border-radius: 8px; }

    @media print {
        .no-print, .filter-bar, .page-title-box, .navbar, .footer, .header-section button { 
            display: none !important; 
        }
        .status-indicator { background: none !important; padding: 0 !important; }
        .dot { border: 1px solid #000; animation: none !important; }

        .report-wrapper, .container-fluid, .report-card {
            padding: 0 !important; margin: 0 !important; border: none !important; width: 100% !important; background: white !important;
        }

        .table-modern thead th, 
        .table-modern tbody td {
            font-size: 11px !important;
            padding: 8px 4px !important;
            border: 1px solid #dee2e6 !important;
            -webkit-print-color-adjust: exact;
        }

        .achievement-icon-box { 
            background: none !important; 
            border: none !important; 
            padding: 0 !important; 
            min-width: auto !important;
            gap: 2px !important;
        }
        .achievement-val { font-size: 11px !important; }
        .ach-icon { font-size: 9px !important; }

        .date-column { width: 95px !important; min-width: 95px !important; }
        .date-text { background: none !important; padding: 0 !important; font-size: 11px !important; }
        .date-text i { display: none; }
        
        tr { page-break-inside: avoid !important; }
    }
</style>

<div class="page-title-box no-print">
    <div class="row align-items-center">
        <div class="col-md-12">
            <h6 class="page-title">لوحة التحكم</h6>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item active"> التقارير الشهرية </li>
            </ol>
        </div>
    </div>
</div>

<div class="container-fluid py-4 report-wrapper" dir="rtl">
    <div class="card report-card">
        
        <div class="print-header-metadata d-none d-print-block text-center mb-4">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <div class="text-start">
                    <h4 class="fw-bold text-primary mb-0">التقرير الشهري للإنجاز</h4>
                    <small>المقرأة الإلكترونية العالمية</small>
                </div>
                <div class="text-end small">
                    <strong>التاريخ:</strong> {{ date('Y/m/d') }}
                </div>
            </div>
            <div class="row g-0 bg-light p-2 border rounded small">
                <div class="col-4"><strong>المعلم:</strong> @php $t = $teachers->firstWhere('id', $fTeacher); @endphp {{ $t ? $t->name : '-' }}</div>
                <div class="col-4 border-start border-end"><strong>الشهر:</strong> {{ $fMonth }}</div>
                <div class="col-4"><strong>السنة:</strong> {{ $fYear }}</div>
            </div>
        </div>
      
        <div class="header-section d-flex justify-content-between align-items-center no-print">
            <div>
                <h5 class="report-title mb-1 text-primary"> التقارير الشهرية </h5>
                <p class="text-muted small mb-0 font-weight-bold">سجلات المقرأة الإلكترونية العالمية</p>
            </div>
            <button onclick="window.print()" class="btn btn-outline-warning fw-bold px-4 rounded-pill">
                <i class="fas fa-print me-2"></i> طباعة التقرير
            </button>
        </div>

        <form action="{{ route('enrollments.monthly_report') }}" method="GET" class="filter-bar no-print shadow-sm">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-primary">فضيلة الشيخ / الشيخة</label>
                    <select name="teacher_id" class="form-select form-select-custom shadow-sm" required>
                        <option value="">-- اختر --</option>
                        <optgroup label="♂ رجال">
                            @foreach($teachers->where('gender', 'M') as $t)
                                <option value="{{ $t->id }}" {{ $fTeacher == $t->id ? 'selected' : '' }}>الشيخ/ {{ $t->name }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="♀ نساء">
                            @foreach($teachers->where('gender', 'F') as $t)
                                <option value="{{ $t->id }}" {{ $fTeacher == $t->id ? 'selected' : '' }}>الشيخة/ {{ $t->name }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-primary">التاريخ</label>
                    <div class="input-group">
                        <select name="month" class="form-select form-select-custom">
                            @for($m=1; $m<=12; $m++) <option value="{{ $m }}" {{ $fMonth == $m ? 'selected' : '' }}>{{ $m }}</option> @endfor
                        </select>
                        <select name="year" class="form-select form-select-custom">
                            @for($y=date('Y'); $y>=2025; $y--) <option value="{{ $y }}" {{ $fYear == $y ? 'selected' : '' }}>{{ $y }}</option> @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill py-2">تحديث</button>
                </div>
            </div>
        </form>

        @if($fTeacher)
        <div class="table-responsive">
            <table class="table table-modern align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 40px;">#</th>
                        <th class="text-start">الطالب</th>
                        <th class="text-center">القراءة/الرواية</th>
                        <th class="text-center">الإنجاز</th>
                        <th class="text-center">آخر سورة</th>
                        <th class="text-center date-column">تاريخ بدء الإجازة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $index => $item)
                    <tr>
                        <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                        <td class="text-start">
                            @if($item->is_active)
                                <div class="status-indicator status-active">
                                    <span class="dot dot-active"></span> منجز نشط
                                </div>
                            @else
                                <div class="status-indicator status-inactive">
                                    <span class="dot dot-inactive"></span> خامل
                                </div>
                            @endif
                            
                            <span class="student-fullname">{{ $item->user->name }} {{ $item->user->lastname }}</span>
                            <div class="id-wrapper">
                                <span class="id-badge"><i class="fas fa-home icon-residence"></i> <span class="id-label">الإقامة:</span> <span class="id-value">{{ $countriesMap[$item->user->country] ?? '-' }}</span></span>
                                <span class="id-badge"><i class="fas fa-passport icon-nationality"></i> <span class="id-label">الجنسية:</span> <span class="id-value">{{ $countriesMap[$item->user->nationality] ?? '-' }}</span></span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-primary border px-2 py-1 fw-bold">{{ $item->requested_path_name }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                <div class="achievement-icon-box" title="عدد الصفحات">
                                    <i class="fas fa-book-open ach-icon text-pages"></i>
                                    <span class="achievement-val text-pages">{{ $item->monthly_pages }}</span>
                                </div>
                                <div class="achievement-icon-box" title="عدد الآيات">
                                    <i class="fas fa-feather-alt ach-icon text-ayahs"></i>
                                    <span class="achievement-val text-ayahs">{{ $item->monthly_ayahs }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="fw-bold text-dark">
                                <i class="fas fa-book-open text-muted me-1 small"></i>
                                {{ $item->surah_name ?? '-' }}
                            </div>
                            <small class="text-muted" style="font-size: 0.7rem;">أخر سورة مسجلة</small>
                        </td>
                        <td class="text-center date-column">
                            <div class="date-text">
                                <i class="far fa-calendar-alt no-print me-1 small text-muted"></i>
                                {{ $item->ejazah_start ? \Carbon\Carbon::parse($item->ejazah_start)->format('Y/m/d') : '-' }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5">لا توجد بيانات متاحة لهذا البحث</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5 p-4 d-none d-print-block">
            <div class="row text-muted small fw-bold">
                <div class="col-4 border-top pt-2 text-center">توقيع المعلم</div>
                <div class="col-4 border-top pt-2 text-center">إدارة المقرأة</div>
                <div class="col-4 border-top pt-2 text-center">ختم الاعتماد</div>
            </div>
        </div>
        @endif
    </div>
</div>
@else
<div class="container py-5 text-center">
    <div class="alert alert-danger">عذراً، لا تملك صلاحية الوصول لهذه الصفحة</div>
</div>
@endadmin
@endsection