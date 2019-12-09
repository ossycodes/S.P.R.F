<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function __construct()
    {
        return $this->middleware('JWT');
    }

    public function index()
    {
        return [
            'read' => NotificationResource::collection(auth()->user()->readNotifications),
            'unread' => NotificationResource::collection(auth()->user()->unReadNotifications)
        ];
    }

    public function update()
    {
        auth()->user()->notifications()->where('id', request('id'))->update(['read_at' => now()]);;
    }

    public function delete()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
