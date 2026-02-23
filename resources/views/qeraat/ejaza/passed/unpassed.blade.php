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
                                            <a href="#">غير المجتازين</a>
                                        </li>
                                        
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
                    <span class="" style="font-size: 1.3rem;margin-bottom: 13px;display: block;">
غير المجتازين
</span>




                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الطالب</th>
                                <th scope="col">نوع المشارك</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">رقم الجوال</th>
                                <th scope="col">القراءة / الرواية</th>
                                <th scope="col">الحالة</th>
                                <th scope="col">الشيخ/ـة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td @if($item->status == 'ACCEPT') class="bg-success text-white" @elseif($item->status == 'REJECT')  class="bg-danger text-white" @endif>
                                    <?php
                                    $usersName = DB::table('users')->WHERE('id',$item->user_id)->first();
                                    ?>
                                    
                                    <a href="#" class="btn btn-sm @if($item->status == 'ACCEPT' || $item->status == 'REJECT')  text-white @endif">  
                                    {{$usersName->name}} {{$usersName->lastname}}
                                    </a>
                                    
     
                                                                        
                                    
                                    </td>
                                        <td>
                                        @if($usersName->gender == 'female') 
                                            <span class="badge text-bg-danger">انثى</span>
                                        @else
                                            <span class="badge text-bg-warning">ذكر</span>
                                        @endif
                                    
                                    </td>
                                    <td><?= $countriesValue[array_search($usersName->country , $countriesKey)]; ?></td>
                                    <td>{{$usersName->mobile}}</td>
                              
                                <td class="sul ammar">
                                    

                                    @if($item->ejaza_type == 'yes')
                                        @if($item->yesqeraat != NULL)

                                        <?php
                                        $qeraat = DB::table(config('constants.tables.TBL_QERAAT'))->WHERE('id',$item->yesqeraat)->first();
                                        ?>
                                        @if($qeraat)
                                            {{$qeraat->name}}
                                        @endif  

                                        @else
                                          <?php
                                        $riwayah = DB::table(config('constants.tables.TBL_RIWAYAT'))->WHERE('id',$item->yesriwayat)->first();
                                        ?>
                                        @if($riwayah)
                                        {{$riwayah->name}}
                                        @endif
                                        
                                        
                                        @endif
                                    @else
                                        @if($item->noqeraat != NULL)
                                        <?php
                                        $qeraat = DB::table(config('constants.tables.TBL_QERAAT'))->WHERE('id',$item->noqeraat)->first();
                                        ?>
                                        @if($qeraat)
                                            {{$qeraat->name}}
                                        @endif                                        
                                            
                                        @else
                                      <?php
                                        $riwayah = DB::table(config('constants.tables.TBL_RIWAYAT'))->WHERE('id',$item->noriwayah)->first();
                                        ?>
                                        @if($riwayah)
                                        {{$riwayah->name}}
                                        @endif
                                            
                                        @endif
                                    @endif
                                    
                                </td>
    
                               <td>  
                                   @if($item->status == 'NEW')
                                    <b class="text-info">جديد</b>
                                   @elseif($item->status == 'WAIT')
                                    <b class="text-info">في إنتظار المقابلة</b>
                                   @elseif($item->status == 'PASS')
                                    <b class="text-info">مؤهل </b>
                                   @elseif($item->status == 'REDIRECT')
                                    <b class="text-info">يوجَّه إلى أحد المشايخ لتعديل الملاحظات</b>
                                   @elseif($item->status == 'REVIEW') 
                                    <b class="text-info">مراجعة التجويد النظري</b>
                                   @elseif($item->status == 'UNPASS')
                                    <b class="text-info">غير مؤهل</b>
                                   @elseif($item->status == 'ACCEPT')
                                    <b class="text-success">مقبول</b>
                                   @elseif($item->status == 'REJECT')
                                    <b class="text-danger">مرفوض</b>
                                   @else
                                    <b class="text-info">غير معروف</b>
                                   @endif   
                                   <br>
                                   @if($item->teacher_re == 'start')
                                    <b class="text-success">تم التوجية للشيخ</b>
                                   @else
                                   <a href="{{route('unpassed.id.ejazah',['id'=>$item->id])}}"  onclick="return confirm('هل انت متأكد من إعادة توجية الطالب للشيخ؟');" class="btn btn-info btn-sm">
                                       أعادة توجية للشيخ
                                   </a>
                                   @endif
                               </td>
                               <td>   
                                   <div class="position-relative">
                                      @if($item->teacher != 0)
                                      <span class="text-danger">
                                        <?php
                                        $teacher = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('id',$item->teacher)->first();
                                                                        
                                                                        ?>
                                            {{$teacher->name}}
                                      </span>
                                      @endif
                                      <br>
<a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-{{$item->id}}" class="btn btn-warning btn-sm">تعديل الشيخ</a> 
                                   
         
<!-- Modal -->
<div class="modal fade" id="ejaza-user-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            تعديل الشيخ
            </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('ejazah.teacher.assign')}}" method="POST">
            @csrf
            <select class="form-select mb-4" name="teacher_id">
                @foreach($teachers as $row)
                    <option value="{{$row->id}}" @if($item->teacher == $row->id) SELECTED @endif>{{$row->name}}</option>
                @endforeach

            </select>
            <input type="hidden" name="user_ejazah_id" value="{{$item->id}}" />
<div class="d-grid gap-2">
  <button class="btn btn-primary" type="submit">تأكيد</button>
</div>


        </form>
        
        
      </div>
      <div class="modal-footer d-none">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
      </div>
      
    </div>
  </div>
</div>         
                                                                       
                                      
                                   </div>
                               </td>

                            </tr>
                            
                            
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
