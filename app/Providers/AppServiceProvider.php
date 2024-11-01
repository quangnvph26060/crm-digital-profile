<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\TemplateFormHoSo;
use App\Models\TemplateFormVanBan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Pagination\Paginator;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Users\UserInterface::class,
            \App\Repositories\Users\UserRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admins\AdminInterface::class,
            \App\Repositories\Admins\AdminRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Roles\RoleInterface::class,
            \App\Repositories\Roles\RoleRepository::class
        );
        $this->app->singleton(
            \App\Repositories\PermissionRoles\PermissionRoleInterface::class,
            \App\Repositories\PermissionRoles\PermissionRoleRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Repository $setConfig)
    {
        Paginator::useBootstrap();
        $notifications = Notification::whereNull('user_id')
                                     ->whereNull('admin_id')
                                     ->where('status', 0)
                                     ->get();
        View::share("notifications", $notifications);


        $template_form_hoso = TemplateFormHoSo::where('status', 'active')->first();
        if (!$template_form_hoso) {
            $template_form_hoso = ''; 
        }
        View::share("template_form_hoso", $template_form_hoso);

        $template_form_vanban = TemplateFormVanBan::where('status', 'active')->first();
        if (!$template_form_vanban) {
            $template_form_vanban = ''; 
        }
        View::share("template_form_vanban", $template_form_vanban);
        // $setting = DB::table('smtps')->first();

        // if (!empty($setting)) {
        //     $setConfig->set('mail.driver', $setting->driver);
        //     $setConfig->set('mail.host', $setting->host);
        //     $setConfig->set('mail.port', (int)$setting->port);
        //     $setConfig->set('mail.from.address', $setting->from_email);
        //     $setConfig->set('mail.from.name', $setting->from_name);
        //     $setConfig->set('mail.encryption', $setting->encryption);
        //     $setConfig->set('mail.username', $setting->account);
        //     $setConfig->set('mail.password', $setting->password);
        // }
    }
}
