<?php
namespace App\Exports;

use App\Models\OfferActionLog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OfferActionLogsExport implements FromView
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($logs)
    {
        $this->logs = $logs;
    }

    public function view(): View
    {
        return view('exports.offer_action_logs', [
            'logs' => $this->logs
        ]);
    }
}
