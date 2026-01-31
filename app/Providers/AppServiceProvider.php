<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use App\Models\Contact;
use App\Models\Callback;
use App\Models\JobApplication;
use App\Models\BusinessInquiry;
use App\Models\FreelanceInquiry;
use App\Models\ChatMessage;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('admin.*', function ($view) {
            // General Messages (exclude career) - Cache for 120s
            $unreadContactsCount = Cache::remember('admin_unread_contacts', 120, function () {
                return Contact::where('is_read', false)
                    ->whereNotIn('purpose', ['job_seeker', 'hiring'])
                    ->count();
            });

            // Career Requests (only career) - Cache for 120s
            $unreadCareerCount = Cache::remember('admin_unread_career', 120, function () {
                return Contact::where('is_read', false)
                    ->whereIn('purpose', ['job_seeker', 'hiring'])
                    ->count();
            });

            // Callbacks - Cache for 120s
            $unreadCallbacksCount = Cache::remember('admin_unread_callbacks', 120, function () {
                return Callback::where('is_read', false)->count();
            });

            // Job Applications (real portal) - Cache for 120s
            $unreadJobCount = Cache::remember('admin_unread_job_apps', 120, function () {
                return JobApplication::where('status', 'pending')->count();
            });

            // Business Inquiries - Cache for 120s
            $unreadBusinessCount = Cache::remember('admin_unread_business', 120, function () {
                return BusinessInquiry::where('status', 'pending')->count();
            });

            // Freelance Inquiries - Cache for 120s
            $unreadFreelanceCount = Cache::remember('admin_unread_freelance', 120, function () {
                return FreelanceInquiry::where('status', 'pending')->count();
            });

            $view->with('unreadContactsCount', $unreadContactsCount);
            $view->with('unreadCareerCount', $unreadCareerCount);
            $view->with('unreadCallbacksCount', $unreadCallbacksCount);
            $view->with('unreadJobCount', $unreadJobCount);
            $view->with('unreadBusinessCount', $unreadBusinessCount);
            $view->with('unreadFreelanceCount', $unreadFreelanceCount);
            
            // Unread Chat Messages for Admin (from users) - Cache for 120s
            $unreadAdminChatCount = Cache::remember('admin_unread_chat', 120, function () {
                return ChatMessage::where('is_from_admin', false)->where('is_read', false)->count();
            });
            $view->with('unreadAdminChatCount', $unreadAdminChatCount);
        });

        // Portal Views unread count
        View::composer('portal.*', function ($view) {
            if (auth()->check()) {
                $unreadUserChatCount = auth()->user()->chatMessages()
                    ->where('is_from_admin', true)
                    ->where('is_read', false)
                    ->count();
                $view->with('unreadUserChatCount', $unreadUserChatCount);
            }
        });
    }
}
