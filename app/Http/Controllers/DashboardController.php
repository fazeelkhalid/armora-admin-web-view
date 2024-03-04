<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Scans;

use App\Models\Vulnerability;
use App\Models\scanReport;
use App\Models\Notification;


class DashboardController extends Controller
{
    public function index()
    {
        // Retrieve the total number of devices
        $dashboardData = [];
        $user =  auth()->user();
        $dashboardData ['total-devices'] = Devices::devicesCount();
        $dashboardData ['total-vulnerability'] = Vulnerability::VulnerabilityCount();
        $dashboardData ['total-report'] = scanReport::ScanReportCount();
        $scanReports = $scanReports = scanReport::whereHas('device.user', function ($query) use ($user) {
                        $query->where('id', $user->id);
                    })
                    ->with('vulnerabilities')
                    ->latest()
                    ->get();
        $dashboardData ['scanReports'] = $scanReports;
        $dashboardData ['vulnerabilityCount'] = ScanReportController::extractInformation($scanReports);

        $info = 0;
        $low = 0;
        $high = 0;
        $medium = 0;
        $critical = 0;
        $total = 0;

        foreach ($dashboardData ['scanReports']  as $scanreport){
          $high = $high + $dashboardData ['vulnerabilityCount'][$scanreport->report_name]['High'];
          $medium = $medium + $dashboardData ['vulnerabilityCount'][$scanreport->report_name]['Medium'];
          $critical = $critical + $dashboardData ['vulnerabilityCount'][$scanreport->report_name]['Critical'];
          $total = $total + $dashboardData ['vulnerabilityCount'][$scanreport->report_name]['Total'];
          $low = $low + $dashboardData ['vulnerabilityCount'][$scanreport->report_name]['Low'];
          $info = $info + $dashboardData ['vulnerabilityCount'][$scanreport->report_name]['Info'];
        }
       
        $dashboardData ['vulnerability-total-info'] = $info;
        $dashboardData ['vulnerability-total-low'] = $low;
        $dashboardData ['vulnerability-total-high'] = $high;
        $dashboardData ['vulnerability-total-critical'] = $critical;
        $dashboardData ['vulnerability-total-medium'] = $medium;
        $dashboardData ['vulnerability-total'] = $total;
        
        if($dashboardData ['vulnerability-total'] == 0){
            $dashboardData ['vulnerability-total'] = 0.001;
        }

    
        return view('admin.dashboard', ['dashboardData' => $dashboardData]);
    }

    public function appDashboard()
    {
        $device = auth()->user();
        
       
        $dashboardData = [];
        $dashboardData['total_inprogress'] = Scans::inProgressScanCountByCode($device->code);
        $dashboardData['total_vulnerability'] = Vulnerability::VulnerabilityCountByCode($device->code);
        $dashboardData['total_report'] = scanReport::ScanReportCountByCode($device->code);
        $dashboardData['client_name'] = $device->device_name;

        
        // return
        return response()->json($dashboardData);
    }
}