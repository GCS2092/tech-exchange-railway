<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use Auth;

class MessageController extends Controller
{
    // MessageController.php
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);
    
        $message = Message::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
    
        // Diffuser l'événement avec Pusher
        broadcast(new MessageSent($message))->toOthers();
    
        // Vérifie que la clé 'message' existe bien dans la réponse
        return response()->json([ 'message' => $message ]);

    }
    

}
