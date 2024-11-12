<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
class NotificationController extends Controller
{
    //get notification
    public function getNotifications(Request $request)
    {
        $notifications = Notification::orderBy('created_at', 'desc')
            ->get(['id', 'type', 'message', 'read', 'created_at', 'updated_at', 'reservation_id']); 
    
        return response()->json($notifications);
    }
    

   // mark as read
   public function markAsRead(Request $request)
   {
       $user = auth()->guard('customer')->user();
   
       if ($user) {
           try {
               Log::info('Marking notifications as read for user: ' . $user->customer_id);
   
               $unreadNotifications = Notification::where('customer_id', $user->customer_id)
                                                  ->where('read', false)
                                                  ->get();
   
               if ($unreadNotifications->isEmpty()) {
                   Log::info('No unread notifications found for user: ' . $user->customer_id);
                   return response()->json(['message' => 'No unread notifications found for this user']);
               }
   
               $affectedRows = Notification::where('customer_id', $user->customer_id)
                                           ->where('read', false)
                                           ->update(['read' => true]);
   
               Log::info('Number of notifications marked as read: ' . $affectedRows);
   
               if ($affectedRows > 0) {
                   return response()->json(['message' => 'Notifications marked as read']);
               } else {
                   return response()->json(['message' => 'No unread notifications found for this user']);
               }
           } catch (\Exception $e) {
               Log::error('Failed to mark notifications as read: ' . $e->getMessage());
               return response()->json(['message' => 'Failed to mark notifications as read', 'error' => $e->getMessage()], 500);
           }
       }
   
       return response()->json(['message' => 'User not authenticated'], 401);
   }  
}
