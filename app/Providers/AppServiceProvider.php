<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
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
    public function boot()
    {
        Validator::extend('template_with_params', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            $template = $data['template'] ?? null;
            $content = json_decode($data['content'] ?? '[]', true);

            switch ($template) {
                case 'exchange_rate':
                    return count($content) == 2;
                case 'resigning':
                    return count($content) == 3;
                default:
                    return true;
            }
        }, 'The :attribute does not match the required parameters for the template.');
    }
}
