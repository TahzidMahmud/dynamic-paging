<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StocksExport implements FromView
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($products)
    {
        $this->products = $products;
    }

    public function view(): View
    {
        return view('exports.product_stocks', [
            'products' => $this->products
        ]);
    }
}
