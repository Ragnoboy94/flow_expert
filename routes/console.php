<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('process:xml', function () {
    $this->call(\App\Console\Commands\ProcessXmlData::class);
})->describe('Process the XML data and store it in the database');
