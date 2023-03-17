<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;

class TaskController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($projectUuid)
    {
        $projectData = Project::where('uuid', $projectUuid)->first();
        $users = User::get();
        $actionForm = route('feature.task.store');
        return view('feature.task.create', compact('actionForm', 'projectData', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'nama_task' => 'required|string',
            "description" => "required",
            'user_id' => 'required|exists:users,id',
        ],
        [
            'nama_task.required' => "Task Name can't be blank",
            'description.required' => "Description can't be blank",
            'user_id.required' => "Assign To must be selected one",
            'user_id.exists' => 'User not found'
        ]);

        $response = (new TaskService)->saveToDB($request);

        if($response['valid']) {
            return redirect()->route('feature.project.show', ['project' => $request->projectUuid])->with('success', $response['msg']);
        } else {
            return back()->with('error', $response['msg']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $taskData = Task::where('uuid', $id)->first();
        $projectData = Project::where('id', $taskData->project_id)->first();
        $users = User::get();
        $actionForm = route('feature.task.update', ['task' => $id]);

        if(is_null($projectData)) {
            return redirect()->route('feature.project.show', ['project' => $projectData->uuid])->with('error', 'Project not found');
        } else {
            return view('feature.task.create', compact('actionForm', 'projectData', 'taskData', 'users'));
        }
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
        $validator = $request->validate([
            'nama_task' => 'required|string',
            "description" => "required",
            'user_id' => 'required|exists:users,id',
        ],
        [
            'nama_task.required' => "Task Name can't be blank",
            'description.required' => "Description can't be blank",
            'user_id.required' => "Assign To must be selected one",
            'user_id.exists' => 'User not found'
        ]);

        $response = (new TaskService($id))->saveToDB($request);

        if($response['valid']) {
            return redirect()->route('feature.project.show', ['project' => $request->projectUuid])->with('success', $response['msg']);
        } else {
            return back()->with('error', $response['msg']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = (new TaskService($id))->deleteFromDB();

        if($response['valid']) {
            return redirect()->route('feature.project.index')->with('success', $response['msg']);
        } else {
            return redirect()->route('feature.project.index')->with('error', $response['msg']);
        }
    }

    public function changeStateTask($uuidTask, $status) {
        $response = (new TaskService($uuidTask))->updateStatusTask($status);
        $taskData = Task::where('uuid', $uuidTask)->first();
        $uuidProject = Project::where('id', $taskData->project_id)->first()->uuid;

        if($response['valid']) {
            return redirect()->route('feature.project.show', ['project' => $uuidProject])->with('success', $response['msg']);
        } else {
            return redirect()->route('feature.project.show', ['project' => $uuidProject])->with('error', $response['msg']);
        }
    }
}
