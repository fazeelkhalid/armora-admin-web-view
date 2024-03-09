<?php

namespace App\Http\Controllers;
use App\Http\Middleware\NessusAuthMiddleWare;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CSVScrapperController;
use App\Http\Controllers\GenerateIDController;


use App\Models\Vulnerability;
use App\Models\scanReport;
use App\Models\Notification;
use App\Models\Devices;
use App\Models\Scans;

use App\Enums\NotificationType;
use App\Enums\ScanReportStatusType;

class ScanController extends Controller
{
    // this will start a scan on a single request
    public function scan($ip, $name)
    {

        $apiToken = env('NESSUS_API_TOKEN');

        $sessionToken = Session::get('nessus_token');

        $requestBody = [
            'uuid' => env('NESSUS_SCAN_UUID'),
            'settings' => [
                'name' => $name,
                'enabled' => true,
                'launch' => 'ON_DEMAND',
                'text_targets' => $ip,
            ],
            'user_permissions' => 128,
        ];


        // scan init request
        $response = Http::withoutVerifying()->withHeaders([
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
            'X-Api-Token' => $apiToken,
            'X-Cookie' => "token={$sessionToken}",
        ])->post(env('NESSUS_URL').'/scans', $requestBody);

        
        
        if ($response->successful()) {

            $scanId = $response->json()['scan']['id'];
            
            // Now send nessus scan launch request
            $launchResponse = Http::withoutVerifying()->withHeaders([
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
                'X-Api-Token' => $apiToken,
                'X-Cookie' => "token={$sessionToken}",
            ])->post(env('NESSUS_URL') . "/scans/{$scanId}/launch");
    

            if ($launchResponse->successful()) {
                return response()->json([
                    'scan_id' => $scanId,
                    'launch_response' => $launchResponse->json()
                ],  $launchResponse->status());
            }
            else {
                return response()->json([
                    'error' => 'Nessus launch scan request failed',
                    'response' => $launchResponse->json(),
                ], $launchResponse->status());
            }
        } 
        else {
            return response()->json([
                'error' => 'Nessus scan request failed',
                'response' => $response->json(),
            ], $response->status());
        }
    }

    public function storeScanRequest(Request $request)
    {
        $device = auth()->user();
    
        
        if ($device && $device->is_verified && $device->current_ip) {

            $existingScan = Scans::where('ip', $device->current_ip)
                ->where('device_code', $device->code)
                ->whereIn('status', [ScanReportStatusType::PENDING, ScanReportStatusType::INPROGRESS])
                ->first();

            if ($existingScan) {
                return response()->json(['error' => 'Scan already in progress on this device'], 400);
            }

            $scan = new Scans([
                'ip' => $device->current_ip,
                'device_name' => $device->device_name,
                'device_code' => $device->code,
                'code' => GenerateIDController::getID('ss_'),
                'status' => ScanReportStatusType::PENDING,
            ]);
    
            $scan->save();    
            return response()->json(['message' => 'Scan created successfully'], 201);
                    
        } elseif ($device && !$device->is_verified) {
            return response()->json(['error' => 'Device not verified'], 400);
        } elseif ($device && !$device->current_ip) {
            return response()->json(['error' => 'Device not connected with the server'], 400);
        } else {
            return response()->json(['error' => 'Device not found'], 404);
        }
    }
    
    public function startNessusScan()
    {
        $pendingScans = Scans::getAllPendingScans();
        $responses = [];
        if ($pendingScans->isNotEmpty()) {
            foreach ($pendingScans as $pendingScan) {
                $name = $pendingScan->code;
                $response = $this->scan($pendingScan->ip, $name);
        
                if ($response->status() == 200) {
                    $pendingScan->update(['status' => ScanReportStatusType::INPROGRESS]);
                }
                $responses[] = [
                    'id' => $pendingScan->id,
                    'code' => $pendingScan->code,
                    'response' => $response,
                ];
            }
            return response()->json(['message' => 'Pending scans processed', 'nessus_responses' => $responses], 200);
        } else {
            return response()->json(['message' => 'No pending scans found'], 404);
        }        
    }

    public function exportReport($scanId, $scanName)
    {

        $apiToken = env('NESSUS_API_TOKEN');
        $sessionToken = Session::get('nessus_token');
        
        $headers = [
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
            'X-Api-Token' => $apiToken,
            'X-Cookie' => "token={$sessionToken}",
        ];

        $requestBody = [
            "format" => "csv",
            "template_id" => "",
            "reportContents" => [
                "csvColumns" => [
                    "id" => true,
                    "cve" => true,
                    "cvss" => true,
                    "risk" => true,
                    "hostname" => true,
                    "protocol" => true,
                    "port" => true,
                    "cvss3_base_score" => false,
                    "cvss3_temporal_score" => false,
                    "cvss_temporal_score" => false,
                    "description" => true,
                    "exploitable_with" => false,
                    "plugin_information" => false,
                    "plugin_name" => true,
                    "plugin_output" => true,
                    "references" => false,
                    "risk_factor" => false,
                    "see_also" => true,
                    "solution" => true,
                    "stig_severity" => false,
                    "synopsis" => true,
                    "vpr_score" => false
                ]
            ],
            "extraFilters" => [
                "host_ids" => [],
                "plugin_ids" => []
            ]
        ];

        try {
            $exportResponse = Http::withoutVerifying()->withHeaders([
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
                'X-Api-Token' => $apiToken,
                'X-Cookie' => "token={$sessionToken}",
            ])->post(env('NESSUS_URL')."/scans/{$scanId}/export", $requestBody);
            if ($exportResponse->successful()) {
                $exportResponse = $exportResponse->json(); 
                $token = $exportResponse['token'];
        
                $downloadResponse = Http::withoutVerifying()->get(env('NESSUS_URL')."/tokens/{$token}/download");
                if ($downloadResponse->successful()) {

                    $filename = $downloadResponse->header('Content-Disposition');
                    $createdDate = $downloadResponse->header('Date');

                    preg_match('/filename="([^"]+)"/', $filename, $matches);
                    $filename = isset($matches[1]) ? $matches[1] : null;


                    $createdDate = strtotime($createdDate);
                    $formattedDate = date('Y-m-d H:i:s', $createdDate);
                    $fileContent = $downloadResponse->body();
                    
                    $csv = new CSVScrapperController();
                    $fileContent = $csv->convertCsvToJson($fileContent);
                    

                    $scan = Scans::where('code', $scanName)->first();
                    
                    if ($scan && $scan->status == ScanReportStatusType::INPROGRESS) {
                        
                        $device_id = $scan->device_code;
                        $report_name = $scan->device_name . ' / ' . str_replace('ss_', '', $scan->code);
                        if($device_id){
                            $scanReport = scanReport::create([
                                'code'=> GenerateIDController::getID('sr_'),
                                'device_id' => $device_id,
                                'report_name' => $report_name
                            ]);
                            
                            
                            foreach ($fileContent as $data) {
                                $data['code'] = GenerateIDController::getID('vu_');
                                $data['scan_report_id'] = $scanReport->code;
                                Vulnerability::create($data);
                            }
                            
                            Scans::markScansAsCompleted($scan->code);
                            Notification::createNotification($scanReport->code, NotificationType::SCAN_REPORT, $device_id);

                            return response()->json([
                                'filename' => $report_name,
                                'created_date' => $formattedDate,
                                'data' => $fileContent
                            ]);
                        }
                        return response()->json([
                            'message' => "Device not found with the help of the token",
                            'device_token' =>  $scanName
                            
                        ]);
                    }
                    
                    return response()->json([
                        'message' => "scan not found",
                        'scan_code' => $scanName
                        
                    ]);
                    
                } else {
                    return response()->json([
                        'error' => 'Download request failed with status code ' . $downloadResponse->status(),
                    ], $downloadResponse->status());
                }
            } else {
                return response()->json([
                    'error' => 'Request failed with status code ' . $exportResponse->status(),
                ], $exportResponse->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500); 
        }
    }

    public function getAllScans()
    {
        $nessus = new NessusAuthMiddleWare();
        if(!$nessus->nessusLogin()){
            return response()->json(['error' => 'Nessus authentication failed'], $response->status());            
        }
        
        $sessionToken = Session::get('nessus_token');
        
        $response = Http::withHeaders([
                'X-Cookie' => "token={$sessionToken}",
            ])
            ->withoutVerifying()
            ->get(env('NESSUS_URL').'/scans');

        $completedScanIds = [];
        $completedScanNames = [];
        
        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['scans'])) {                
                $completedScans = array_filter($data['scans'], function ($scan) {
                    return $scan['status'] === 'completed';
                });
                $completedScanIds = array_column($completedScans, 'id');
                $completedScanNames = array_column($completedScans, 'name');
            }
            return response()->json(['completed_scan' => $completedScanIds, "name" => $completedScanNames]);
        }
        
        return response()->json(['error' => $error], $response->status());
    }
    
    function deleteScan($scanId) {
    
        $headers = [
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
            'X-Api-Token' => env('NESSUS_API_TOKEN'),
            'X-Cookie' => 'token=' . Session::get('nessus_token'),
        ];
    
        $response = Http::withHeaders($headers)
            ->withoutVerifying()
            ->delete(env('NESSUS_URL') . "/scans/" . $scanId);
    
        // Check for errors
        if ($response->failed()) {
            return ['error' => $response->body()];
        }
    
        return $response->json();
    }
    
}