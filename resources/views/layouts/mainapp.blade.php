<!doctype html>
<html lang="en" dir="rtl">

    <head>
    
        <meta charset="utf-8">
        <title>لوحة التحكم</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="لوحة التحكم" name="description">
        <meta content="Ammar-sulaimani-0554132573" name="author">
        <!-- App favicon -->    
        <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/images/favicon/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/favicon/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon/favicon-16x16.png')}}">
        <link rel="manifest" href="{{asset('assets/images/favicon/site.webmanifest')}}">
        <link rel="mask-icon" href="{{asset('assets/images/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <link href="{{asset('assets/libs/chartist/chartist.min.css')}}" rel="stylesheet">
    
        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap-rtl.min.css')}}" id="app-style" rel="stylesheet" type="text/css">

        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons-rtl.min.css')}}" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="{{asset('assets/css/app-rtl.min.css')}}" id="app-style" rel="stylesheet" type="text/css">
        <!-- Tables Styles-->

        <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css " rel="stylesheet" type="text/css">
        
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>
       
        
        <style>
            input[switch] + label {
                width: 88px;
            }
            input[switch]:checked + label:after {
                right: 65px;
            }
div#cke_notifications_area_editor {
    display: none;
}    
.bootstrap-select .dropdown-toggle .filter-option-inner-inner, .bootstrap-select .dropdown-menu li {
    text-align: right;
}

.bootstrap-select>.dropdown-toggle{
    background: #F8F8F8;
    font-weight: bold;    
    color: #000;
    border: 1px solid #DDD;
}
        </style>
        
@yield("cssSection")        
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box bg-logo-grad">
                            <a href="https://qt3ah.com/themwl/dashboard" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{asset('assets/images/logo-sm.png')}}" alt="" class="img-fluid logo-width">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('assets/images/logo-dark.png')}}" alt="" class="img-fluid">
                                </span>
                            </a>

                            <a href="https://qt3ah.com/themwl/dashboard" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{asset('assets/images/logo-sm.png')}}" alt="" class="img-fluid logo-width">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('assets/images/logo-light.png')}}" alt="" class="img-fluid">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                            <i class="mdi mdi-menu"></i>
                        </button>

                      
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-none d-lg-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                                <i class="mdi mdi-fullscreen"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block d-none ">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge bg-danger rounded-pill">3</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="m-0 font-size-16"> Notifications (258) </h5>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                                        <i class="mdi mdi-cart-outline"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Your order is placed</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                        
                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-warning rounded-circle font-size-16">
                                                        <i class="mdi mdi-message-text-outline"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">New Message received</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">You have 87 unread messages</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-info rounded-circle font-size-16">
                                                        <i class="mdi mdi-glass-cocktail"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Your item is shipped</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">It is a long established fact that a reader will</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                        <i class="mdi mdi-cart-outline"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Your order is placed</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-danger rounded-circle font-size-16">
                                                        <i class="mdi mdi-message-text-outline"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">New Message received</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">You have 87 unread messages</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-top">
                                    <div class="d-grid">
                                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                            View all
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block d-none ">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/user-4.jpg')}}"
                                    alt="Header Avatar">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle font-size-17 align-middle me-1"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="mdi mdi-wallet font-size-17 align-middle me-1"></i> My Wallet</a>
                                <a class="dropdown-item d-flex align-items-center" href="#"><i class="mdi mdi-cog font-size-17 align-middle me-1"></i> Settings<span class="badge bg-success ms-auto">11</span></a>
                                <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline font-size-17 align-middle me-1"></i> Lock screen</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#"><i class="bx bx-power-off font-size-17 align-middle me-1 text-danger"></i> Logout</a>
                            </div>
                        </div>
                        @if (isset($teacherUrl))
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                <a href="{{$teacherUrl}}" target="_blank">
                                    <i class="mdi mdi-link"></i>
                                </a>
                            </button>
                        </div>
                        @endif
                        <div class="dropdown d-inline-block d-none ">
                            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                <i class="mdi mdi-cog-outline"></i>
                            </button>
                        </div>
            
                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">

@modOrAdmin
@admin
                            <li class="menu-title">إعدادات رئيسية</li>

                            <li>
                                <a href="{{route('settings')}}" class="waves-effect">
                                    <i class="ti-home"></i>
                                    <span>الإعدادات العامة</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('users.index')}}" class=" waves-effect">
                                    <i class="ti-user"></i>
                                    <span>إدارة المستخدمين</span>
                                </a>
                            </li>


                            <li>
                                <a href="{{route('mods.index')}}" class=" waves-effect">
                                    <i class="ti-user"></i>
                                    <span>إدارة المشرفين</span>
                                </a>
                            </li>


                            <li class="menu-title">المقرأة</li>
                            <li>
                                <a href="{{route('teachers')}}" class="  @if(Request::segment(1) == 'teachers') active @endif waves-effect">
                                    <i class="ti-user"></i>
                                    <span>المعلمين </span>
                                </a>
                            </li>
@endadmin
                            
                       
                            <li @if(Request::segment(1) == 'sections' || Request::segment(1) == 'course') class="mm-active" @endif>
                                <a href="javascript: void(0);" class="has-arrow  waves-effect">
                                    <i class="ti-folder"></i>
                                    <span>نظام إدارة الدورات</span>
                                </a>
                                    <ul class="sub-menu mm-collapse @if(Request::segment(1) == 'sections') mm-show @endif" aria-expanded="false" style="">
                                        

                            <li @if(Request::segment(1) == 'course') class="mm-active" @endif>
                                <a href="javascript: void(0);" class="has-arrow  waves-effect"
                                    <i class="ti-folder"></i>
                                    <span>طلبات الدورات</span>
                                </a>
<ul class="sub-menu mm-collapse @if(Request::segment(1) == 'course' && Request::segment(1) == 'appliers') mm-show @endif" aria-expanded="false" style="">
    
    <li><a href="{{route('course.new.users')}}"  @if(Request::segment(1) == 'course' AND Request::segment(2) == 'appliers' AND Request::segment(3) == 'new') class="active" @endif>طلبات جديدة</a></li>   
    
                                    <li><a href="{{route('course.users')}}"  @if(Request::segment(1) == 'course' AND Request::segment(2) == 'appliers' AND Request::segment(3) == 'accept') class="active" @endif>طلبات مقبولة</a></li>
                                    
                                    <li><a href="{{route('course.not.users')}}"  @if(Request::segment(1) == 'course' AND Request::segment(2) == 'appliers' AND Request::segment(3) == 'reject') class="active" @endif>طلبات مرفوضة</a></li>
                                    
                                                                  
                                    
</ul>
                            </li>
                            

@admin                                     
                                 
                                    <li><a href="{{route('course.new')}}"  @if(Request::segment(1) == 'course' AND Request::segment(2) == 'new') class="active" @endif>اضافة دورة</a></li>
@endadmin                                        
                                    <li class="d-none"><a href="{{route('course.appliers')}}"  @if(Request::segment(1) == 'course' AND Request::segment(2) == 'appliers') class="active" @endif>طلبات الدورات</a></li>
@admin                  
                                    <li><a href="{{route('course')}}"  @if(Request::segment(1) == 'course' AND !Request::segment(2)) class="active" @endif>كل الدورات</a></li>
                                    <li><a href="{{route('sections')}}" @if(Request::segment(1) == 'sections') class="active" @endif>التصنيفات</a></li>
@endadmin   
                                </ul>
                            </li>
@endmodOrAdmin

                            <li @if(Request::segment(1) == 'qeraat' || Request::segment(1) == 'sqeraat') class="mm-active" @endif>
                                <a href="javascript: void(0);" class="has-arrow  waves-effect">
                                    <i class="ti-folder"></i>
                                    <span>نظام الإجازة</span>
                                </a>
                                    <ul class="sub-menu mm-collapse @if(Request::segment(1) == 'ejazah' || Request::segment(1) == 'qeraat' || Request::segment(1) == 'sqeraat' ) mm-show @endif" aria-expanded="false" style="">
                                    <li><a href="{{route('enrollments.index')}}"  @if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'manage-enrollments') class="active" @endif > إدارة طلبات الإجازة</a></li>
@admin 
                                    <li>
                                        <a href="{{ route('enrollments.monthly_report') }}" 
                                           class="{{ request()->routeIs('enrollments.monthly_report') ? 'active' : '' }}">
                                             التقارير الشهرية
                                        </a>
                                    </li>
@endadmin 
@modOrAdmin

                            <li  class="d-none @if(Request::segment(1) == 'qeraat' || Request::segment(1) == 'sqeraat') mm-active @endif ">
                                <a href="javascript: void(0);" class="has-arrow  waves-effect"
                                    <i class="ti-folder"></i>
                                    <span>الطلبات الجديدة</span>
                                </a>
<ul class="sub-menu mm-collapse @if( (Request::segment(1) == 'ejazah' && Request::segment(1) == 'users') || (Request::segment(1) == 'ejazah' && Request::segment(2) == 'not' && Request::segment(3) == 'users') ) mm-show @endif" aria-expanded="false" style="">
    
                                    <li><a href="{{route('ejazah.users')}}"  @if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'users') class="active" @endif>طلاب مجازين</a></li>
                                    
                                    <li><a href="{{route('ejazah.not.users')}}"  @if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'not' AND Request::segment(3) == 'users') class="active" @endif>طلاب غير مجازين</a></li>
                                    
<li class=""><a href="{{route('ejazah.rejects.users')}}"  @if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'rejects' AND Request::segment(3) == 'users') class="active" @endif>الطلبات المرفوضة</a></li>                                    
                                    
</ul>
                            </li>

                   


                            <li class="d-none @if((Request::segment(1) == 'ejazah' AND Request::segment(2) == 'accepted' AND Request::segment(3) == 'users') || (Request::segment(1) == 'ejazah' AND Request::segment(2) == 'accepted' AND Request::segment(3) == 'users')) mm-active @endif ">
                                <a href="javascript: void(0);" class="has-arrow  waves-effect"
                                    <i class="ti-folder"></i>
                                    <span> طلبة الإجازة </span>
                                </a>
<ul class="sub-menu mm-collapse @if( (Request::segment(1) == 'ejazah' && Request::segment(1) == 'users') || (Request::segment(1) == 'ejazah' && Request::segment(2) == 'not' && Request::segment(3) == 'users') ) mm-show @endif" aria-expanded="false" style="">
    
                                    <!-- اجتازو المقابلة -->
                                    <li><a href="{{route('passed.ejazah')}}"  @if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'passed' AND !Request::segment(3)) class="active" @endif>المجتازين</a></li>
                                    
                                    <!-- لم يجتازو المقابلة -->
                                    <li><a href="{{route('unpassed.ejazah')}}"  @if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'unpassed') class="active" @endif> غير المجتازين</a></li>
                                    
<!-- مستمرين في دراسة الإجازة -->                                    
<li class=""><a href="{{route('continuous.ejazah')}}"  @if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'continuous') class="active" @endif>المستمرين</a></li>                                    
                                    
</ul>
                            </li>
                   
@admin
                            <li @if(Request::segment(1) == 'qeraat' || Request::segment(1) == 'riwayat' || (Request::segment(1) == 'ejazah' && Request::segment(2) == 'conditions' )) class="mm-active" @endif>
                                <a href="javascript: void(0);" class="has-arrow  waves-effect"
                                    <i class="ti-folder"></i>
                                    <span>إعدادات نظام الإجازة</span>
                                </a>
<ul class="sub-menu mm-collapse @if( (Request::segment(1) == 'qeraat') || (Request::segment(1) == 'riwayat') || (Request::segment(1) == 'ejazah' && Request::segment(2) == 'conditions' ) ) mm-show @endif" aria-expanded="false" style="">                                    
@admin       
                                    <li><a href="{{route('qeraat')}}"  @if(Request::segment(1) == 'qeraat') class="active" @endif>القراءات</a></li>
                                    <li><a href="{{route('riwayat')}}" @if(Request::segment(1) == 'riwayat') class="active" @endif>الروايات</a></li>
                                    
                                    <li><a href="{{route('qeraat.ejazah')}}" @if(Request::segment(1) == 'conditions') class="active" @endif>نبذة عن الإجازة</a></li>
@endadmin 
                                </ul>
@endmodOrAdmin 


@teacher

                                    <li class="d-none"><a href="{{route('ejazah.shaikh.interview.users')}}"  @if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'interview' AND Request::segment(4) == 'users') class="active" @endif >طلاب مقابلة</a></li>
                                    
                                    <li class="d-none"><a href="{{route('ejazah.shaikh.continuous.users')}}"  @if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'continuous' AND Request::segment(4) == 'users') class="active" @endif>طلاب مستمرين </a></li>





@endteacher  
                                
                                </ul>
                            </li>
@endadmin 
@teacher


                            <li @if(Request::segment(1) == 'qeraat' || Request::segment(1) == 'sqeraat') class="mm-active" @endif>
                                <a href="javascript: void(0);" class="has-arrow  waves-effect"
                                    <i class="ti-folder"></i>
                                    <span>قسم الدورات</span>
                                </a>
                                
                                
<ul class="sub-menu mm-collapse @if((Request::segment(1) == 'course' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'presents' ) || (Request::segment(1) == 'course' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'not' AND Request::segment(4) == 'users') || (Request::segment(1) == 'course' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'yes' AND Request::segment(4) == 'users') || (Request::segment(1) == 'course' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'users') ) mm-show @endif" aria-expanded="false" style="">
@if(auth()->user()->level != 'teacher')
                                    <li class="menu-title">طلاب</li>
                                    <li><a href="{{route('course.shaikh.users')}}"  @if(Request::segment(1) == 'course' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'users') class="active" @endif>طلاب جدد</a></li>
                                    
                                    <li><a href="{{route('course.yes.shaikh.users')}}"  @if(Request::segment(1) == 'course' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'yes' AND Request::segment(4) == 'users') class="active" @endif>طلاب مقبولين</a></li>
                                    <li><a href="{{route('course.not.shaikh.users')}}"  @if(Request::segment(1) == 'course' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'not' AND Request::segment(4) == 'users') class="active" @endif>طلاب مرفوضين</a></li>
                                    
@endif                                    
                                    
                                    <li class="menu-title">دورات</li>
                                    <li><a href="{{route('course.shaikh.new')}}"  @if(Request::segment(1) == 'course' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'new') class="active" @endif>دورات جديدة</a></li>   
                                    
                                    <li><a href="{{route('course.shaikh.active')}}"  @if( (Request::segment(1) == 'course' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'active') || (Request::segment(1) == 'course' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'presents' ) ) class="active" @endif>دورات مستمرة</a></li>  
                                    
                                    <li><a href="{{route('course.shaikh.completed')}}"  @if(Request::segment(1) == 'course' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'completed') class="active" @endif>دورات مكتملة</a></li>  
                                    
                                    
</ul>
                            </li>



<li><a href="{{route('ejazah.shaikh.link')}}"  @if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'shaikh' AND Request::segment(3) == 'link') class="active" @endif>رابط الدورة</a></li>



@endteacher
@admin
                            <li>
                                <a href="javascript: void(0);" class=" waves-effect">
                                    <i class="ti-folder"></i>
                                    <span>نظام إدارة الحضور</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class=" waves-effect">
                                    <i class="ti-briefcase"></i>
                                    <span>المكتبة القرآنية</span>
                                </a>
                            </li>

                              


    


                            <li class="menu-title">إعدادات خاصة</li>
                            <li>
                                <a href="{{route('mcontnt')}}" class=" waves-effect">
                                    <i class="ti-pencil-alt2"></i>
                                    <span>عن المقرأة</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('contact')}}" class=" waves-effect">
                                    <i class="ti-pencil-alt2"></i>
                                    <span>إعدادت تواصل معنا</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('slider')}}" class=" waves-effect">
                                    <i class="ti-gallery"></i>
                                    <span>مستعرض الصور</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class=" waves-effect">
                                    <i class="ti-agenda"></i>
                                    <span>نظام إدارة المحتوى</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('stats')}}" class=" waves-effect">
                                    <i class="ti-layout-grid2-thumb"></i>
                                    <span>إحصائيات عامة</span>
                                </a>
                            </li>
                            @if(auth()->user()->level == 'admin')
                            <li>
                                <a href="{{route('stats.index')}}" class=" waves-effect">
                                    <i class="ti-layout-grid2-thumb"></i>
                                    <span>إحصائيات مخصصة</span>
                                </a>
                            </li>
                            @endif
                            <li>
                                <a href="javascript: void(0);" class=" waves-effect">
                                    <i class="ti-marker-alt"></i>
                                    <span>أخبار المقرأة</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class=" waves-effect">
                                    <i class="ti-crown"></i>
                                    <span>شركاء النجاح</span>
                                </a>
                            </li>
@endadmin
                            <li>
                                <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class=" waves-effect">
                                    <i class="ti-power-off"></i>
                                    <span>خروج</span>
                                </a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
                            </li>  

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">




                        @yield('content')





                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                © <script>document.write(new Date().getFullYear())</script> <a href="https://jusoor.com.sa/" target="_blank"><span class="d-none"> -  صنع  <i class="mdi mdi-heart text-danger"></i> عبر جسور لتقنية المعلومات</a></span>
                            </div>
                        </div>
                    </div>
                </footer>

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

                <!-- JAVASCRIPT -->
                <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
                <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
                <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
                <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

        <!-- Peity chart-->
        <script src="{{asset('assets/libs/peity/jquery.peity.min.js')}}"></script>

        <!-- Plugin Js-->
        <script src="{{asset('assets/libs/chartist/chartist.min.js')}}"></script>
        <script src="{{asset('assets/libs/chartist-plugin-tooltips/chartist-plugin-tooltip.min.js')}}"></script>
        <script src="{{asset('assets/js/pages/dashboard.init.js')}}"></script>

        <script src="{{asset('assets/js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.11.0/sweetalert2.all.js" integrity="sha512-tVW2BH+E4Tz5bfMbnVTeswRrYPUPFDPsPtHRXZWhm9DZrr/5oISoe+zESrOthZrQtLtGTqV0KE90Tgl7R0Zdzw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.22.1/ckeditor.js"></script>
<!--<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="{{asset('https://admin.almaqraa.net/assets/ck/ckeditor.js')}}"></script>
<script src="{{asset('https://admin.almaqraa.net/assets/ck/config.js')}}"></script>-->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>



@include('sweetalert::alert')

<script>
//new DataTable('#tabletheml');

/*var table = new DataTable('#tabletheml', {
    language: {
        url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/ar.json',
    },
});*/
$(document).ready(function(){
    $('.selectpickerCTRY').selectpicker({ 
        noneResultsText: 'لاتوجد بيانات ',
         noneSelectedText : 'إختر البلد'
        
    });
    
$('#selectAll').change(function() {
  var checkboxes = $(this).closest('table').find(':checkbox');
  checkboxes.prop('checked', $(this).is(':checked'));
});

});
    $('#allusers').submit(function() {
        // Replace 'your_checkbox_name' with the actual name of your checkboxes
        if ($('input[name="users_select[]"]:checked').length === 0) {
            alert('يجب اختيار طالب واحد على الأقل');
            return false; // Prevent form submission
        }
        // If at least one checkbox is checked, the form will submit normally
    });
var table = new DataTable('#tabletheml', {
                lengthMenu: [
                [10, 25, 50,100,200,300,500, -1],
                [10, 25, 50,100,200,300,500, 'All']
            ],buttons: [
            'excel','csv'
        ],
            language: {
        url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/ar.json',
    },
    columnDefs: [
        {"className": "dt-center", "targets": "_all"}
      ],
    
   /* language: {
        url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/ar.json',
    },
    layout: {
        topStart: {
            //buttons: ['csv', 'excel'],
        }
    }   */ 
});

/*
new DataTable('#tabletheml', {
    language: {
        url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/ar.json',
    },    
    initComplete: function () {
        this.api()
            .columns()
            .every(function () {
                let column = this;
 
                // Create select element
                let select = document.createElement('select');
                select.add(new Option(''));
                column.footer().replaceChildren(select);
 
                // Apply listener for user change in value
                select.addEventListener('change', function () {
                    column
                        .search(select.value, {exact: true})
                        .draw();
                });
 
                // Add list of options
                column
                    .data()
                    .unique()
                    .sort()
                    .each(function (d, j) {
                        select.add(new Option(d));
                    });
            });
    }
});
*/
/*
$('#tabletheml').dataTable( {
    "iDisplayLength": 50,
  "language": {
    "search": "بحث:&nbsp;"
  }
} );
*/
/*
document.addEventListener("DOMContentLoaded", function() {
    // Select all textareas with the class 'my-ckeditor-instance'
    var textareas = document.querySelectorAll('.myCk');

    // Iterate through each textarea and replace it with a CKEditor instance
    textareas.forEach(function(textarea) {
        CKEDITOR.replace(textarea.id); // Use the ID of the textarea
    });
});*/
    CKEDITOR.replace('editor');
    CKEDITOR.replace('content1');
    CKEDITOR.replace('objects');
/*CKEDITOR.editorConfig = function( config ) {
    config.versionCheck = false;
};    */
</script>
@yield("scriptSection")    
    </body>

</html>