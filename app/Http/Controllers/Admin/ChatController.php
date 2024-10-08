<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $messages = DB::table('ch_messages as ch')
                    ->join('users as u', 'u.id', '=', 'ch.from_id')
                    ->select('ch.id', 'u.name', 'ch.created_at', 'ch.body')
                    ->where('u.user_type', '!=', 0)
                    ->orderBy('ch.id', 'desc')
                    ->get();
                    
        return view('admin.chat.index',compact('messages'));
    }
}
