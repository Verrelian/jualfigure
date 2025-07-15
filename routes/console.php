<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// ❌ Jangan jadwalkan Schedule di sini!
// ✅ Ini hanya untuk membuat command Artisan langsung di CLI

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
