<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        if ($request->filled('website')) { // honeypot
            return response()->noContent();
        }

        $data = $request->validate([
            'name'    => 'required|string',
            'phone'   => 'required|string',
            'email'   => 'nullable|email',
            'message' => 'required|string',
        ]);

        $mailText = "Имя: {$data['name']}
            Телефон: {$data['phone']}
            Email: " . ($data['email'] ?? '-') . "
            Сообщение:
            {$data['message']}";

        Log::info("Новое сообщение с сайта:\n" . $mailText);

        return response()->json(['success' => true]);
    }

}
