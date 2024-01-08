<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ScanController;

class SchedulerController extends Controller
{
    public function dumpNessusData() {
        
        $nessusScan = new ScanController();
        $response = $nessusScan->getAllScans();
        if ($response->status() == 200) {
            $scanIds = $response->getData()->completed_scan; 
            $scanNames = $response->getData()->name;
            $count = count($scanIds);
            if (count($scanIds) == count($scanNames)) {
                for ($index = 0; $index < $count; $index++) {
                    $scanId = $scanIds[$index];
                    $scanName = $scanNames[$index];
                    
                    $reportResponse = $nessusScan->exportReport($scanId, $scanName);
        
                    if ($reportResponse->status() == 200) {
                        // $nessusScan->deleteScan($scanId);
                    }
                }
            }
        }
    }
}