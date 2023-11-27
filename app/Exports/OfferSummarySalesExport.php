<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OfferSummarySalesExport implements FromView
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($sales_array)
    {

        $this->sales_array = $sales_array;
    }

    public function view(): View
    {
        return view('exports.offer_wise_sales_summary', [
            'sales_array' => $this->sales_array
        ]);
    }
}
