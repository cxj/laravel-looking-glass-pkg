<?php

namespace Cxj\LookingGlass\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        /* @phpstan-ignore-next-line */
        return view('cxj::layouts.app');
    }
}
