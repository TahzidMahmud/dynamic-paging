<?php
namespace App\Exports;

use App\Models\CouponActionLog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CouponActionLogsExport implements FromView
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
        return view('exports.coupon_action_logs', [
            'logs' => $this->logs
        ]);
    }
}
