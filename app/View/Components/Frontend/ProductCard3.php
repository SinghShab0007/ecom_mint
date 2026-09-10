<?php

namespace App\View\Components\Frontend;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ProductCard3 extends Component
{
    /**
     * Product details
     *
     * @var Collection
     */
    public $product;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.product-card3');
    }
}
