<?php
namespace App\Exports;

use App\StaffActionLog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StaffActionLogExport implements FromView
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
        return view('exports.staff_action_logs', [
            'logs' => $this->logs
        ]);
    }
}
