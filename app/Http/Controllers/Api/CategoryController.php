<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::where('user_id',Auth::user()->id)->withCount('tasks')->get();
        return response()->json([
            'success' => true,
            'message' => 'Categories fetched successfully',
            'data' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try{
            $categoryData = $request->all();
            $categoryData['user_id'] = Auth::user()->id;
            $category = Categories::create($categoryData);
            if($category){
                return response()->json([
                    "success" => true,
                    "message" => "Category created successfully",
                    "data" => $category
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "Something is wrong to create category"
                ]);
            }
        }catch (\Exception $e){
            Log::info($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => "Something went wrong"
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $categories = Categories::find($id);
            if($categories){
                return response()->json([
                    'success' => true,
                    'message' => 'Category fetched successfully',
                    'data' => $categories
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something is wrong to fetch category',
                ]);
            }
        }catch (\Exception $e){
            Log::info($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        try{
            $category = Categories::findOrFail($id);
            $category->update($request->all());
            if($category){
                return response()->json([
                    "success" => true,
                    "message" => "Category updated successfully",
                    "data" => $category
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "Something is wrong to update category"
                ]);
            }
        }catch (\Exception $e){
            Log::info($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => "Something went wrong"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $category = Categories::findOrFail($id);
            if(!empty($category) && $category->tasks()->count() > 0){
                return response()->json([
                    "success" => false,
                    "message" => "Cannot delete this category as it has assigned tasks.",
                ]);
            }
            $category = $category->delete();
            if($category){
                return response()->json([
                    "success" => true,
                    "message" => "Category deleted successfully",
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "Something is wrong to delete category"
                ]);
            }
        }catch (\Exception $e){
            Log::info($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => "Something went wrong"
            ]);
        }
    }
}
