@extends('layouts.mainapp')

@section('content')

                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                                        <li class="breadcrumb-item">
@if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'not' AND Request::segment(4) == 'users') 
                                            <a href="{{route('ejazah.not.users')}}">
                                                طلاب مستمرين     
                                            </a>
@else
<a href="{{route('ejazah.users')}}">طلاب مقابلة</a>
@endif
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
@if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'not' AND Request::segment(4) == 'users') 
    الطلاب الغير مجازين
@else
    الطلاب المجازين
@endif
</span>


@if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'not' AND Request::segment(4) == 'users') 

                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الطالب</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">الإجازة التي ترغب البدء بها</th>
                                <th scope="col">المرفقات</th>
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
                                    <td><?= $countriesValue[array_search($usersName->country , $countriesKey)]; ?></td>
                                
                                <td> 
                                    @if($item->isqerano == 'yes')
                                        <?php
                                        $qeraat = DB::table(config('constants.tables.TBL_QERAAT'))->WHERE('id',$item->noqeraat)->first();
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
                                </td>
                              
    


                                <td>
@if($item->status == 'WAIT') 
<a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-{{$item->id}}" class="btn btn-warning btn-sm">بدء المقابلة</a> 
@endif                                    
         
<!-- Modal -->
<div class="modal fade" id="ejaza-user-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">مقابلة البدء  بالإجازة</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('ejazah.teacher.interview')}}" method="POST">
            @csrf
<div class="text-start">
    <div class="row">
                <div class="col-md-6">
                  <label for="start_date" class="form-label mt-3">تاريخ البدء</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" @if($item->start_date != NULL)  value="{{$item->start_date}}" @endif>
                </div>
                
                
    </div>
        <h3 class="mt-3">أسئلة التجويد</h3>
        
            <div class="row">
                <div class="col-md-6 mt-3">
                    <p class="text-danger">السؤال الأول</p>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" attr="{{$item->tjweed_q1}}" @if($item->tjweed_q1 == 'yes') checked="checked" @endif type="radio" name="tjweed_q1" id="tj-q1-yes" value="yes">
                      <label class="form-check-label" for="tj-q1-yes">
                        صح
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" @if($item->tjweed_q1 == 'no') checked="checked" @endif type="radio" name="tjweed_q1" id="tj-q1-no" value="no">
                      <label class="form-check-label" for="tj-q1-no">
                        خطأ
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" @if($item->tjweed_q1 == 'nothing') checked="checked" @endif type="radio" name="tjweed_q1" id="tj-q1-noth" value="nothing">
                      <label class="form-check-label" for="tj-q1-noth">
                        غير محدد    
                      </label>
                    </div>                  
                </div>
                
                <div class="col-md-6 mt-3">
                    <p class="text-danger">السؤال الثاني</p>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" @if($item->tjweed_q2 == 'yes') checked="checked" @endif type="radio" name="tjweed_q2" id="tj-q2-yes" value="yes">
                      <label class="form-check-label" for="tj-q2-yes">
                        صح
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" @if($item->tjweed_q2 == 'no') checked="checked" @endif type="radio" name="tjweed_q2" id="tj-q2-no" value="no">
                      <label class="form-check-label" for="tj-q2-no">
                        خطأ
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" @if($item->tjweed_q2 == 'nothing') checked="checked" @endif checked="checked" type="radio" name="tjweed_q2" id="tj-q2-noth" value="nothing">
                      <label class="form-check-label" for="tj-q2-noth">
                        غير محدد    
                      </label>
                    </div>                  
                </div>                
                
                <div class="col-md-6 mt-3">
                    <p class="text-danger">السؤال الثالث</p>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q3" id="tj-q3-yes" value="yes"  @if($item->tjweed_q2 == 'yes') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q3-yes">
                        صح
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q3" id="tj-q3-no" value="no" @if($item->tjweed_q2 == 'no') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q3-no">
                        خطأ
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q3" id="tj-q3-noth" value="nothing" @if($item->tjweed_q2 == 'nothing') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q3-noth">
                        غير محدد    
                      </label>
                    </div>                  
                </div>   
                
                <div class="col-md-6 mt-3">
                    <p class="text-danger">السؤال الرابع</p>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q4" id="tj-q4-yes" value="yes" @if($item->tjweed_q2 == 'yes') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q4-yes">
                        صح
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q4" id="tj-q4-no" value="no" @if($item->tjweed_q2 == 'no') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q4-no">
                        خطأ
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q4" id="tj-q4-noth" value="nothing" @if($item->tjweed_q2 == 'nothing') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q4-noth">
                        غير محدد    
                      </label>
                    </div>                  
                </div>   
                
                <div class="col-md-6 mt-3">
                    <p class="text-danger">السؤال الخامس</p>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q5" id="tj-q5-yes" value="yes" @if($item->tjweed_q5 == 'yes') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q5-yes">
                        صح
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q5" id="tj-q5-no" value="no" @if($item->tjweed_q5 == 'no') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q5-no">
                        خطأ
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" checked="checked" type="radio" name="tjweed_q5" id="tj-q5-noth" value="nothing" @if($item->tjweed_q5 == 'nothing') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q5-noth">
                        غير محدد    
                      </label>
                    </div>                  
                </div>   
                
            </div>
            
            
        <div class="row">
            <div class="card border mt-3 p-3">
                <div class="col-12"><h3>مستوى التجويد النظري</h3></div>
                <div class="col-12">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_level" id="ex-tj" value="EXC">
                      <label class="form-check-label" for="ex-tj">ممتاز   </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" checked="checked" type="radio" name="tjweed_level" id="good-tj" value="GOOD">
                      <label class="form-check-label" for="good-tj">جيد</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_level" id="bad-tj" value="FAIL">
                      <label class="form-check-label" for="bad-tj">ضعيف</label>
                    </div>
                </div>
            </div>
            
            <div class="card border p-3">
            <div class="col-12"><h3>مستوى التلاوة</h3></div>
            <div class="col-12">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="telawa_level" id="ex-tl" value="EXC">
                  <label class="form-check-label" for="ex-tl">ممتاز </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" checked="checked" type="radio" name="telawa_level" id="good-tl" value="GOOD">
                  <label class="form-check-label" for="good-tl">جيد</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="telawa_level" id="bad-tl" value="FAIL">
                  <label class="form-check-label" for="bad-tl">ضعيف</label>
                </div>
            </div>
            </div>
            
            <div class="card border p-3">
            <div class="col-12"><h3>مستوى الحفظ </h3></div>
            <div class="col-12">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="keep_level" id="ex-keep" value="EXC">
                  <label class="form-check-label" for="ex-keep">ممتاز   </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" checked="checked" type="radio" name="keep_level" id="good-keep" value="GOOD">
                  <label class="form-check-label" for="good-keep">جيد</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="keep_level" id="bad-keep" value="FAIL">
                  <label class="form-check-label" for="bad-keep">ضعيف</label>
                </div>
            </div>
        </div>
        
            <div class="card border p-3">
            <div class="col-12"><h3>ملاحظات على المشارك</h3>
            <small class="text-warning">
                (إذا كانت إحدى الملاحظات متكررة في تلاوة المشارك يكتب أمام الملاحظة (متكررة))
            </small>
            </div>
            <div class="row">
            <div class="col-md-6">
                  <label for="n1" class="form-label mt-3">الملاحظة 1</label>
                  <input type="text" class="form-control" id="n1" name="n1_s1">
            </div>
            <div class="col-md-6">
                  <label for="n2" class="form-label mt-3">الملاحظة 2</label>
                  <input type="text" class="form-control" id="n2" name="n2_s1">
            </div>
            <div class="col-md-6">
                  <label for="n3" class="form-label mt-3">الملاحظة 3</label>
                  <input type="text" class="form-control" id="n3" name="n3_s1">
            </div>
            <div class="col-md-6">
                  <label for="n4" class="form-label mt-3">الملاحظة 4</label>
                  <input type="text" class="form-control" id="n4" name="n4_s1">
            </div>
            </div>
        </div>
        
        
            <div class="card border p-3">
                <div class="col-12"><h3> القرار </h3>
            </div>
            <div class="row">
            <div class="col-12">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decision1" id="d1" value="D1">
                  <label class="form-check-label" for="d1">
                    مؤهل لقراءة الإجازة
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decision1" id="d2" value="D2">
                  <label class="form-check-label" for="d2">
                    يوجَّه إلى أحد المشايخ لتعديل الملاحظات  
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decision1" id="d3" value="D3">
                  <label class="form-check-label" for="d3">
                    مراجعة التجويد النظري    
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" checked="checked" type="radio" name="decision1" id="d4" value="D4">
                  <label class="form-check-label" for="d4">
                    غير مؤهل 
                  </label>
                </div>                
            </div>
            <div class="col-12">

            <div class="row">
            <div class="col-md-4">
                  <label for="sh1_s1" class="form-label mt-3">
                    اسم الشيخ (1)
                  </label>
            <select class="form-select mb-4" id="sh1_s1" name="sh1_s1">
                @foreach($teachers as $row)
                    <option value="{{$row->id}}" @if($item->teacher == $row->id) SELECTED @endif>{{$row->name}}</option>
                @endforeach

            </select>
            </div>
            <div class="col-md-4">
                  <label for="sh2_s1" class="form-label mt-3">
                      اسم الشيخ (2)
                  </label>
            <select class="form-select mb-4" id="sh2_s1" name="sh2_s1">
                <option value=""></option>
                @foreach($teachers as $row)
                    <option value="{{$row->id}}" @if($item->teacher == $row->id) SELECTED @endif>{{$row->name}}</option>
                @endforeach

            </select>
                  <input type="text" class="form-control" id="sh2_s1" name="sh2_s1">
            </div>
            <div class="col-md-4">
                  <label for="date_s1" class="form-label mt-3">
                    التاريخ
                  </label>
                  <input type="date" class="form-control" id="date_s1" name="date_s1">
            </div>
            </div>


            </div>
            </div>
        </div>        
        
        </div>

</div>



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
                                    
                                </td>
                            </tr>
                            
                            
                            @endforeach
                        </tbody>
                    </table>
                    
                    
                    
                    

@else

                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الطالب</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">الإجازة التي حصلت عليها</th>
                                <th scope="col">الإجازة التي ترغب البدء بها</th>
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
                                    <td> <?= $countriesValue[array_search($usersName->country , $countriesKey)]; ?></td>
                            
                                
                                
                                <td>
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
                                </td>
                              
                                <td class="sul ammar">
                                    

                                    @if($item->yesqeraatstart != NULL)
                                        <?php
                                        $qeraat = DB::table(config('constants.tables.TBL_QERAAT'))->WHERE('id',$item->yesqeraatstart)->first();
                                        ?>
                                        @if($qeraat)
                                            {{$qeraat->name}}
                                        @endif
                                    @else
                                        <?php
                                        $riwayah = DB::table(config('constants.tables.TBL_RIWAYAT'))->WHERE('id',$item->yesriwayastart)->first();
                                        ?>
                                        @if($riwayah)
                                        {{$riwayah->name}}
                                        @endif
                                    @endif
                                </td>
    
                                    
                                

    


                                <td>
@if($item->status == 'WAIT') 
<a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-{{$item->id}}" class="btn btn-warning btn-sm">بدء المقابلة</a> 
@endif                                    
         
<!-- Modal -->
<div class="modal fade" id="ejaza-user-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">مقابلة البدء  بالإجازة</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('ejazah.teacher.interview')}}" method="POST">
            @csrf
<div class="text-start">
    <div class="row">
                <div class="col-md-6 d-none">
                  <label for="start_date" class="form-label mt-3">تاريخ البدء</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" @if($item->start_date != NULL)  value="{{$item->start_date}}" @endif>
                </div>
                
                
    </div>
        <h3 class="mt-3">أسئلة التجويد</h3>
        
            <div class="row">
                <div class="col-md-6 mt-3">
                    <p class="text-danger">السؤال الأول</p>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" attr="{{$item->tjweed_q1}}" @if($item->tjweed_q1 == 'yes') checked="checked" @endif type="radio" name="tjweed_q1" id="tj-q1-yes" value="yes">
                      <label class="form-check-label" for="tj-q1-yes">
                        صح
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" @if($item->tjweed_q1 == 'no') checked="checked" @endif type="radio" name="tjweed_q1" id="tj-q1-no" value="no">
                      <label class="form-check-label" for="tj-q1-no">
                        خطأ
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" @if($item->tjweed_q1 == 'nothing') checked="checked" @endif type="radio" name="tjweed_q1" id="tj-q1-noth" value="nothing">
                      <label class="form-check-label" for="tj-q1-noth">
                        غير محدد    
                      </label>
                    </div>                  
                </div>
                
                <div class="col-md-6 mt-3">
                    <p class="text-danger">السؤال الثاني</p>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" @if($item->tjweed_q2 == 'yes') checked="checked" @endif type="radio" name="tjweed_q2" id="tj-q2-yes" value="yes">
                      <label class="form-check-label" for="tj-q2-yes">
                        صح
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" @if($item->tjweed_q2 == 'no') checked="checked" @endif type="radio" name="tjweed_q2" id="tj-q2-no" value="no">
                      <label class="form-check-label" for="tj-q2-no">
                        خطأ
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" @if($item->tjweed_q2 == 'nothing') checked="checked" @endif checked="checked" type="radio" name="tjweed_q2" id="tj-q2-noth" value="nothing">
                      <label class="form-check-label" for="tj-q2-noth">
                        غير محدد    
                      </label>
                    </div>                  
                </div>                
                
                <div class="col-md-6 mt-3">
                    <p class="text-danger">السؤال الثالث</p>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q3" id="tj-q3-yes" value="yes"  @if($item->tjweed_q2 == 'yes') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q3-yes">
                        صح
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q3" id="tj-q3-no" value="no" @if($item->tjweed_q2 == 'no') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q3-no">
                        خطأ
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q3" id="tj-q3-noth" value="nothing" @if($item->tjweed_q2 == 'nothing') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q3-noth">
                        غير محدد    
                      </label>
                    </div>                  
                </div>   
                
                <div class="col-md-6 mt-3">
                    <p class="text-danger">السؤال الرابع</p>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q4" id="tj-q4-yes" value="yes" @if($item->tjweed_q2 == 'yes') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q4-yes">
                        صح
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q4" id="tj-q4-no" value="no" @if($item->tjweed_q2 == 'no') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q4-no">
                        خطأ
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q4" id="tj-q4-noth" value="nothing" @if($item->tjweed_q2 == 'nothing') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q4-noth">
                        غير محدد    
                      </label>
                    </div>                  
                </div>   
                
                <div class="col-md-6 mt-3">
                    <p class="text-danger">السؤال الخامس</p>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q5" id="tj-q5-yes" value="yes" @if($item->tjweed_q5 == 'yes') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q5-yes">
                        صح
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_q5" id="tj-q5-no" value="no" @if($item->tjweed_q5 == 'no') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q5-no">
                        خطأ
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" checked="checked" type="radio" name="tjweed_q5" id="tj-q5-noth" value="nothing" @if($item->tjweed_q5 == 'nothing') checked="checked" @endif>
                      <label class="form-check-label" for="tj-q5-noth">
                        غير محدد    
                      </label>
                    </div>                  
                </div>   
                
            </div>
            
            
        <div class="row">
            <div class="card border mt-3 p-3">
                <div class="col-12"><h3>مستوى التجويد النظري</h3></div>
                <div class="col-12">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_level" id="ex-tj" value="EXC">
                      <label class="form-check-label" for="ex-tj">ممتاز   </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" checked="checked" type="radio" name="tjweed_level" id="good-tj" value="GOOD">
                      <label class="form-check-label" for="good-tj">جيد</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tjweed_level" id="bad-tj" value="FAIL">
                      <label class="form-check-label" for="bad-tj">ضعيف</label>
                    </div>
                </div>
            </div>
            
            <div class="card border p-3">
            <div class="col-12"><h3>مستوى التلاوة</h3></div>
            <div class="col-12">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="telawa_level" id="ex-tl" value="EXC">
                  <label class="form-check-label" for="ex-tl">ممتاز </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" checked="checked" type="radio" name="telawa_level" id="good-tl" value="GOOD">
                  <label class="form-check-label" for="good-tl">جيد</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="telawa_level" id="bad-tl" value="FAIL">
                  <label class="form-check-label" for="bad-tl">ضعيف</label>
                </div>
            </div>
            </div>
            
            <div class="card border p-3">
            <div class="col-12"><h3>مستوى الحفظ </h3></div>
            <div class="col-12">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="keep_level" id="ex-keep" value="EXC">
                  <label class="form-check-label" for="ex-keep">ممتاز   </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" checked="checked" type="radio" name="keep_level" id="good-keep" value="GOOD">
                  <label class="form-check-label" for="good-keep">جيد</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="keep_level" id="bad-keep" value="FAIL">
                  <label class="form-check-label" for="bad-keep">ضعيف</label>
                </div>
            </div>
        </div>
        
            <div class="card border p-3">
            <div class="col-12"><h3>ملاحظات على المشارك</h3>
            <small class="text-warning">
                (إذا كانت إحدى الملاحظات متكررة في تلاوة المشارك يكتب أمام الملاحظة (متكررة))
            </small>
            </div>
            <div class="row">
            <div class="col-md-6">
                  <label for="n1" class="form-label mt-3">الملاحظة 1</label>
                  <input type="text" class="form-control" id="n1" name="n1_s1">
            </div>
            <div class="col-md-6">
                  <label for="n2" class="form-label mt-3">الملاحظة 2</label>
                  <input type="text" class="form-control" id="n2" name="n2_s1">
            </div>
            <div class="col-md-6">
                  <label for="n3" class="form-label mt-3">الملاحظة 3</label>
                  <input type="text" class="form-control" id="n3" name="n3_s1">
            </div>
            <div class="col-md-6">
                  <label for="n4" class="form-label mt-3">الملاحظة 4</label>
                  <input type="text" class="form-control" id="n4" name="n4_s1">
            </div>
            </div>
        </div>
        
        
            <div class="card border p-3">
                <div class="col-12"><h3> القرار </h3>
            </div>
            <div class="row">
            <div class="col-12">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decision1" id="d1" value="D1">
                  <label class="form-check-label" for="d1">
                    مؤهل لقراءة الإجازة
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decision1" id="d2" value="D2">
                  <label class="form-check-label" for="d2">
                    يوجَّه إلى أحد المشايخ لتعديل الملاحظات  
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decision1" id="d3" value="D3">
                  <label class="form-check-label" for="d3">
                    مراجعة التجويد النظري    
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" checked="checked" type="radio" name="decision1" id="d4" value="D4">
                  <label class="form-check-label" for="d4">
                    غير مؤهل 
                  </label>
                </div>                
            </div>
            <div class="col-12">

            <div class="row">
            <div class="col-md-4">
                  <label for="sh1_s1" class="form-label mt-3">
                    اسم الشيخ (1)
                  </label>
            <select class="form-select mb-4" id="sh1_s1" name="sh1_s1">
                @foreach($teachers as $row)
                    <option value="{{$row->id}}" @if($item->teacher == $row->id) SELECTED @endif>{{$row->name}}</option>
                @endforeach

            </select>
            </div>
            <div class="col-md-4">
                  <label for="sh2_s1" class="form-label mt-3">
                      اسم الشيخ (2)
                  </label>
            <select class="form-select mb-4" id="sh2_s1" name="sh2_s1">
                <option value=""></option>
                @foreach($teachers as $row)
                    <option value="{{$row->id}}" @if($item->teacher == $row->id) SELECTED @endif>{{$row->name}}</option>
                @endforeach

            </select>
            </div>            
            
            
            <div class="col-md-4">
                  <label for="date_s1" class="form-label mt-3">
                    التاريخ
                  </label>
                  <input type="date" class="form-control" id="date_s1" name="date_s1">
            </div>
            </div>


            </div>
            </div>
        </div>        
        
        </div>

</div>



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
                                    
                                </td>
                            </tr>
                            
                            
                            @endforeach
                        </tbody>
                    </table>
                    
                    
                    

@endif                    
                    

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
