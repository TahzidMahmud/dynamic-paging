<?php
namespace App\Exports;

use App\Models\HomePageEditLog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class HomePageEditLogsExport implements FromView
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
        return view('exports.home_page_edit_log', [
            'logs' => $this->logs
        ]);
    }
}
