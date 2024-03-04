<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

use App\Models\Devices;
use App\Models\Notification;
use Ramsey\Uuid\Uuid;
use App\Http\Controllers\GenerateIDController;

class DeviceController extends Controller
{

    public function index(){
        
        $devices = Devices::where('user_id', auth()->user()->id)->get();
        return view('admin.devices', ['devices' => $devices]);
    }

    public function addSystem(Request $request){

        $request->validate([
            'operating_system' => 'required|string|in:linux,window',
            'password' => 'required|min:6',
            'device_name' => [
                'required',
                'max:32',
                'min:5',
                Rule::unique('devices')->where(function ($query) use ($request) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
        ], [
            'device_name.required' => 'The device name is required.',
            'device_name.string' => 'The device name must be a string.',
            'device_name.max' => 'The device name must not exceed 64 characters.',
            'device_name.min' => 'The device name must be at least 5 characters.',
            'device_name.unique' => 'The device name `'.$request->input('device_name').'` already exist.',
            
            'operating_system.required' => 'The operating system is required.',
            'operating_system.string' => 'The operating system must be a string.',
            'operating_system.in' => 'The operating system must be either "linux" or "window".',
            
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 6 characters.',
        ]);
        

        $device = new Devices();
        $device->code = GenerateIDController::getID('de_');
        $device->user_id = auth()->user()->id;
        $device->device_name = $request->input('device_name');
        $device->MAC_address = 'TEST-DATA';
        $device->password = bcrypt($request->input('password'));
        $device->operating_system = $request->input('operating_system');
        $device->auth_key = GenerateIDController::getAuthKey();
        $device->token = GenerateIDController::getToken();
        $device->is_verified = false;
        $device->save();
        
        $devices = Devices::where('user_id', auth()->user()->id)->get();
       
        return view('admin.devices', ['devices' => $devices, 'success' => "Update Sucessfully"]);
    }

    public function systemVulnerabilities()
    {
        $devices = Devices::with('scan_reports')->where('user_id', auth()->user()->id)->get();
        $reportCount = [];
        foreach ($devices as $device) {
            $scanReports = $device->scan_reports;
            $reportCount[$device->device_name] = [
                'Total' => $scanReports->count()
            ];
        }
        
        return view('admin.systemsVulnerabilities', ['devices' => $devices, 'reportCount' => $reportCount]);
    }

    
    public function delete($id){
        $id = 'de_'.$id;
        return Devices::deleteDeviceAndRelatedRecords($id);
    }

    public function verifyDeviceByKey(Request $request)
    {
        $request->validate([
            'auth_key' => 'required|string',
        ]);

        return Devices::verifyDeviceByKey(
            $request->input('auth_key'),
        );

    }
    
    public function checkDeviceVerification()
    {
        $device = auth()->user();
        
        if ($device->is_verified == 1) {
            return response()->json([ 'message' => 'Device is verified.'], 200);
        } else {
            return response()->json([ 'message' => 'Device is not verified.'], 404);
        }
    }
    

    public function deviceLogin(Request $request)
    {
        $credentials = request(['device_name', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized Device'], 401);
        }
        
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function updateDeviceStatus(Request $request)
    {
        
        $device = auth()->user();
        $device->update(['is_active' => true]);
    

        return  response()->json($device);
    }

    public function logout(){
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}