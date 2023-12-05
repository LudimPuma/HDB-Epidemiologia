<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //SOLO LETRAS Y ESPACIOS
        Validator::extend('letters_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);
        });
        //SOLO NUMEROS Y GUIONES
        Validator::extend('numbers_with_dash', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9\-]+$/', $value);
        });
        //SOLO NUMEROS
        Validator::extend('only_numbers', function ($attribute, $value) {
            return preg_match('/^[0-9]+$/', $value);
        });
        //SOLO NUMEROS, GUIONES Y LETRAS
        // Validator::extend('numbers_dash_letters', function ($attribute, $value) {
        //     return preg_match('/^[0-9A-Za-z\-]+$/', $value);
        // });
        Validator::extend('numbers_dash_letters', function ($attribute, $value) {
            return preg_match('/^[0-9A-Za-z_\-]+$/', $value);
        });
        //SOLO CERO Y UNO
        Validator::extend('only_zero_one', function ($attribute, $value) {
            return in_array($value, ['0', '1']);
        });
        // SOLO LETRAS, GUIONES, ESPACIOS, PUNTO Y PARÉNTESIS.
        Validator::extend('letters_dash_spaces_dot', function ($attribute, $value) {
            return preg_match('/^[\pL\s\.\-\(\)0-9#]+$/u', $value);
        });
        //EMAIL
        Validator::extend('email_validator', function ($attribute, $value) {
            // Se permiten letras, números, arroba, guion alto, guion bajo y punto
            return preg_match('/^[\pL0-9@\-_\.]+$/u', $value);
        });
        // Validator::extend('letters_dash_spaces_dot', function ($attribute, $value) {
        //     return preg_match('/^[\pL\s\.\-\(\)0-9]+$/u', $value);
        // });
    }
}
