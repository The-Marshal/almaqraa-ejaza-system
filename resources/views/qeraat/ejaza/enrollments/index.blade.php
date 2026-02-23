@extends('layouts.mainapp')

@section('content')
<?php
$path = config('constants.path.PATH_URL_EJAZAH'); 
?>

<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-12">
            <h6 class="page-title">لوحة التحكم</h6>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="#">طلبة الإجازة</a></li>
                <li class="breadcrumb-item active">إدارة الطلبات</li>
            </ol>
        </div>
    </div>
</div>

<div class="container-fluid py-4 text-end" dir="rtl">
    <div class="page-title-box mb-4">
        <h4 class="page-title text-primary text-start"><i class="fas fa-users-cog me-2"></i> إدارة طلبات الإجازة</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white p-0">
            
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body p-3">
        <form action="{{ route('enrollments.index') }}" method="GET" class="row g-2 align-items-end">
            {{-- 1. فلتر الشيخ --}}
            @if($isAdmin)
            <div class="col-md-2 col-sm-6">
                <select name="teacher_id" class="form-select form-select-sm border-secondary-subtle">
                    <option value="">كل المشايخ</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- 2. فلتر الجنس --}}
            @if($isAdmin || is_null($targetGender))
            <div class="col-md-1 col-sm-6">
                <select name="gender" class="form-select form-select-sm border-secondary-subtle">
                    <option value="">الجنس</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>ذكور</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>إناث</option>
                </select>
            </div>
            @endif

            {{-- 3. فلتر القراءة / الرواية (قائمة ذكية) --}}
            <div class="col-md-2 col-sm-6">
                <select name="reading" class="form-select form-select-sm border-secondary-subtle">
                    <option value="">كل القراءات / الروايات</option>
                    @foreach($searchOptions as $option)
                        <option value="{{ $option['value'] }}" {{ request('reading') == $option['value'] ? 'selected' : '' }}>
                            {{ $option['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 4. بلد الإقامة --}}
            <div class="col-md-2 col-sm-6">
                <select name="country_id" class="form-select form-select-sm border-secondary-subtle">
                    <option value="">بلد الإقامة (الكل)</option>
                    @foreach($countriesMap as $id => $name)
                        <option value="{{ $id }}" {{ request('country_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 5. الجنسية --}}
            <div class="col-md-2 col-sm-6">
                <select name="nationality_id" class="form-select form-select-sm border-secondary-subtle shadow-none">
                    <option value="">الجنسية (الكل)</option>
                    @foreach($countriesMap as $id => $name)
                        <option value="{{ $id }}" {{ request('nationality_id') == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 6. أزرار التحكم --}}
            <div class="col-md-2 col-sm-12 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                    <i class="fas fa-search me-1"></i> بحث
                </button>
                <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary btn-sm flex-grow-1" title="إلغاء الفلاتر">
                    <i class="fas fa-undo"></i>
                </a>
            </div>
        </form>
    </div>
</div>       
            
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                
                {{-- 1. طلبات جديدة --}}
                @if($isAdmin)
                <li class="nav-item">
                    <button class="nav-link active py-3 fw-bold" id="new-tab" data-bs-toggle="tab" data-bs-target="#newTab" type="button" role="tab">
                        <i class="fas fa-plus-circle me-1"></i> طلبات جديدة
                        <span class="badge rounded-pill bg-danger ms-1">{{ $newRequests->count() }}</span>
                    </button>
                </li>
                @endif

                {{-- 2. بانتظار المقابلة --}}
                <li class="nav-item">
                    <button class="nav-link {{ !$isAdmin ? 'active' : '' }} py-3 fw-bold" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pendingTab" type="button" role="tab">
                        <i class="fas fa-clock me-1"></i> المقابلات
                        <span class="badge rounded-pill bg-warning ms-1">{{ $pendingInterview->count() }}</span>
                    </button>
                </li>
                
                {{-- 3. المستمرون في الإجازة --}}
                <li class="nav-item">
                    <button class="nav-link py-3 fw-bold" id="activeEjaza-tab" data-bs-toggle="tab" data-bs-target="#activeEjazaTab" type="button" role="tab">
                        <i class="fas fa-book-reader me-1"></i> المستمرون في الإجازة
                        {{-- أضف السطر التالي هنا --}}
                        <span class="badge rounded-pill bg-info ms-1">{{ $activeInEjaza->count() }}</span>
                    </button>
                </li>

				{{-- 4. تاب قيد المشافهة الجديد --}}
				<li class="nav-item">
					<button class="nav-link py-3" id="pendingMushafaha-tab" data-bs-toggle="tab" data-bs-target="#inMushafahaTab" type="button" role="tab">
						<i class="fas fa-microphone-alt me-2 text-warning"></i> قيد المشافهة
						<span class="badge bg-warning ms-1">{{ $inMushafahaProcess->count() }}</span>
					</button>
				</li>

				{{-- 5. تاب المجازون (المعدل) --}}
				<li class="nav-item">
					<button class="nav-link py-3" id="mushafaha-tab" data-bs-toggle="tab" data-bs-target="#mushafahaTab" type="button" role="tab">
						<i class="fas fa-certificate me-2"></i> المجازون
						<span class="badge bg-success ms-1">{{ $completedMushafaha->count() }}</span>
					</button>
				</li>

                {{-- 6. غير مؤهل --}}
                @if($isAdmin)
                <li class="nav-item">
                    <button class="nav-link py-3 fw-bold" id="rej-tab" data-bs-toggle="tab" data-bs-target="#rejTab" type="button" role="tab">
                        <i class="fas fa-user-times me-1"></i> غير مؤهل
                        <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle ms-1">{{ $notQualified->count() }}</span>
                    </button>
                </li>
                @endif
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="myTabContent">
                
                @if($isAdmin)
                <div class="tab-pane fade show active" id="newTab">
                    @include('qeraat.ejaza.enrollments.partials.table', ['items' => $newRequests, 'allReadings' => $allReadings, 'allNarrations' => $allNarrations])
                </div>
                @endif

                <div class="tab-pane fade {{ !$isAdmin ? 'show active' : '' }}" id="pendingTab">
                    @include('qeraat.ejaza.enrollments.partials.table', ['items' => $pendingInterview, 'allReadings' => $allReadings, 'allNarrations' => $allNarrations])
                </div>

                <div class="tab-pane fade" id="activeEjazaTab">
                    @include('qeraat.ejaza.enrollments.partials.table', [
                            'items' => $activeInEjaza, 
                            'currentTab' => 'continuous', 'allReadings' => $allReadings, 'allNarrations' => $allNarrations 
                        ])                    
                </div>

				{{-- محتوى قيد المشافهة --}}
				<div class="tab-pane fade" id="inMushafahaTab">
					@include('qeraat.ejaza.enrollments.partials.table', ['items' => $inMushafahaProcess, 'allReadings' => $allReadings, 'allNarrations' => $allNarrations])
				</div>
				{{-- محتوى المجازون --}}
				<div class="tab-pane fade" id="mushafahaTab">
					@include('qeraat.ejaza.enrollments.partials.table', [
						'items' => $completedMushafaha, 
						'currentTab' => 'completed_mushafaha', 'allReadings' => $allReadings, 'allNarrations' => $allNarrations
					])
				</div>

                <div class="tab-pane fade" id="rejTab">
                    @include('qeraat.ejaza.enrollments.partials.table', ['items' => $notQualified, 'allReadings' => $allReadings, 'allNarrations' => $allNarrations])
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptSection')
<script>

// نعرف الدالة بشكل عام لضمان وصول المتصفح لها

</script>
@endsection