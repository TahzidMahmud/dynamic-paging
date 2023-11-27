<?php
namespace App\Exports;

use App\RoleActionLog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RoleActionLogsExport implements FromView
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
        return view('exports.role_Action_logs', [
            'logs' => $this->logs
        ]);
    }
}
