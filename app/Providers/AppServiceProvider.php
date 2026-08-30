<?php

namespace App\Providers;

use App\Mail\Transport\CustomGmailTransport;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;

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
        Blade::directive('currency', function ($money) {
            return currency($money);
        });

        Gate::define('admin', function () {
            if(!Auth::check()){
                return false;
            }
            $user = Auth::user();
            if($user->role_id == User::ROLE_admin || $user->role_id == User::ROLE_super_admin) {
                return true;
            }
            return false;
        });

        Gate::define('writetally', function () {
            if(!Auth::check()){
                return false;
            }
            $user = Auth::user();
            if($user->role_id == User::ROLE_bar_user ||
                $user->role_id == User::ROLE_admin ||
                $user->role_id == User::ROLE_super_admin) {
                return true;
            }
            return false;
        });

        $newToken = cache()->remember('dropbox_token', 13000, function () {
            $apiCall = Http::asForm()
                ->post('https://api.dropbox.com/oauth2/token', [
                    'refresh_token' => config('filesystems.disks.backup.refresh_token'),
                    'client_secret' => config('filesystems.disks.backup.appSecret'),
                    'client_id' => config('filesystems.disks.backup.appKey'),
                    'grant_type' => 'refresh_token',
                ]);

            if($apiCall->getStatusCode() == 200){
                return $apiCall->json()['access_token'];
            }

        });

        Storage::extend('dropbox', function (Application $app, array $config) use ($newToken) {
            $adapter = new DropboxAdapter(new DropboxClient($newToken));

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });

        Mail::extend('custom-gmail', function (array $config = [], $mailable = null) {
            return new CustomGmailTransport();
        });
    }
}
