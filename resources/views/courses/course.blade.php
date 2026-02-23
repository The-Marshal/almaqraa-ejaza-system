@extends('layouts.mainapp')

@section('content')

                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('course')}}">كل الدورات</a></li>
                                        @if(Request::segment(1) == 'course' AND request()->route('id'))
                                            <li class="breadcrumb-item active">تعديل دورة </li>
                                        @elseif(Request::is('course/new'))
                                            <li class="breadcrumb-item active">اضافة دورة </li>
                                        @else
                                            <li class="breadcrumb-item active">كل الدورات</li>
                                        @endif
                                        
                                    </ol>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{route('course.new')}}" class="btn btn-success">اضافة دورة جديدة</a>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                            <div class="col-12">



@if(Request::segment(1) == 'course' AND Request::segment(2) == 'show' AND request()->route('id'))
@if(sizeof($data) > 0)

@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif

<form action="{{route('course.update', ['id' => request()->route('id')])}}" method="post" enctype='multipart/form-data'>
    @csrf
                                            <div class="row">

                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-2 col-form-label">تصنيف الدورة</label>
                                                                <div class="col-sm-10">
                                        @if(sizeof($sections) > 0)
                                                                    <select class="form-control" name="section">
                                                                      @foreach($sections as $section)  
                                                                 <option value="<?= $section->id?>" @if( $dataById->section == $section->id) selected @endif><?= $section->name?></option>       
                                                                 @endforeach
                                                                    </select>
                                                                    @else
<div class="alert alert-danger" role="alert">
  لاتوجد بيانات
</div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-2 col-form-label">اسم الدورة</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" value="<?= $dataById->name ?>" id="name" name="name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    



                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-2 col-form-label">اسم المدرب</label>
                                                                <div class="col-sm-10">
                                         @if(sizeof($techers) > 0)
                                                                    <select class="form-control" name="teacher">
                                        @foreach($techers as $techer)  
                                                                 <option value="<?= $techer->id?>" @if( $dataById->teacher == $techer->id) selected @endif><?= $techer->name?></option>       
                                                                 @endforeach
                                                                    </select>
                                                                    @else
<div class="alert alert-danger" role="alert">
  لاتوجد بيانات
</div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


    
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="cstart" class="col-sm-2 col-form-label">تاريخ بداية الدورة </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="date" value='<?= $dataById->cstart ?>' id="cstart" name="cstart">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

    
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="cend" class="col-sm-2 col-form-label">تاريخ نهاية الدورة </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="date" value='<?= $dataById->cend ?>' id="cend" name="cend">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="time" class="col-sm-2 col-form-label">وقت الدورة</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="time" id="time" name="time" value='<?= $dataById->time ?>'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="content" class="col-sm-2 col-form-label">محتوى الدورة</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" id="content" rows="3" name="content"><?= $dataById->content ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="content1" class="col-sm-2 col-form-label">وصف نصي للدورة</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control myCk" id="content1" rows="3" name="content1"><?= $dataById->txtcontent ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="objects" class="col-sm-2 col-form-label">أهداف الدورة</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control myCk" id="objects" rows="3" name="objects"><?= $dataById->objects ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                

                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                           
                                                            
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-2 col-form-label">رفع البوستر </label>
                                                                <div class="col-sm-8">
                                        <input type="file" class="form-control" name="poster">
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <a href="{{config('constants.path.PATH_COURSES_SITE')}}<?= $dataById->poster ?>" target="_blank">
                                                                    <img src="{{config('constants.path.PATH_COURSES_SITE')}}<?= $dataById->poster ?>"  class="img-fluid rounded" alt="" title=""></a>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="status" class="col-sm-2 col-form-label">الحالة</label>
                                                                <div class="col-sm-10">

                                         <input class="form-check form-switch" type="checkbox" name="status" id="status" @if($dataById->status == 'yes') checked @endif switch="none">
                                            <label class="form-label" for="status" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    
    <div class="col-12 col-md-12 col-lg-12">
<div class="card">
    <div class="card-body">
        <h4 class="card-title">شروط التسجيل في الدورة:</h4>
        <div class="row mb-3">
            <label for="quran" class="col-sm-2 col-form-label">
                يشترط حفظ القرآن الكريم
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="quran"  @if($dataById->quran == 'yes') checked @endif  id="quran" switch="none">
<label class="form-label" for="quran" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="cerquran" class="col-sm-2 col-form-label">
              إرفاق شهادة حفظ القرآن
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="cerquran" @if($dataById->cerquran == 'yes') checked @endif  id="cerquran" switch="none">
<label class="form-label" for="cerquran" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>        
     
        
        <div class="row mb-3">
            <label for="male" class="col-sm-2 col-form-label">
              خاصة للرجال
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="male" @if($dataById->male == 'yes') checked @endif  id="male" switch="none">
<label class="form-label" for="male" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>        
     
        
        <div class="row mb-3">
            <label for="female" class="col-sm-2 col-form-label">
              خاصة للنساء
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="female" @if($dataById->female == 'yes') checked @endif  id="female" switch="none">
<label class="form-label" for="female" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>                
        
     
        
        <div class="row mb-3">
            <label for="gaz" class="col-sm-2 col-form-label">
              دراسة الجزرية 
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="gaz" @if($dataById->gaz == 'yes') checked @endif  id="gaz" switch="none">
<label class="form-label" for="gaz" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>   
        
     
        
        <div class="row mb-3">
            <label for="ejaza" class="col-sm-2 col-form-label">
              تأهيل الإجازة 
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="ejaza" @if($dataById->ejaza == 'yes') checked @endif  id="ejaza" switch="none">
<label class="form-label" for="ejaza" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>   
        
        
     
        
        <div class="row mb-3">
            <label for="isejaza" class="col-sm-2 col-form-label">
              ان يكون مجاز 
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="isejaza" @if($dataById->isejaza == 'yes') checked @endif  id="isejaza" switch="none">
<label class="form-label" for="isejaza" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>           
        
    </div>
</div>
</div>    
    
    
    
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">تعديل</button>
                                                            </div>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
     </form>
    
     @else
     <div class="alert alert-danger" role="alert">
         لاتوجد بيانات
     </div>
     @endif

@elseif(Request::is('course/new'))
@if($errors->any())
    {{ implode('', $errors->all('<div class="alert alert-danger">:message</div>')) }}
@endif
<form action="{{route('course.store')}}" method="post" enctype='multipart/form-data'>
    @csrf
                                            <div class="row">
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-2 col-form-label">تصنيف الدورة</label>
                                                                <div class="col-sm-10">
                                                                    @if(sizeof($sections) > 0)
                                                                    <select class="form-control" name="section">
                                                                      @foreach($sections as $section)  
                                                                 <option value="<?= $section->id?>" @if(old("section") == $section->id) selected @endif><?= $section->name?></option>       
                                                                 @endforeach
                                                                    </select>
                                                                    @else
<div class="alert alert-danger" role="alert">
  لاتوجد بيانات
</div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-2 col-form-label">اسم الدورة</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" {{ old("name") }} id="name" name="name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    



                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-2 col-form-label">اسم المدرب</label>
                                                                <div class="col-sm-10">
                                                                    @if(sizeof($techers) > 0)
                                                                    <select class="form-control" name="teacher">
                                                                      @foreach($techers as $techer)  
                                                                 <option value="<?= $techer->id?>" @if(old("teacher") == $section->id) selected @endif><?= $techer->name?></option>       
                                                                 @endforeach
                                                                    </select>
                                                                    @else
<div class="alert alert-danger" role="alert">
  لاتوجد بيانات
</div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


    
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="cstart" class="col-sm-2 col-form-label">تاريخ بداية الدورة </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="date" value='{{ old("cstar") }}' id="cstart" name="cstart">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

    
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="cend" class="col-sm-2 col-form-label">تاريخ نهاية الدورة </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="date" value='{{ old("cend") }}' id="cend" name="cend">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="time" class="col-sm-2 col-form-label">وقت الدورة</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="time" id="time" name="time" value='{{ old("time") }}'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="content" class="col-sm-2 col-form-label">محتوى الدورة</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" id="content" rows="3" name="content">{{ old("content") }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="content1" class="col-sm-2 col-form-label">وصف نصي للدورة</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" id="content1" rows="3" name="content1">{{ old("content1") }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="objects" class="col-sm-2 col-form-label">أهداف الدورة</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" id="objects" rows="3" name="objects">{{ old("objects") }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                

                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="objects" class="col-sm-2 col-form-label">بوستر</label>
                                                                <div class="col-sm-10">
                                                                    <input type="file" class="form-control" name="poster">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="status" class="col-sm-2 col-form-label">الحالة</label>
                                                                <div class="col-sm-10">

                                         <input class="form-check form-switch" type="checkbox" name="status" id="status" checked switch="none">
                                            <label class="form-label" for="status" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    
    
<div class="col-12 col-md-12 col-lg-12">
<div class="card">
    <div class="card-body">
        <h4 class="card-title">شروط التسجيل في الدورة:</h4>
        <div class="row mb-3">
            <label for="quran" class="col-sm-2 col-form-label">
                يشترط حفظ القرآن الكريم
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="quran" id="quran" switch="none">
<label class="form-label" for="quran" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="cerquran" class="col-sm-2 col-form-label">
              إرفاق شهادة حفظ القرآن
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="cerquran" id="cerquran" switch="none">
<label class="form-label" for="cerquran" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>        
     
        
        <div class="row mb-3">
            <label for="male" class="col-sm-2 col-form-label">
              خاصة للرجال
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="male" id="male" switch="none">
<label class="form-label" for="male" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>        
     
        
        <div class="row mb-3">
            <label for="female" class="col-sm-2 col-form-label">
              خاصة للنساء
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="female" id="female" switch="none">
<label class="form-label" for="female" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>                
        
     
        
        <div class="row mb-3">
            <label for="gaz" class="col-sm-2 col-form-label">
              دراسة الجزرية 
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="gaz" id="gaz" switch="none">
<label class="form-label" for="gaz" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>   
        
     
        
        <div class="row mb-3">
            <label for="ejaza" class="col-sm-2 col-form-label">
              تأهيل الإجازة 
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="ejaza" id="ejaza" switch="none">
<label class="form-label" for="ejaza" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>   
        
        
     
        
        <div class="row mb-3">
            <label for="isejaza" class="col-sm-2 col-form-label">
              ان يكون مجاز 
            </label>
            <div class="col-sm-10">

<input class="form-check form-switch" type="checkbox" name="isejaza" id="isejaza" switch="none">
<label class="form-label" for="isejaza" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                
            </div>
        </div>           
        
    </div>
</div>
</div>    
    
    
    
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">اضافة</button>
                                                            </div>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
     </form>

@else
@if(sizeof($data) > 0)

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">تصنيف الدورة</th>
                                <th scope="col">اسم الدورة</th>
                                <th scope="col">اسم المدرب</th>
                                <th scope="col">الحالة</th>
                                <th scope="col">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>
                                    <?php 
                                    $section = DB::table(config('constants.tables.TBL_SECTIONS'))->where('id',$item->section)->first();
                                    echo $section->name;
                                    ?>    
                                </td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <?php 
                                    $teacher = DB::table(config('constants.tables.TBL_TEACHERS'))->where('id',$item->teacher)->first();
                                    echo $teacher->name;
                                    ?>    
                                </td>
                                <td>
                                    @if($item->status == 'yes')
                                    <span class="badge bg-primary">مفعل</span>
                                    @else
                                        <span class="badge bg-danger">غير مفعل</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('course.show', ['id' => $item->id])}}" class="btn btn-primary btn-sm">تعديل</a> -
                                    <a href="{{route('course.destroy', ['id' => $item->id])}}" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">حذف</a> 
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

@endif





                            </div>
                        </div>
                        <!-- end row -->

@endsection
