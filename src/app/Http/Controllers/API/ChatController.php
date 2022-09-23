<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Kreait\Firebase\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(__DIR__ . '/telemedicine-id-firebase-adminsdk-g7m3c-760e9339f1.json')
            ->withDatabaseUri(env('FIREBASE_DATABASE_URI'));

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }

    public function sendChat(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => 'required|integer',
            'user_id' => 'required|integer',
            'message' => 'required|string',
        ]);

        $date = Carbon::now()->addHour(7)->toDateTimeString();
        
        $ref = $this->database->getReference('chatroom/'.$data['doctor_id'].'-'.$data['user_id'].'/chat')
        ->push([
                "message" => $data['message'],
                "sender" => "doctor",
                "time" => $date,
        ]);
    }
}
