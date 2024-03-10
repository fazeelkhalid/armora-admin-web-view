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
        if($vulnerabilities->isEmpty()){
            return response()->json(['error' => "Report has zero vulnerabilities, so we can't create a report"], 404);
        }
        $critical = $vulnerabilities->where('risk', 'Critical')->count();
        $high = $vulnerabilities->where('risk', 'High')->count();
        $medium = $vulnerabilities->where('risk', 'Medium')->count();
        $low = $vulnerabilities->where('risk', 'Low')->count();
        $info = $vulnerabilities->where('risk', 'Info')->count() + $vulnerabilities->where('risk', 'None')->count();
        
        $count = [$critical, $high, $medium, $low, $info];
        
        $htmlContent = view('downloadReport', [
            "count" => $count,
            "report_name" => $vulnerabilities[0]->report_name,
            "created_at" => $vulnerabilities[0]->created_at,
            "vulnerabilities" => $vulnerabilities
        ])->render();
        return response()->json(['htmlContent' => $htmlContent], 200);
    }



















    
}