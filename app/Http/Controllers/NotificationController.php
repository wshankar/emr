<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Http\Resources\BookingResource;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $readNotifications = auth('api')->user()->readNotifications->where('type', '=' ,'App\Notifications\NewTreatment')->all();
        $unreadNotifications = auth('api')->user()->unreadNotifications->where('type', '=' ,'App\Notifications\NewTreatment')->all();
        return [
            'read' => NotificationResource::collection($readNotifications),
            'unread' => NotificationResource::collection($unreadNotifications),
        ];
    }

    public function markAsRead(Request $request)
    {
        $notification = auth('api')->user()->notifications->find($request->id);
        if($notification) {
            $notification->markAsRead(); }
    }

    public function markAllRead()
    {
        auth('api')->user()->unreadNotifications->markAsRead();
    }

    public function booking()
    {
        return Booking::all()->count();
    }
}
