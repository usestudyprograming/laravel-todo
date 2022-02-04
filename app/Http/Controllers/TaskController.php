<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// class TaskController extends Controller
// {

//     public function __construct()
//     {
//         $this->middleware('auth');
//     }
    
//     public function index(Folder $folder)
//     {
//         $folders = Auth::user()->folders()->get();

//         $tasks = $folder->tasks()->get();

//         return view('tasks/index', [
//             'folders' => $folders,
//             'current_folder_id' => $folder->id,
//             'tasks' => $tasks,
//         ]);
//     }

//     public function showCreateForm(Folder $folder)
//     {
//         return view('tasks/create', [
//             'folder_id' => $folder->id
//         ]);
//     }

//     public function create(Folder $folder, CreateTask $request)
//     {
//         $task = new Task();
//         $task->title = $request->title;
//         $task->due_date = $request->due_date;

//         $folder->tasks()->save($task);

//         return redirect()->route('tasks.index', [
//             'id' => $folder->id,
//         ]);
//     }

//     public function showEditForm(Folder $folder, Task $task)
//     {
//         return view('tasks/edit', [
//             'task' => $task,
//         ]);
//     }

//     public function edit(Folder $folder, Task $task, EditTask $request)
//     {
//         $task->title = $request->title;
//         $task->status = $request->status;
//         $task->due_date = $request->due_date;
//         $task->save();

//         return redirect()->route('tasks.index',[
//             'id' => $task->folder_id,
//         ]);
//     }
// }

class TaskController extends Controller
{
    public function index(int $id)
    {
        // すべてのフォルダを取得する
        $folders = Auth::user()->folders()->get();

        // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);

        // 選ばれたフォルダに紐づくタスクを取得する
        $tasks = $current_folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    public function create(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    public function showEditForm(int $id, int $task_id)
    {
        $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    public function edit(int $id, int $task_id, EditTask $request)
    {
        $task = Task::find($task_id);
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}