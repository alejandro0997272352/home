<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(string $locale)
    {
        if (!in_array($locale, ['es', 'en'])) {
            $locale = 'es';
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        return back();
    }
}
