<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ScanController;

class SchedulerController extends Controller
{
    public function dumpNessusData() {
        $nessusScan = new ScanController();
        $allResponses = [];
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
                    print_r($reportResponse);
                    die();
                    if ($reportResponse->status() == 200) {
                        $deleteResponse = $nessusScan->deleteScan($scanId);

                        // Store the responses in an array
                        $allResponses[] = [
                            'scanId' => $scanId,
                            'scanName' => $scanName,
                            'reportResponse' => $reportResponse,
                            'deleteResponse' => $deleteResponse
                        ];
                    }
                }
                return response()->json(['data_response' => $allResponses], 200);
            }
            return response()->json(['eror' => "not able to fetch all the scans"], 401);
        }
        return $response;
    }
}