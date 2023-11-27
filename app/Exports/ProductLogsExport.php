<?php
namespace App\Exports;

use App\ProductUpdateLog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductLogsExport implements FromView
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($logs)
    {
        $this->logs = $logs;
        // dd($logs);
    }

    public function view(): View
    {
        return view('exports.productactionlog', [
            'logs' => $this->logs
        ]);
    }
}
