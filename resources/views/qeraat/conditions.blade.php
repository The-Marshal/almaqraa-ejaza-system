@extends('layouts.mainapp')

@section('content')
 
                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                                        <li class="breadcrumb-item"><a href="{{URL('/qeraat/ejazah')}}"> نبذة عن الإجازة </a></li>
                                        
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                            <div class="col-12">

 

<form action="{{route('qeraat.ejazah')}}" method="post">
    @csrf
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="editor" class="col-sm-2 col-form-label">النبذة</label>
                                                                <div class="col-sm-10">
                                                                        <textarea class="form-control" id="editor" name="editor" rows="3"><?= $data->conditions ?></textarea>

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
