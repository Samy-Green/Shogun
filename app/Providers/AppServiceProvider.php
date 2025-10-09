<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;
    use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;

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
    Vite::useStyleTagAttributes(function (?string $src, string $url, ?array $chunk, ?array $manifest) {
      if ($src !== null) {
        return [
          'class' => preg_match("/(resources\/assets\/vendor\/scss\/(rtl\/)?core)-?.*/i", $src) ? 'template-customizer-core-css' :
                    (preg_match("/(resources\/assets\/vendor\/scss\/(rtl\/)?theme)-?.*/i", $src) ? 'template-customizer-theme-css' : '')
        ];
      }
      return [];
    });
    Paginator::useBootstrapFive();

     if (User::exists()) {
        // Rediriger les tentatives d'accès GET vers /register
        Route::get('admin/register', function () {
            return redirect()->route('login');
        })->name('register')->middleware('web');

        // Bloquer les requêtes POST vers /register
        Route::post('admin/register', function () {
            abort(404);
        })->middleware('web');
    }
  }
}