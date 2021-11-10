<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = 1;
        $tasks = Task::all();
       
        return view('backend.admin.tasks.index', compact('count', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.admin.tasks.create');
    }

  
    public function store(Request $request)
    {
       
        $data = $this->validate($request, [
            'title' => 'required|min:4',
            'status' => 'required',
            'posturl' => 'required|url'
        ]);
            
        Task::create([
            'title' => $data['title'],
            // 'content' => $data['content'],
            'status' => $data['status'],
            // 'image' => $imagePath,
            // 'video' => $videoPath,
            'posturl' => $data['posturl']
        ]);

        return redirect(route('tasks.index'))->with('message', 'Task added successfully');
    
    }

    public function show(tasks $tasks)
    {
        //
    }

    public function edit(Task $task)
    {

        return view('backend.admin.tasks.update', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
       
         $data = $this->validate($request, [
            'title' => 'required|min:4',
            'status' => 'required',
            'posturl' => 'required|url'
        ]);

        $task->title = $data['title'];
        $task->posturl = $data['posturl'];
        $task->status = $data['status'];
        $task->save();

        return back()->with('message', 'Update Succesful!');
        
    }

    public function destroy(Task $task)
    {
        if($task->image){
            unlink( base_path() . '/uploads'.'/'. $task->image);
        }

        if($task->video){
            unlink( base_path() . '/uploads'.'/'. $task->video);
        }
        
        $task->delete();

        return back()->with('message', 'Delete Successfull');
    }

    public function getfile($filename){
        $realpath = base_path() . '/uploads/media'. '/' .$filename;
        return response()->download($realpath);
    }
}
