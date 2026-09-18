<?php

namespace App\Http\Controllers;

use App\Services\XenditService;
use Illuminate\Http\Request;

class XenditWebhookController extends Controller
{
    /**
     * Webhook callback dari Xendit (invoice paid/expired).
     * Route ini tanpa CSRF (ditandai $except di bootstrap/app.php).
     */
    public function __invoke(Request $request, XenditService $xendit)
    {
        // Verifikasi callback token dari header x-callback-token
        $callbackToken = config('services.xendit.callback_token');
        if (! empty($callbackToken) && $request->header('x-callback-token') !== $callbackToken) {
            return response()->json(['error' => 'Invalid callback token'], 403);
        }

        $xendit->handleCallback($request->all());

        return response()->json(['received' => true]);
    }
}
