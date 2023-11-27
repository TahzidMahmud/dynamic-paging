<?php
namespace App\Exports;

use App\Models\ReportActionLog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportActionLogsExport implements FromView
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
        return view('exports.report_action_log', [
            'logs' => $this->logs
        ]);
    }
}
