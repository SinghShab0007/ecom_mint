<?php

namespace App\View\Components\Frontend;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class SearchBar extends Component
{
    /**
     * Product details
     *
     * @var Collection
     */
    public $products;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.search-bar');
    }
}
