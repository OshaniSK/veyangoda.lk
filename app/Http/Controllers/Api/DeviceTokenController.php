<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'platform' => 'required|string|in:web,android,ios',
            'device_name' => 'nullable|string',
            'auth_token' => 'nullable|string',
            'p256dh_key' => 'nullable|string',
        ]);

        $token = $request->user()->deviceTokens()->updateOrCreate(
            ['token' => $request->token],
            [
                'platform' => $request->platform,
                'device_name' => $request->device_name,
                'auth_token' => $request->auth_token,
                'p256dh_key' => $request->p256dh_key,
                'last_used_at' => now(),
            ]
        );

        return response()->json(['message' => 'Token registered', 'token' => $token]);
    }

    public function destroy(Request $request, $id)
    {
        $request->user()->deviceTokens()->where('id', $id)->delete();
        return response()->json(['message' => 'Token deleted']);
    }
}
