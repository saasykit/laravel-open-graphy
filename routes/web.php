<?php

use Illuminate\Support\Facades\Route;

Route::get('open-graphy', [\SaaSykit\OpenGraphy\Http\Controllers\OpenGraphyController::class, 'openGraphImage'])->name('open-graphy.get');

Route::get('open-graphy/e/{base64EncodedParameters?}', [\SaaSykit\OpenGraphy\Http\Controllers\OpenGraphyController::class, 'openGraphImageEncoded'])->name('open-graphy.encoded.get');

Route::get('open-graphy/test', [\SaaSykit\OpenGraphy\Http\Controllers\OpenGraphyController::class, 'test'])->name('open-graphy.test');
