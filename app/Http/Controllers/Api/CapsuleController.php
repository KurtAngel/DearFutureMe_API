<?php

namespace App\Http\Controllers\Api;

use App\Models\Capsule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\CapsuleResource;

class CapsuleController
{
    public function create(Request $request) {
        $capsule = $request->validate([
            'title' => 'required|max:50|string',
            'message' => 'required|max:500|string'
        ]);

        $capsules = Capsule::create([
            'title' => $capsule['title'],
            'message' => $capsule['message']
        ]);


        return response()->json($capsules, 200);   
    }
    
    public function show() {
        $capsules = Capsule::get(); // Retrieve all users
        return CapsuleResource::collection($capsules);
        
    }

    public function delete($id) {
        try {
            // Find the capsule by ID
            $capsule = Capsule::find($id);
    
            // Check if the capsule exists
            if (!$capsule) {
                return response()->json(['message' => 'Capsule not found'], 404);
            }
    
            // Delete the specific capsule
            $capsule->delete();
    
            return response()->json(['message' => 'Capsule deleted successfully'], 200);
        } catch (\Exception $e) {
            // Log the exception if needed
            Log::error('Error deleting capsule: ' . $e->getMessage());
    
            return response()->json(['message' => 'An error occurred while deleting the capsule'], 500);
        }
    }

    public function update() {
        
    }
}
