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
    ];
    
    public static function inProgressScanCountByToken($token)
    {
        return self::where('token', $token) ->where(function($query) {
                    $query->where('status', ScanReportStatusType::INPROGRESS)
                        ->orWhere('status', ScanReportStatusType::PENDING);
                })
                ->count();

    }
}