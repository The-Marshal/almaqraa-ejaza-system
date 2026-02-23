<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>الاسم الرباعي</th>
                <th>الاتصال</th>
                <th>بلد الإقامة / الجنسية</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }} {{ $user->mdlname }} {{ $user->thrdname }} {{ $user->lastname }}</td>
<td>
    <i class="fas fa-envelope fa-xs text-muted"></i> {{ $user->email }}
    <br>
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->mobile) }}" 
       target="_blank" 
       class="text-decoration-none text-success fw-bold">
        <i class="fab fa-whatsapp"></i> 
        <span dir="ltr">{{ $user->mobile }}</span>
    </a>
</td>
<td>
    {{ $user->country_name ?? 'غير محدد' }}
    <br>
    <small class="text-muted">الجنسية: {{ $user->nationality_name ?? 'غير محدد' }}</small>
</td>
                <td>
                    <button class="btn btn-sm btn-info" onclick='openUserModal(@json($user))'><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="deleteUser({{ $user->id }})"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {!! $users->links() !!}
</div>