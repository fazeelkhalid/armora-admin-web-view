<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\GenerateIDController;

use App\Enums\NotificationType;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';

    protected $primaryKey = 'code';
    
    public $incrementing = false; 
    
    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'code',
        'user_id',
        'obj_id',
        'type',
        'is_read',
    ];


    public static function createNotification($obj_id, $type, $device_code){
        $user_id = User::getUserIdByDeviceCode($device_code);
        if($user_id) {
            return self::create([
                'code' =>  GenerateIDController::getID('nf_'),
                'user_id' => $user_id,
                'obj_id' => $obj_id,
                'type' => $type
            ]);
        }
    } 

    public static function getNotification(){
        $user_id = auth()->user()->id;
    
        $notifications = Notification::where('user_id', $user_id)->get();
        
        $groupedNotifications = [];
        
        foreach ($notifications as $notification) {

            $notificationDate = Carbon::parse($notification->created_at);
            $humanReadableDate = $notificationDate->diffForHumans();
            $dateKey = '';
            
            if($notificationDate->isToday()){
                $dateKey = 'Today';
            }
            else if($notificationDate->isYesterday()){
                $dateKey = 'Yesterday';
            }
            else {
                $dateKey = $notificationDate->format('j M Y');
            }
            
            if (!isset($groupedNotifications[$dateKey])) {
                $groupedNotifications[$dateKey] = [];
            }
            
            if ($notification->type === NotificationType::SCAN_REPORT) {
                $scanReport = scanReport::where('code', $notification->obj_id)->first();
                if ($scanReport) {
                    $reportName = $scanReport->report_name;
                    $notification->scanReport = $scanReport;
                }
            }
            $groupedNotifications[$dateKey][] = $notification;
        }
       return $groupedNotifications;
    }
    
    public static function markAsRead($objId)
    {  
        self::where('obj_id', $objId)->where('user_id', auth()->user()->id)->update(['is_read' => 0]);
    }
    
    public static function hasUnreadNotifications()
    {
        return self::where('user_id', auth()->user()->id)->where('is_read', 1)->exists();
    }

    public static function markAllAsReadForUser()
    {
        self::where('user_id', auth()->user()->id)->update(['is_read' => 0]);
    }
    
    public static function markAllAsUnReadForUser()
    {
        self::where('user_id', auth()->user()->id)->update(['is_read' => 1]);
    }

    
}