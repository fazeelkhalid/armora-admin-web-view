<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CSVScrapperController extends Controller
{
    public function convertCsvToJson($csvString)
    {
        
        $rows = explode("\n\"", $csvString);
        array_shift($rows); 
       
        $records = [];
        foreach ($rows as $row) {
           
            if(!empty($row)){
                $col = explode("\",", $row);

                if(count($col) == 13){
                    $record = [
                        'plugin_id' => str_replace('"', '', $col[0]),
                        'cve' => str_replace('"', '', $col[1]),
                        'cvss_risk_score' => str_replace('"', '', $col[2]),
                        'risk' => str_replace('"', '', $col[3]),
                        'host' => str_replace('"', '', $col[4]),
                        'protocol' => str_replace('"', '', $col[5]),
                        'port' => str_replace('"', '', $col[6]),
                        'name' => str_replace('"', '', $col[7]),
                        'synopsis' => str_replace('"', '', $col[8]),
                        'description' => str_replace('"', '', $col[9]),
                        'solution' => str_replace('"', '', $col[10]),
                        'see_also' => str_replace('"', '', $col[11]),
                        'plugin_output' => str_replace('"', '', $col[12]),
                    ];
                    $records[] = $record; 
                }
            }
        }

        return $records;
    }
}