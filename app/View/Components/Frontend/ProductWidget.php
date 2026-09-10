<?php

namespace App\View\Components\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ProductWidget extends Component
{
    /**
     * Display widget title
     *
     * @var string
     */
    public $title;

    /**
     * Popular products list
     *
     * @var Collection
     */
    public $products;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title,$products)
    {
        $this->title = $title;
        $this->products = $products;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.frontend.product-widget');
    }
}
