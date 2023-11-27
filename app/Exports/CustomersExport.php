<?php
namespace App\Exports;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomersExport implements FromView
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($customers)
    {
        // dd($customers);
        $this->customers = $customers;
    }

    public function view(): View
    {
        return view('exports.customers_data', [
            'customers' => $this->customers
        ]);
    }
}
