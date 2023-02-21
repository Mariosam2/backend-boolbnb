<?php

namespace App\Http\Controllers\API;
use App\Mail\NewMessage;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'apartment_id' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'body' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        $newMessage = new Message();
        $newMessage->fill($data);
        $newMessage->save();
        
        Mail::to('exemple@gmail.com')->send(new NewMessage($newMessage));

        return response()->json([
            'success' => true
        ]);
    }
}
