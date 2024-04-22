<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function create_task(request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'task_title' => 'required',
            'task_instruction' => 'required',
            'type_of_task' => 'required',
            'task_deadline' => 'required'
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $task = Task::create($input);
        $success['admin_id'] = $task->admin_id;
        $success['subject'] = $task->subject;
        $success['task_title'] = $task->task_title;
        $success['task_instruction'] = $task->task_instruction;
        $success['type_of_task'] = $task->type_of_task;
        $success['task_deadline'] = $task->task_deadline;
        return response()->json(['success' => $success], 201);
    }

    public function task_all(): JsonResponse
    {
        $task = Task::all();

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task, 200);
    }

    public function task_get_id($taskId): JsonResponse
    {
        try {
            $data = Task::where('task_id', $taskId)->first();

            if (!$data) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function delete_task($task_id): JsonResponse
    {
        $task = Task::find($task_id);

        if(!$task){
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Section soft deleted successfully'], 200);
    }
    public function update_task(Request $request, $id): JsonResponse
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'task_title' => 'required',
            'task_instruction' => 'required',
            'type_of_task' => 'required',
            'task_deadline' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation Error.', 'details' => $validator->errors()], 422);
        }

        // Find the task by ID
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // Update the task with the request data
        $task->update($request->all());

        // Prepare success response
        $success['admin_id'] = $task->admin_id;
        $success['subject'] = $task->subject;
        $success['task_title'] = $task->task_title;
        $success['task_instruction'] = $task->task_instruction;
        $success['type_of_task'] = $task->type_of_task;
        $success['task_deadline'] = $task->task_deadline;

        return response()->json(['success' => $success], 200);
    }


    public function task_all_ID($section_id)
    {
        $tasks = Task::where('section_id', $section_id)->get();
        return response()->json($tasks);
    }
}
