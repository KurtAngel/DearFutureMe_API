<?php

namespace App\Http\Controllers\Api;

use App\Models\Capsule;
use App\Models\capsules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\CapsuleResource;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class CapsuleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['show'])
        ];
    }   
    public function send(Request $request) {
        
    }

    public function index() {
        $capsules = Capsule::get(); // Retrieve all users
        return CapsuleResource::collection($capsules);
        
    }

    public function destroy(Capsule $capsule) {

        // Check if the capsule exists
        Gate::authorize('modify', $capsule);
        
        if (!$capsule) {
            return response()->json(['message' => 'Capsule not found'], 404);
        }
    
            // Delete the specific capsule
            $capsule->delete();
    
            return response()->json(['message' => 'Capsule deleted successfully'], 200);
    }

    public function store(Request $request) {
        $capsule = $request->validate([
            'title' => 'required|max:50|string',
            'message' => 'required|max:500|string',
            'content' => 'nullable'
        ]);

        $capsules = $request->user()->capsules()->create($capsule);

        return response()->json($capsules, 200);  
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
