<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category_model;
use Illuminate\Support\Facades\Log;

class Category_Controller extends Controller
{
    public function index(){
        $category = Category_model::all();

        if($category->count() > 0){
            $data = ['success' => true, 'data' => $category];
            return response()->json($data,200);     

        }else{            
            return response()->json(['success' => false, 'message' => 'Something Wrong'],404); 
        }             
    }

    public function store(Request $request){
        $category = Category_model::create([
            'name' => $request->name
        ]);

        if($category){
            return response()->json(['success' => true, 'message' => 'Successfully added'],201);     
        }else{          
            return response()->json(['success' => false, 'message' => 'Error'],404); 
        }  
    }

  
    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:category,id', 
                'name' => 'required|string|max:255',    
            ]);

            $category = Category_model::findOrFail($request->id);

            $category->name = $request->name;
            $category->save();

            Log::info('Category updated successfully.', ['category' => $category]);

            return response()->json(['success' => true, 'message' => 'Category updated successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating category:', ['error' => $e->getMessage()]);

            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
    
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:category,id'
        ]);

        try {
            $category = Category_model::findOrFail($request->id);
            $category->delete();

            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
