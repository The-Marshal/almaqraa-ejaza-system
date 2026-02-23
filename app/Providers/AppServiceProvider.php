<?php

namespace App\Providers;

use App\Http\View\Composers\UrlPresenceComposer;
use Illuminate\Pagination\Paginator; // مهم: استيراد Facade الـ View
use Illuminate\Support\Facades\Blade; // مهم: استيراد الكلاس
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        // تسجيل الـ View Composer ليتم تطبيقه على *جميع* الـ views
        View::composer(
            '*', // هذا يعني جميع الـ Views
            UrlPresenceComposer::class
        );

        // للمدير فقط @admin
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->level == 'admin';
        });

        // للمدير والمشرف فقط  @modOrAdmin
        Blade::if('modOrAdmin', function () {
            return auth()->check() && in_array(auth()->user()->level, ['admin', 'mod']);
        });

        // للمدير والمشرف والمعلم معاً (الطاقم الإداري والتعليمي)  @allStaff
        Blade::if('allStaff', function () {
            return auth()->check() && in_array(auth()->user()->level, ['admin', 'mod', 'teacher']);
        });

        // 4. اختصار للمعلم فقط @teacher
        Blade::if('teacher', function () {
            return auth()->check() && auth()->user()->level == 'teacher';
        });

    }
}
