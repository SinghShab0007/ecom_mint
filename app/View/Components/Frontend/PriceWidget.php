<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class PriceWidget extends Component
{
    public $prices;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->prices = $prices;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.price-widget');
    }
}
