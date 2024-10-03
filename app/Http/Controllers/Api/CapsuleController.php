<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Capsule;
use App\Http\Resources\CapsuleResource;

class CapsuleController
{
    public function create(Request $request) {
        $capsule = $request->validate([
            'title' => 'required|max:50|string',
            'message' => 'required|max:500|string'
        ]);
        $capsule = Capsule::create([
            'title' => $capsule['title'],
            'message' => $capsule['message']
        ]);


        return response()->json($capsule, 200);   
    }
    
    public function show() {
        $capsules = Capsule::get(); // Retrieve all users
        return CapsuleResource::collection($capsules);
        
    }

    public function delete($id) {
        // $capsule = Capsule::find($id);
        // // return User::delete();
        // $capsule->delete(); // Delete the specific user

        // return response()->json(['message' => 'Capsule deleted successfully'], 200);

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
            \Log::error('Error deleting capsule: ' . $e->getMessage());
    
            return response()->json(['message' => 'An error occurred while deleting the capsule'], 500);
        }
    }

    public function update() {

    }
}
