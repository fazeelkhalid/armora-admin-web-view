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
        $token = $request->input('token');
        $device = Devices::where('token', $token)->first();
    
        if ($device && $device->is_verified) {
            $scan = new Scans([
                'ip' => $request->input('ip'),
                'token' => $token,
                'device_name' => $device->device_name,
                'code' => GenerateIDController::getID('ss_'),
                'status' => ScanReportStatusType::PENDING,
                'device_id' => $device->code, // Assuming there is a foreign key relationship
            ]);
    
            $scan->save();
    
            return response()->json(['message' => 'Scan created successfully'], 201);
        } elseif ($device && !$device->is_verified) {
            return response()->json(['error' => 'Device not verified'], 400);
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
                $name = $pendingScan->device_name.' / '.GenerateIDController::getID('').'|'.$pendingScan->token;
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
                    $parseFileName = $wordsArray = explode('|', $scanName);
                    $filename = $parseFileName[0];
                    $token = $parseFileName[1];

                   
                    
                    $scanReport = scanReport::create([
                        'code'=> GenerateIDController::getID('sr_'),
                        'device_id' => Devices::getCodeByToken($token)??'de_dbd24775f8ec4',
                        'report_name' => $filename
                    ]);
                    
                    
                    foreach ($fileContent as $data) {
                        $data['scan_report_id'] = $scanReport->code;
                        Vulnerability::create($data);
                    }
                    
                    Scans::markScansAsCompleted($token);
                    Notification::createNotification($scanReport->code, NotificationType::SCAN_REPORT, $filename);
                    return response()->json([
                        'filename' => $filename,
                        'created_date' => $formattedDate,
                        'data' => $fileContent
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