@extends('layouts.mainapp')

@section('content')
<?php
$path = config('constants.path.PATH_URL_EJAZAH');
?>
                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                                        <li class="breadcrumb-item">
                                            <a href="#">طلبة الإجازة</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="#">المستمرين</a>
                                        </li>
                                        
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        


<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark"><i class="fas fa-user-check me-2 text-primary"></i> إدارة طلبات الإجازة</h2>
    </div>

    {{-- التبويبات --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white p-0">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active py-3 fw-bold" data-bs-toggle="tab" data-bs-target="#certified">
                        المجازون سابقاً <span class="badge bg-primary ms-1">{{$certified->count()}}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-3 fw-bold text-secondary" data-bs-toggle="tab" data-bs-target="#notCertified">
                        غير المجازين <span class="badge bg-secondary ms-1">{{$notCertified->count()}}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-3 fw-bold text-danger" data-bs-toggle="tab" data-bs-target="#rejected">
                        غير المؤهلين <span class="badge bg-danger ms-1">{{$notQualified->count()}}</span>
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="certified">
                    @include('qeraat.ejaza.enrollments.partials.table', ['items' => $certified, 'teachers' => $teachers])
                </div>
                <div class="tab-pane fade" id="notCertified">
                    @include('qeraat.ejaza.enrollments.partials.table', ['items' => $notCertified, 'teachers' => $teachers])
                </div>
                <div class="tab-pane fade" id="rejected">
                    @include('qeraat.ejaza.enrollments.partials.table', ['items' => $notQualified, 'teachers' => $teachers])
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scriptSection')
<script>
function toggleTeacherSelect(el, id) {
    document.getElementById('teacherSec' + id).style.display = (el.value === 'reject') ? 'none' : 'block';
}
</script>
@endsection