<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ScanReport extends Model
{
    use HasFactory;

    protected $table = 'scan_reports';
    
    protected $primaryKey = 'code';
    public $incrementing = false;
    
    protected $fillable = [
        'code',
        'device_id',
        'report_name'
    ];
    
    public function vulnerabilities()
    {
        return $this->hasMany(Vulnerability::class, 'scan_report_id', 'code');
    }

    public function device()
    {
        return $this->belongsTo(Devices::class, 'device_id', 'code');
    }
    

    public static function ScanReportCount(){
        return ScanReport::whereHas('device.user', function ($query) {
            $query->where('id', auth()->user()->id);
        })->count();
    }

    public static function ScanReportCountByToken($token){
        return ScanReport::whereHas('device', function ($query) use ($token) {
            $query->where('token', $token);
        })->count();
    }

}