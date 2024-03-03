<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Devices extends Model
{
    protected $table = 'devices';

    protected $primaryKey = 'code';

    public $incrementing = false; // Assuming 'code' is not an auto-incrementing primary key

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'code',
        'user_id',
        'device_name',
        'MAC_address',
        'operating_system',
        'auth_key',
        'is_verified',
        'is_login',
        'is_active',
        'token'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_login' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scan_reports()
    {
        return $this->hasMany(scanReport::class, 'device_id', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Find and update a device based on Auth-Key and MAC address.
     *
     * @param string $authKey
     * @param string $macAddress
     * @return int Status code (1: Updated and Verified, 2: Auth Key Expired, 0: Not Found)
     */
    public static function verifyDeviceByKey($authKey)
    {
        $device = self::where('auth_key', $authKey)
            ->first();

        $Response = null;
        if ($device) {
            if (!$device->is_verified) {
                $device->update(['is_verified' => true]);
                $Response = response()->json(['message' => 'Device verification successful', 'token'=> $device->token], 200);                
            } else {
                $Response = response()->json(['error' => 'Auth Key expired or already used'], 400);
            }
        }
        else{
            $Response = response()->json(['error' => 'Device not found'], 404);   
        }

        return $Response;;
    }


    public static function verifyDeviceByToken($token)
    {
        $device = self::where('token', $token)->first();

        return $device && $device->is_verified ? 1 : 0;
    }


    

    public static function devicesCount(){
        return Devices::where('user_id', auth()->user()->id)->count();
    }


    public static function deleteDeviceAndRelatedRecords($deviceCode)
    {
        DB::beginTransaction();
        try {
            Devices::where('code', $deviceCode)->where('user_id', auth()->user()->id)->delete();
    
            DB::commit();

            return  response()->json(['message' => 'Vulnerability deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return  response()->json(['message' => "Error deleting device: " . $e->getMessage()], 404);
        }
    }

    public static function getCodeByToken($token)
    {
        $device = Devices::where('token', $token)->first();

        if($device){
            return $device->code;
        }
        else{
            return null;   
        }
    }


    public static function getDeviceNameByToken($token)
    {
        $device = self::where('token', $token)->first();

        if ($device) {
            return $device->device_name;
        }

        return null; // Token not found or device not exists
    }


}