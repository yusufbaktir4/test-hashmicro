<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;
use App\Traits\StringHelperTrait;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use Auth;

class TaskService
{
    protected $taskUuid;

    public function __construct($taskUuid = null)
    {
        $this->taskUuid = $taskUuid;
    }

    public function saveToDB(Request $request) {
        try {
            $dataAttribute = [
                                "nama_task" => $request->nama_task,
                                "description" => $request->description,
                                "user_id" => $request->user_id,
                                "project_id" => Project::where('uuid', $request->projectUuid)->first()->id,
                                'created_at' => Task::dateFormat(now(), 'Y-m-d H:i:s'),
                            ];

            if(is_null($this->taskUuid)) {
                $dataAttribute['created_by'] = Auth::user()->email;
            } else {
                $dataAttribute['updated_by'] = Auth::user()->email;
            }

            $taskData = Task::updateOrCreate(
                            ['uuid' => $this->taskUuid],
                            $dataAttribute
                        );

            $data = [
                'valid' => true,
                'msg' => 'Task saved successfully!',
                'taskData' => $taskData
            ];
        } catch (\Illuminate\Database\QueryException $exception) {
            dd($exception->getMessage());
            $data = [
                'valid' => false,
                'msg' => 'Task failed to save!',
                'taskData' => []
            ];
        }

        return $data;
    }

    public function updateStatusTask($status) {
        try {
            $task = Task::where('uuid', $this->taskUuid)
                      ->update([
                        'status' => $status,
                        'updated_by' => Auth::user()->email,
                        'updated_at' => Task::dateFormat(now(), 'Y-m-d H:i:s')
                      ]);

            $taskData = Task::where('uuid', $this->taskUuid)->first();
            $allTask = Task::where('project_id', $taskData->project_id)->count();
            $taskCompleted = Task::where('project_id', $taskData->project_id)->where('status', Task::TASK_COMPLETED)->count();

            if($allTask == $taskCompleted) {
                $projectData = Project::where('id', $taskData->project_id)->first();
                (new ProjectService($projectData->uuid))->updateStatusProject(Project::PROJECT_STATUS_COMPLETED);
            }

            $data = [
                'valid' => true,
                'msg' => 'Task saved successfully!',
                'TaskData' => []
            ];
        } catch (\Illuminate\Database\QueryException $exception) {
            $data = [
                'valid' => false,
                'msg' => 'Task failed to save!',
                'TaskData' => []
            ];
        }

        return $data;
    }

    public function deleteFromDB(array $id = []) {
        try {
            if(!is_null($this->taskUuid)) {
                Task::where('uuid', $this->taskUuid)->delete();
                $valid = true;
            } elseif(!empty($id)) {
                Task::whereIn('uuid', $id)->delete();
                $valid = true;
            } else {
                $valid = false;
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            $valid = false;
        }

        $msg = 'Task failed to delete!';
        if($valid) {
            $msg = 'Task deleted successfully!';
        }

        $data = [
            'valid' => $valid,
            'msg' => $msg
        ];

        return $data;
    }
}
