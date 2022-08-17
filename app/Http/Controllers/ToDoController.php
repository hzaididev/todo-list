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
     * Search and display listing of the resource.
     *
     * params:
     * start (date)
     * end (date)
     * field (string)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function analytics(Request $request)
    {
      $tasksCount = $tasksCompleted = 0;
      $startDate = $endDate = null;
      $searchField = 'created_at';
      $field = 'created';

      if ($request->has('start')) {
        $startDate = $request->query('start');
      }
      if ($request->has('end')) {
        $endDate = $request->query('end');
      }
      if ($request->has('field')) {
        $field = $request->query('field');
        if ($field == 'created') {
          $searchField = 'created_at';
        } elseif ($field == 'completed') {
          $searchField = 'completed_at';
        }
      }

      if (is_null($startDate) && is_null($endDate)) {
        $startDate = date('Y-m-d', strtotime('-7 days'));
        $endDate = date('Y-m-d', strtotime("now"));
      }

      if ($startDate && $endDate) {
        $tasks = ToDo::whereDate($searchField, '>=', $startDate)
          ->whereDate($searchField, '<=', $endDate)->get();
      } elseif (!is_null($startDate) && is_null($endDate)) {
        $tasks = ToDo::whereDate($searchField, '>=', $startDate)->get();
      } elseif (is_null($startDate) && !is_null($endDate)) {
        $tasks = ToDo::whereDate($searchField, '<=', $endDate)->get();
      }

      if ($tasks) {
        $tasksCount = $tasks->count();
        $tasksCompleted = $tasks->where('status','=','1')->count();
      }

      return view('analytics', compact('tasks','tasksCount', 'tasksCompleted', 'field', 'startDate', 'endDate'));
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
