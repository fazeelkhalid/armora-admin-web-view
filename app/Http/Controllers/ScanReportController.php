<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScanReport;
use App\Models\Devices;
use App\Models\Notification;
use DB;

class ScanReportController extends Controller
{
    public function index()
    {
        $user =  auth()->user();
        $scanReports = scanReport::whereHas('device.user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })
        ->with('vulnerabilities')
        ->get();

        $vulnerabilityCount = $this->extractInformation($scanReports);
        
        return view('admin.reports', ['scanReports' => $scanReports, 'vulnerabilityCount' => $vulnerabilityCount]);

    }
      
    public function deviceReports($deviceID){
        $deviceID = 'de_'. $deviceID;

        $user =  auth()->user();
        $scanReports = scanReport::whereHas('device.user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })
        ->where('device_id', $deviceID)
        ->with('vulnerabilities')
        ->get();
        
        $vulnerabilityCount = $this->extractInformation($scanReports);
        
        return view('admin.reports', ['scanReports' => $scanReports, 'vulnerabilityCount' => $vulnerabilityCount]);
    }

    public function delete($id){
        $id = 'sr_'. $id;
        $user =  auth()->user();
        DB::beginTransaction();
        try {
            $scanReport = scanReport::where('code', $id)
            ->whereHas('device.user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })
            ->first();

            $scanReport->delete();

            DB::commit();

            return  response()->json(['message' => 'Report deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return  response()->json(['message' => "Error deleting device: " . $e->getMessage()], 404);
        }
    }

    public static function extractInformation($scanReports){
        $vulnerabilityCount = [];

        foreach ($scanReports as $scanReport) {
            $vulnerabilities = $scanReport->vulnerabilities;
            
            $vulnerabilityCount[$scanReport->report_name] = [
                'Critical' => $vulnerabilities->where('risk', 'Critical')->count(),
                'High' => $vulnerabilities->where('risk', 'High')->count(),
                'Medium' => $vulnerabilities->where('risk', 'Medium')->count(),
                'Low' => $vulnerabilities->where('risk', 'Low')->count(),
                'Info' => $vulnerabilities->where('risk', 'Info')->count() + $vulnerabilities->where('risk', 'None')->count(),
                'Total' => $vulnerabilities->where('risk', 'Info')->count() + 
                        $vulnerabilities->where('risk', 'None')->count() +
                        $vulnerabilities->where('risk', 'Critical')->count() + 
                        $vulnerabilities->where('risk', 'High')->count() +
                        $vulnerabilities->where('risk', 'Medium')->count() +
                        $vulnerabilities->where('risk', 'Low')->count()
            ];
        }
        return $vulnerabilityCount;
    }


}