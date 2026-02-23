<div class="interview-result-container" dir="rtl">
    <div class="text-center mb-4">
        @php
            $decisionKey = $result->decision ?? ($result->interviewer_recommendation ?? 'none');
            $status = [
                'qualified' => ['color' => '#28a745', 'icon' => 'fa-check-circle', 'bg' => '#eafaf1', 'text' => 'مؤهل لقراءة الإجازة'],
                'refer_to_teacher' => ['color' => '#ffc107', 'icon' => 'fa-user-graduate', 'bg' => '#fffdf5', 'text' => 'يوجَّه لتعديل الملاحظات'],
                'review_theory' => ['color' => '#17a2b8', 'icon' => 'fa-book-open', 'bg' => '#f0faff', 'text' => 'مراجعة التجويد النظري'],
                'not_qualified' => ['color' => '#dc3545', 'icon' => 'fa-times-circle', 'bg' => '#fdf2f2', 'text' => 'غير مؤهل حالياً'],
            ][$decisionKey] ?? ['color' => '#6c757d', 'icon' => 'fa-info-circle', 'bg' => '#f8f9fa', 'text' => $decisionKey];
        @endphp

        <div class="decision-badge shadow-sm" style="background-color: {{ $status['bg'] }}; border: 2px solid {{ $status['color'] }};">
            <i class="fas {{ $status['icon'] }} fa-2x mb-2" style="color: {{ $status['color'] }}"></i>
            <h5 class="fw-bold mb-0" style="color: {{ $status['color'] }}">{{ $status['text'] }}</h5>
            <small class="text-muted">نتيجة المقابلة النهائية</small>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach(['theory_level' => 'التجويد النظري', 'recitation_level' => 'مستوى التلاوة', 'hifz_level' => 'مستوى الحفظ'] as $key => $label)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 evaluation-card">
                    <span class="text-muted small mb-2 d-block">{{ $label }}</span>
                    @php $val = $result->$key ?? ''; @endphp
                    <div class="stars mb-1">
                        @if($val == 'excellent')
                            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                            <div class="badge bg-success-soft text-success mt-2">ممتاز</div>
                        @elseif($val == 'good')
                            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="far fa-star text-muted"></i>
                            <div class="badge bg-info-soft text-info mt-2">جيد</div>
                        @else
                            <i class="fas fa-star text-warning"></i><i class="far fa-star text-muted"></i><i class="far fa-star text-muted"></i>
                            <div class="badge bg-warning-soft text-warning mt-2">ضعيف</div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-tasks me-2"></i> تفاصيل أسئلة التجويد</h6>
        </div>
        <div class="card-body bg-light-50">
            <div class="row row-cols-1 row-cols-md-5 g-3 text-center">
                @for($i=1; $i<=5; $i++)
                    @php $q = "q{$i}_answer"; $ans = $result->$q ?? 'غير محدد'; @endphp
                    <div class="col">
                        <div class="p-2 rounded-3 border bg-white shadow-xs">
                            <div class="small text-muted mb-1">سؤال {{ $i }}</div>
                            @if($ans == 'صح')
                                <span class="badge rounded-circle bg-success p-2"><i class="fas fa-check"></i></span>
                            @elseif($ans == 'خطأ')
                                <span class="badge rounded-circle bg-danger p-2"><i class="fas fa-times"></i></span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="notes-section p-3 rounded-4 border-start border-4 border-success bg-white shadow-sm">
        <h6 class="fw-bold text-success mb-2"><i class="fas fa-edit me-2"></i> الملاحظات والتوصيات:</h6>
        <p class="text-dark mb-0 lh-lg" style="font-size: 0.95rem; white-space: pre-line;">
            {{ $result->notes ?: 'لا توجد ملاحظات إضافية مسجلة.' }}
        </p>
    </div>

    <div class="mt-4 d-flex justify-content-between align-items-center opacity-75 border-top pt-3 px-2">
        <span class="small"><i class="far fa-calendar-alt me-1"></i> تاريخ المقابلة: <b>{{ $result->interview_date ?? '---' }}</b></span>
        
    </div>
</div>

<style>
    .interview-result-container { font-family: 'Montserrat-Arabic', sans-serif; }
    .decision-badge { padding: 20px; border-radius: 20px; display: inline-block; min-width: 250px; }
    .rounded-4 { border-radius: 15px !important; }
    .bg-success-soft { background-color: #e8f5e9; }
    .bg-info-soft { background-color: #e3f2fd; }
    .bg-warning-soft { background-color: #fffde7; }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .evaluation-card { transition: transform 0.3s ease; }
    .evaluation-card:hover { transform: translateY(-5px); }
    .bg-light-50 { background-color: #fafbfc; }
</style>