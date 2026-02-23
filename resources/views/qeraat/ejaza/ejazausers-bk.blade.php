@extends('layouts.mainapp')

@section('content')

                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('ejazah.users')}}">طلاب الإجازة</a></li>
                                        
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                            <div class="col-12">




@if(sizeof($data) > 0)

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الطالب</th>
                                <th scope="col">الحالة</th>
                                <th scope="col">مجاز؟</th>
                                <th scope="col">الإجازة التي حصلت عليها</th>
                                <th scope="col">الروايات</th>
                                <th scope="col">الإجازة التي ترغب البدء بها</th>
                                <th scope="col">الروايات</th>
                                <th scope="col">المرفقات</th>
                                
                                <th scope="col">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td>
                                    <?php
                                    $usersName = DB::table('users')->WHERE('id',$item->user_id)->first();
                                    ?>
                                    
                                    {{$usersName->name}} {{$usersName->lastname}}</td>
                                    
                               <td>
                                   @if($item->status == 'ACCEPT')
                                    <b class="text-success">مقبول</b>
                                   @elseif($item->status == 'NEED')
                                    <b class="text-warning">يحتاج مقابلة</b>
                                   @elseif($item->status == 'REJECT')
                                    <b class="text-danger">مرفوض</b>
                                   @else
                                    <b class="text-info">جديد</b>
                                   @endif
                               </td>
                                    
                                <td>
                                    @if($item->ejaza_type == 'yes')
                                    <span class="fw-bold">نعم</span>
                                    @else
                                    <span class="fw-bold">لا</span>
                                    @endif
                                </td>
                                
                                <td>

                                    @if($item->ejaza_type == 'yes')
                                    <?php
                                    $qeraat = DB::table(config('constants.tables.TBL_QERAAT'))->WHERE('id',$item->yesqeraat2)->first();
                                    ?>
                                    
                                    {{$qeraat->name}}
                                    @else
                                    -
                                    @endif
                               </td>                                
                                
                                <td>
                                    @if($item->ejaza_type == 'yes')
                                    
                                    <?php
                                    $exrwh = explode(",",$item->yesriwayat2);
                                    $riwayat = DB::table(config('constants.tables.TBL_SQERAAT'))->whereIn('id',$exrwh)->get();
                                    ?>
                                    @foreach($riwayat as $rwh)
                                    {{$rwh->name}} -
                                    @endforeach
                                    
                                    @else
                                    -
                                    @endif
                               </td>   
                                
                                <td>
                                    @if($item->ejaza_type == 'yes')
                                    
                                    <?php
                                    $qeraat2 = DB::table(config('constants.tables.TBL_QERAAT'))->WHERE('id',$item->yesqeraat)->first();
                                    ?>
                                    
                                    {{$qeraat2->name}}
                                    @else
                                    <?php
                                    $qeraat2 = DB::table(config('constants.tables.TBL_QERAAT'))->WHERE('id',$item->noqeraat)->first();
                                    ?>
                                    {{$qeraat2->name}}
                                    @endif
                               </td>
                               
                                <td>
                                    @if($item->ejaza_type == 'yes')
                                    
                                    <?php
                                    $exrwh1 = explode(",",$item->yesriwayat);
                                    $riwayat2 = DB::table(config('constants.tables.TBL_SQERAAT'))->whereIn('id',$exrwh1)->get();
                                    ?>
                                    @foreach($riwayat2 as $rwh)
                                    {{$rwh->name}} -
                                    @endforeach
                                    
                                    @else
                                    
                                    <?php
                                    $exrwh1 = explode(",",$item->noriwayah);
                                    $riwayat2 = DB::table(config('constants.tables.TBL_SQERAAT'))->whereIn('id',$exrwh1)->get();
                                    ?>
                                    @foreach($riwayat2 as $rwh)
                                    {{$rwh->name}} -
                                    @endforeach
                                    
                                    @endif
                               </td>
                               
                                <td>
                                    @if($item->ejaza_type == 'yes')
                                    <a href="{{$item->yesfile}}">
                                        نموذج ارفاق الإجازة
                                    </a>
                                    
                                    @else
                                    <a href="{{$item->nofile}}">
                                        شهادة الجزرية
                                    </a>
                                    -
                                    <a href="{{$item->nofile1}}">
                                        شهادة أصول القراءة  
                                    </a>
                                    @endif
                               </td>

                                <td>
                                    <a href="#"
                                    class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ejaza-user-{{$item->id}}">قبول</a> -
                                    <a href="#" onclick="return confirm('هل انت متأكد')" class="btn btn-warning btn-sm">يحتاج مقابلة</a> -
                                    <a href="#" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">رفض</a> 
                                </td>
                            </tr>
               
               

<!-- Modal -->
<div class="modal fade" id="ejaza-user-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">اختيار المعلم </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="" method="POST">
            <select class="form-select" aria-label="Default select example">
                @foreach($teachers as $row)
                    <option>{{$row->name}}</option>
                @endforeach

            </select>
        </form>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
        <button type="button" class="btn btn-primary">حفظ</button>
      </div>
    </div>
  </div>
</div>
               
               
                            
                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@else
<div class="alert alert-danger" role="alert">
    لاتوجد بيانات
</div>
@endif





                            </div>
                        </div>
                        <!-- end row -->

@endsection
