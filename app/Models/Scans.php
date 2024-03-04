<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\ScanReportStatusType;

class Scans extends Model
{
    use HasFactory;

    protected $table = 'scans';
    
    protected $fillable = [
        'code', 
        'ip', 
        'token', 
        'status',
        'device_name',
        'device_code'
    ];
    
    public static function inProgressScanCountByCode($code)
    {
        return self::where('device_code', $code) ->where(function($query) {
                    $query->where('status', ScanReportStatusType::INPROGRESS)
                        ->orWhere('status', ScanReportStatusType::PENDING);
                })
                ->count();

    }

    public static function getAllPendingScans()
    {
        return self::where('status', ScanReportStatusType::PENDING)
            ->get();
    }

    public static function markScansAsCompleted($code)
    {
        self::where('code', $code)
            ->where('status', ScanReportStatusType::INPROGRESS)
            ->update(['status' => ScanReportStatusType::COMPLETED]);
    }    

}