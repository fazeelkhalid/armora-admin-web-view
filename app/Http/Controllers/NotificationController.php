<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Notification;

use App\Enums\NotificationType;

class NotificationController extends Controller
{
    public function index()
    {
        Notification::getNotification();
        die();
    }

    public function getNotification()
    {

        
        
        $groupedNotifications = Notification::getNotification();
        $html = '';

        if(count($groupedNotifications) == 0){
            $html ='
                <div class="card-body text-center  mt-4 mb-4">               
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 text-truncate ms-2">
                        <h5 class="noti-item-title fw-semibold font-16">No new notifications</h5>
                    </div>
                </div>
            </div>
            ';
        }

        foreach ($groupedNotifications as $dateKey => $notificationsForDate) {
            $html .= '<h5 class="text-muted font-13 fw-normal mt-0">' . $dateKey . '</h5>';

            foreach ($notificationsForDate as $notification) {
                if ($notification->type === NotificationType::SCAN_REPORT) {
                    $html .= '<a href="' . url('notification/scan-report/' . str_replace('sr_', '', $notification->scanReport->code)) . '" class="dropdown-item p-0 notify-item card ' . ($notification->is_read ? 'unread-noti' : 'read-noti') . ' unread-noti shadow-none mb-2">
                        <div class="card-body">
                           
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="notify-icon bg-primary">
                                        <i class="mdi mdi-book-edit-outline"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 text-truncate ms-2">
                                    <h5 class="noti-item-title fw-semibold font-14">' . $notification->scanReport->report_name . '</h5>
                                    <small class="noti-item-subtitle text-muted">' . \Carbon\Carbon::parse($notification->created_at)->format('g:i A') . '</small>
                                </div>
                            </div>
                        </div>
                    </a>';
                }
            }
        }
        
        return response()->json(['html' => $html], 200);
    }

    public function getReportByNotifications($id){
        $id = 'sr_'.$id;
        Notification::markAsRead($id);
        return VulnerabilityController::reportVulnerability(str_replace('sr_', '', $id));
    }

    public static function hasUnreadNotifications(){
        return  Notification::hasUnreadNotifications();
    }

    public function markAllRead(){
        Notification::markAllAsReadForUser();
        return response()->json(['message' => "Mark all the notification as read"], 200);
    }

    public function markAllUnRead(){
        Notification::markAllAsUnReadForUser();
        return response()->json(['message' => "Mark all the notification as read"], 200);
    }

}