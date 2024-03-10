<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Devices;
use App\Models\scanReport;
use App\Models\Vulnerability;
class DownloadReportController extends Controller
{
    public function getReportWithVulnerabilities($id)
    {
        
        $vulnerabilities = Vulnerability::allDetailsBYReportID($id);
        $critical = $vulnerabilities->where('risk', 'Critical')->count();
        $high = $vulnerabilities->where('risk', 'High')->count();
        $medium = $vulnerabilities->where('risk', 'Medium')->count();
        $low = $vulnerabilities->where('risk', 'Low')->count();
        $info = $vulnerabilities->where('risk', 'Info')->count() + $vulnerabilities->where('risk', 'None')->count();
        

        $count = [$critical, $high, $medium, $low, $info];
        return view('downloadReport', ['count' => $count]);
       
    }



















    
}