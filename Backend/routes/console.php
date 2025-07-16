<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// ./vendor/bin/pint
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Run PHP Code Sniffer. - Este comando ejecuta Pint, que es un formateador de código para PHP.
// Con el fin de que el código siga las convenciones de estilo de Laravel.
Artisan::command('lint', function () {
    $this->info('Running PHP Code Sniffer...');
    passthru('./vendor/bin/pint');
})->purpose('Run PHP Code Sniffer');
