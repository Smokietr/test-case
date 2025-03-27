<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStore;
use App\Http\Requests\TasksUpdate;
use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Tasks::paginate(10);

        if (!\request()->ajax()) {
            return view('tasks.index', [
                'tasks' => $tasks,
            ])->render();
        }

        return response()->json($tasks);
    }

    public function store(TaskStore $request)
    {
        $create = Tasks::create($request->only('name', 'description', 'user_id', 'status'));

        if ($create) {
            return response()->json(
                Tasks::with('user')->find($create->id)
            );
        }

        return response()->json([
            'message' => 'Task creation failed',
        ], 500);
    }

    public function update(TasksUpdate $request, $id)
    {
        $update = Tasks::findOrFail($id);

        if ($update->update($request->only('status'))) {
            return response()->json(
                Tasks::with('user')->find($update->id)
            );
        }

        return response()->json([
            'message' => 'Task update failed',
        ], 500);
    }

    public function destroy($id)
    {
        $delete = Tasks::findOrFail($id);

        if ($delete->delete()) {
            return response()->json([
                'message' => 'Task deleted successfully',
            ]);
        }

        return response()->json([
            'message' => 'Task deletion failed',
        ], 500);
    }
}
