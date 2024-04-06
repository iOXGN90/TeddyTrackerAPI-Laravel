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
        $success['task_instruction'] = $task->task_instruction;  // Corrected assignment
        $success['type_of_task'] = $task->type_of_task;
        $success['task_deadline'] = $task->task_deadline;
        return response()->json(['success' => $success], 201); // Adjusted success response
    }
    public function task_all(): JsonResponse
    {
        $task = Task::all();

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task, 200);
    }
    public function get_task($id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task, 200);
    }
}
