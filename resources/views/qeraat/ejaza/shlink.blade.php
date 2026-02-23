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
                                            <a href="#">
                                                تعديل رابط الدورات
                                            </a>
                                        </li>
                                        
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                            <div class="col-12">




<form action="{{route('ejazah.shaikh.link.id')}}" method="post" enctype='multipart/form-data'>
    @csrf

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">
                        رابط الدورات
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" value="<?= auth()->user()->url ?>" name="url">
                        <input class="form-control" type="hidden" value="<?= auth()->user()->id ?>" name="id">
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





                            </div>
                        </div>
                        <!-- end row -->

@endsection
