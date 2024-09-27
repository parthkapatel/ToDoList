<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\TaskCategories;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tasks::where('user_id',Auth::user()->id)->with('category')->get();
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
    public function store(TaskRequest $request)
    {
        try{
            $taskData = $request->all();
            $taskData['user_id'] = Auth::user()->id;
            $task = Tasks::create($taskData);
            if($task){
                $task = Tasks::where('id',$task->id)->with('category')->first();
                return response()->json([
                    "success" => true,
                    "message" => "Task created successfully",
                    "data" => $task
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "Something is wrong to create task"
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
            $tasks = Tasks::find($id);
            if($tasks){
                return response()->json([
                    'success' => true,
                    'message' => 'Task fetched successfully',
                    'data' => $tasks
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something is wrong to fetch task',
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
    public function update(TaskRequest $request, string $id)
    {
        try{
            $task = Tasks::findOrFail($id);
            $task->update($request->all());
            if($task){
                $task = Tasks::where('id',$id)->with('category')->first();
                return response()->json([
                    "success" => true,
                    "message" => "Task updated successfully",
                    "data" => $task
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "Something is wrong to update task"
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
            $task = Tasks::findOrFail($id)->delete();
            if($task){
                return response()->json([
                    "success" => true,
                    "message" => "Task deleted successfully",
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "Something is wrong to delete Task"
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

    public function updateStatus(Request $request,$id){
        try{
            $status = $request->input('status');
            $task = Tasks::findOrFail($id);
            $task->status = $status;
            $task->save();
            if($task){
                $task = Tasks::where('id',$id)->with('category')->first();
                return response()->json([
                    "success" => true,
                    "message" => "Task Status updated successfully",
                    "data" => $task
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "Something is wrong to update task status"
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
