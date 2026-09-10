<?php

namespace App\View\Components\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageNavigation extends Component
{
    public $paginator;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.frontend.page-navigation');
    }
}
