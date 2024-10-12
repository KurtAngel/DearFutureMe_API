<?php

namespace App\Http\Controllers\Api;

use App\Models\Capsule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\CapsuleResource;
use App\Models\ReceivedCapsule;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class CapsuleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index'])
        ];
    }
    public function send(Request $request, ReceivedCapsule $capsule) {
        
        // Gate::authorize('modify', $capsule);

        $capsule = $request->validate([
            'title' => 'required|max:50|string',
            'message' => 'required|max:500|string',
            'content' => 'nullable',
            'receiver_email' => 'required',
            'scheduled_open_at' => 'required'
        ]);

        if(!$request->user()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $createdCapsule = $request->user()->receivedCapsule()->create(array_merge($capsule));

        return response()->json([
            'data' => $createdCapsule,
            'message' => 'Capsule sent Successfully'
        ]);
    }

    public function index() {

        //check authenticated user
        $user = Auth::user();
        
        $capsules = Capsule::where('user_id', $user->id)->get();
        
        if($capsules->isEmpty()) {
            return response()->json(['message' => 'No capsules found!'], 404);
        } else {
            return CapsuleResource::collection($capsules);
        } 
    }

    public function show(Capsule $capsule) {

        $user = Auth::user();
    
        // Check if the capsule belongs to the authenticated user
        if ($capsule->user_id !== $user->id) {
            return response()->json(['message' => 'Capsule not found!'], 404);
        }

        // Return the capsule as a resource
        return new CapsuleResource($capsule);
    }

    public function view(ReceivedCapsule $receivedCapsule) {

        // Gate::authorize('modify_receiver', $received_capsule);

        $user = Auth::user();

        if ($receivedCapsule->receiver_email !== $user->email) {
            return response()->json(['message' => 'You do not own this capsule'], 404);
        }

        return response()->json([
            'Info' => $receivedCapsule
        ], 200);
    }

    public function destroy(Capsule $capsule) {

        Gate::authorize('modify', $capsule);
        
        if (!$capsule) {
            return response()->json(['message' => 'Capsule not found'], 404);
        }
    
            // Delete the specific capsule
            $capsule->delete();
    
            return response()->json(['message' => 'Capsule deleted successfully'], 200);
    }

    public function store(Request $request, Capsule $capsule) {

            $capsule = $request->validate([
            'title' => 'required|max:50|string',
            'message' => 'required|max:500|string',
            'content' => 'nullable',
            'receiver_email' => 'nullable'
        ]);

        $capsules = $request->user()->capsules()->create($capsule);

        return response()->json([
            'id' => $capsules['id'],
            'user_id' => $capsules['user_id'],
            'title' => $capsules['title'],
            'message' => $capsules['message'],
            'created_at' => $capsules['created_at']
        ], 200);  
    }
    
    public function update(Request $request, Capsule $capsule) {

        Gate::authorize('modify', $capsule);

        // Check if the capsule exists
        if (!$capsule) {
            return response()->json(['message' => 'Capsule not found'], 404);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|max:50|string',
            'message' => 'required|max:500|string'
        ]);

        // Update the capsule with the validated data

        $capsule->update($validatedData);

        return response()->json([
            'message'=> 'Updated Successfully',
            'info' => $capsule
        ], 200);
        }
}
