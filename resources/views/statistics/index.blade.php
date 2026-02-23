@extends('layouts.mainapp')

@section('cssSection')

@endsection

@section('content')

<div class="container-fluid py-4 text-center" dir="rtl">
    <h4 class="mb-4 text-primary text-start"><i class="fas fa-chart-line me-2"></i> إحصائيات النظام</h4>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 bg-white p-3 h-100">
                <small class="text-muted">إجمالي الطلاب (ذكر/أنثى)</small>
                <h3 class="text-primary mt-2">{{ $stats['male_students'] }} / {{ $stats['female_students'] }}</h3>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 bg-white p-3 h-100">
                <small class="text-muted">المعلمون (ذكر/أنثى)</small>
                <h3 class="text-success mt-2">{{ $stats['male_teachers'] }} / {{ $stats['female_teachers'] }}</h3>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 bg-white p-3 h-100">
                <small class="text-muted">قيد الدراسة / المجازون</small>
                <h3 class="text-info mt-2">{{ $stats['in_progress'] }} / {{ $stats['completed'] }}</h3>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 bg-white p-3 h-100">
                <small class="text-muted">الدول / الدورات</small>
                <h3 class="text-warning mt-2">{{ $stats['countries_count'] }} / {{ $stats['courses_count'] }}</h3>
            </div>
        </div>
    </div>

    <div class="row">


        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h6 class="text-danger">طلبات جديدة</h6>
                    <h2>{{ $stats['new_students'] }}</h2>
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-danger">طلاب غير مؤهلين</h6>
                    <h2>{{ $stats['not_qualified'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white font-weight-bold  text-start">توزيع الطلاب حسب الإجازة/الرواية</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>اسم المسار (الإجازة أو الرواية)</th>
                                <th class="text-center">عدد الطلاب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats['by_path'] as $path)
                            <tr>
                                <td>{{ $path->requested_path_name }}</td>
                                <td class="text-center"><span class="badge bg-soft-primary text-primary px-3">{{ $path->total }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scriptSection')

@endsection