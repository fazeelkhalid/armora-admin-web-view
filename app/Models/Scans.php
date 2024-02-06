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
        'device_name'
    ];
    
    public static function inProgressScanCountByToken($token)
    {
        return self::where('token', $token) ->where(function($query) {
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

    public static function markScansAsCompleted($token)
    {
        self::where('token', $token)
            ->where('status', ScanReportStatusType::INPROGRESS)
            ->update(['status' => ScanReportStatusType::COMPLETED]);
    }    

}