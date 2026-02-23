@extends('layouts.mainapp')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-chart-line me-2 text-primary"></i> تقرير متابعة المعلمين والطلاب</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('enrollments.teacher-report') }}" method="GET" class="row g-3 align-items-end mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold">اختر المعلم:</label>
                    <select name="teacher_id" class="form-select">
                        <option value="">-- عرض جميع المعلمين --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ $selectedTeacherId == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> عرض التقرير</button>
                </div>
            </form>

            <hr>

            @forelse($reportData as $teacherId => $students)
                @php $teacher = $students->first()->teacher; @endphp
                <div class="teacher-section mb-5">
                    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded border-start border-primary border-4 mb-3">
                        <h6 class="mb-0 fw-bold">المعلم: <span class="text-primary">{{ $teacher->name ?? 'غير محدد' }}</span></h6>
                        <span class="badge bg-dark">عدد الطلاب: {{ $students->count() }}</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>اسم الطالب</th>
                                    <th>المسار</th>
                                    <th>آخر موضع (سورة)</th>
                                    <th>حالة المسار</th>
                                    <th>القرار الفني</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $st)
                                <tr>
                                    <td>{{ $st->user->name }}</td>
                                    <td><span class="small">{{ $st->requested_path_name }}</span></td>
                                    <td>{{ $st->surah_name ?: 'لم يبدأ' }}</td>
                                    <td>
                                        @if($st->status == 'completed')
                                            <span class="badge bg-success">مكتمل</span>
                                        @elseif($st->status == 'pending_interview')
                                            <span class="badge bg-warning text-dark">بانتظار مقابلة</span>
                                        @else
                                            <span class="badge bg-info text-white">مستمر</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $st->teacher_decision == 'qualified' ? 'مؤهل' : ($st->teacher_decision ?: 'قيد التقييم') }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">لا توجد بيانات لعرضها بناءً على الاختيار</div>
            @endforelse
        </div>
    </div>
</div>
@endsection