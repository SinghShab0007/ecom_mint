<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class SizeWidget extends Component
{
    public $sizes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sizes)
    {
        $this->sizes = $sizes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.size-widget');
    }
}
