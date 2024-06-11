<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $notifications = Auth::user()->notifications()->orderBy('statut', 'asc')->orderBy('created_at', 'desc')->paginate($perPage);
        return NotificationResource::collection($notifications);
    }

    public function show(Notification $notification)
    {
        return new NotificationResource($notification);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update([
            'statut' => true,
            'read_at' => now(),
        ]);
        return response()->json(['message' => 'Notification marquée comme lue']);
    }

    public function markAsUnread(Notification $notification)
    {
        $notification->update([
            'statut' => false,
            'read_at' => null,
        ]);
        return response()->json(['message' => 'Notification marquée comme non lue']);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(['message' => 'Notification supprimée']);
    }
    public function markAllAsRead()
    {
        $user = Auth::user();
        $unreadNotifications = $user->notifications()->where('statut', false)->get();
    
        if ($unreadNotifications->isEmpty()) {
            return response()->json(['message' => 'Aucune notification non lue trouvée'], 404);
        }
    
        $unreadNotifications->each(function ($notification) {
            $notification->update([
                'statut' => true,
                'read_at' => now(),
            ]);
        });
    
        return response()->json(['message' => 'Toutes les notifications marquées comme lues'], 200);
    }
    
    public function markAllAsUnread()
    {
        $user = Auth::user();
        $readNotifications = $user->notifications()->where('statut', true)->get();
    
        if ($readNotifications->isEmpty()) {
            return response()->json(['message' => 'Aucune notification lue trouvée'], 404);
        }
    
        $readNotifications->each(function ($notification) {
            $notification->update([
                'statut' => false,
                'read_at' => null,
            ]);
        });
    
        return response()->json(['message' => 'Toutes les notifications marquées comme non lues'], 200);
    }

}