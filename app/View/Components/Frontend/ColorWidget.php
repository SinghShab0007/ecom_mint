<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class ColorWidget extends Component
{
    public $colors;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($colors)
    {
        $this->colors = $colors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.color-widget');
    }
}
