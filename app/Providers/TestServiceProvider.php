<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // if (!function_exists('test')) {
        //     function test() {
        //         return 'Test provider working';
        //     }
        // }
        echo $this->test();
    }

    public function test(){
        return 'Test provider working';
    }
}
