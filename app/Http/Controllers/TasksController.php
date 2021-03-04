<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =[];
        if (\Auth::check()) {
            
            $user = \Auth::user();
            
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            
            return view('tasks.index', [
            'tasks' => $tasks,
            ]);
        }
        
        return view('welcome', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        $task = new Task;
        if (\Auth::check()) {
            $user = \Auth::user();
            return view('tasks.create', [
            'task' => $task,
        ]);
        }
        
        return view('welcome', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            $request->validate([
            'status' =>'required|max:10',
            'content' => 'required',
        ]);
        
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,  
        ]);
        
        return redirect('/');
        }
        return view('welcome', $data);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            $task = Task::findOrFail($id);

            return view('tasks.show', [
               'user' => $user,
               'task' => $task,
        ]);
        }
        
        return view('welcome', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            $task = Task::findOrFail($id);
   
            return view('tasks.edit', [
            'task' => $task,
        ]);
        }
        return view('welcome', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            $request->validate([
               'status' => 'required|max:10',
               'content' => 'required',
            ]);
            $task = Task::findOrFail($id);
        
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();

            return redirect('/');
        }
        return view('welcome', $data);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = \App\Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        return redirect('/');
    }
}
