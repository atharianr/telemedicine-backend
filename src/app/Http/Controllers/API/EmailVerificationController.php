<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'Already verified'
            ];
        }

        $request->user()->sendEmailVerificationNotification();

        return [
            'message' => 'verification link sent'
        ];
    }

    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->markEmailAsVerified())
            event(new Verified($user));

        return 'Email has been verified';
    }
}
