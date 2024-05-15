<?php

namespace SaaSykit\OpenGraphy\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SaaSykit\OpenGraphy\OpenGraphy
 */
class OpenGraphy extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SaaSykit\OpenGraphy\OpenGraphy::class;
    }
}
