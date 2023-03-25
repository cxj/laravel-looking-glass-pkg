<?php

namespace Cxj\LookingGlassPkg\Facades;

use Illuminate\Support\Facades\Facade;

class LookingGlassPkg extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'looking-glass-pkg';
    }
}
