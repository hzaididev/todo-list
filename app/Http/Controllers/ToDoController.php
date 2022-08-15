<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $tasks = ToDo::all();
      return view('index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $storeData = $request->validate([
        'name' => 'required|max:255'
      ]);
      if ($request->has('status')) {
        $storeData['status'] = $request->has('status');
        $storeData['completed_at'] = Carbon::now();
      }

      ToDo::create($storeData);

      return redirect('/todos')->with('completed', 'Task created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToDo  $toDo
     * @return \Illuminate\Http\Response
     */
    public function show(ToDo $toDo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $task = ToDo::findOrFail($id);
      return view('update', compact('task'));
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
      $updateData = $request->validate([
        'name' => 'required|max:255'
      ]);

      $updateData['status'] = $request->has('status');
      if ($request->has('status')) {
        $updateData['completed_at'] = Carbon::now();
      } else {
        $updateData['completed_at'] = null;
      }
      ToDo::whereId($id)->update($updateData);

      return redirect('/todos')->with('completed', 'Task has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $task = ToDo::findOrFail($id);
      $task->delete();

      return redirect('/todos')->with('completed', 'Task has been deleted');
    }
}
