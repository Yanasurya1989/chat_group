<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index', [
            'messages' => Message::latest()->limit(50)->get()->reverse(),
            'users'    => \App\Models\User::all(),
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string',
            'file'    => 'nullable|file|max:20480', // max 20MB
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('chat_files', 'public');
        }

        $msg = Message::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'file'    => $filePath,
        ]);

        broadcast(new MessageSent($msg))->toOthers();

        return response()->json(['status' => 'ok']);
    }
}
