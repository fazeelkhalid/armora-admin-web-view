<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Devices;
use App\Models\scanReport;
use App\Models\Vulnerability;
class DownloadReportController extends Controller
{
    public function getReportWithVulnerabilities($id)
    {
        $id = 'sr_'.$id;
        $vulnerabilities = Vulnerability::allDetailsBYReportID($id);
        
        $scanReport = scanReport::find($id);

        if(!$scanReport){
            abort(404);
        }

        $critical = 0;
        $high = 0;
        $medium = 0;
        $low = 0;
        $info = 0;
        if($vulnerabilities){
            $critical = $vulnerabilities->where('risk', 'Critical')->count();
            $high = $vulnerabilities->where('risk', 'High')->count();
            $medium = $vulnerabilities->where('risk', 'Medium')->count();
            $low = $vulnerabilities->where('risk', 'Low')->count();
            $info = $vulnerabilities->where('risk', 'Info')->count() + $vulnerabilities->where('risk', 'None')->count();
        }
        $count = [$critical, $high, $medium, $low, $info];

        return view('downloadReport', [
            "count" => $count,
            "report_name" => $scanReport->report_name,
            "created_at" => $scanReport->created_at,
            "vulnerabilities" => $vulnerabilities
        ]);
    }
}