<?php

namespace Cxj\LookingGlass\Facades;

use Illuminate\Support\Facades\Facade;

class LookingGlass extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'looking-glass';
    }
}
