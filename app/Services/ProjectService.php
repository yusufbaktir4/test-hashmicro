<?php

namespace App\Services;

use App\Models\Project;
use App\Traits\StringHelperTrait;
use Illuminate\Http\Request;
use Auth;

class ProjectService
{
    protected $projectUuid;

    public function __construct($projectUuid = null)
    {
        $this->projectUuid = $projectUuid;
    }

    public function saveToDB(Request $request) {
        try {
            $dataAttribute = [
                                "nama_proyek" => $request->nama_proyek,
                                "start_date" => Project::dateFormat($request->start_date, 'Y-m-d H:i:s'),
                                "end_date" => Project::dateFormat($request->end_date, 'Y-m-d H:i:s'),
                                "payment_status" => $request->payment_status,
                                'created_at' => Project::dateFormat(now(), 'Y-m-d H:i:s'),
                            ];

            if(is_null($this->projectUuid)) {
                $dataAttribute['created_by'] = Auth::user()->email;
            } else {
                $dataAttribute['updated_by'] = Auth::user()->email;
            }

            $projectData = Project::updateOrCreate(
                            ['uuid' => $this->projectUuid],
                            $dataAttribute
                        );

            $data = [
                'valid' => true,
                'msg' => 'Project saved successfully!',
                'projectData' => $projectData
            ];
        } catch (\Illuminate\Database\QueryException $exception) {
            $data = [
                'valid' => false,
                'msg' => 'Project failed to save!',
                'projectData' => []
            ];
        }

        return $data;
    }

    public function updateStatusProject($status) {
        try {
            $project = Project::where('uuid', $this->projectUuid)
                      ->update([
                        'status' => $status,
                        'updated_by' => Auth::user()->username,
                        'updated_at' => Project::dateFormat(now(), 'Y-m-d H:i:s')
                      ]);

            $data = [
                'valid' => true,
                'msg' => 'Project saved successfully!',
                'ProjectData' => []
            ];
        } catch (\Illuminate\Database\QueryException $exception) {
            $data = [
                'valid' => false,
                'msg' => 'Project failed to save!',
                'ProjectData' => []
            ];
        }

        return $data;
    }

    public function deleteFromDB(array $id = []) {
        try {
            if(!is_null($this->projectUuid)) {
                Project::where('uuid', $this->projectUuid)->delete();
                $valid = true;
            } elseif(!empty($id)) {
                Project::whereIn('uuid', $id)->delete();
                $valid = true;
            } else {
                $valid = false;
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            $valid = false;
        }

        $msg = 'Project failed to delete!';
        if($valid) {
            $msg = 'Project deleted successfully!';
        }

        $data = [
            'valid' => $valid,
            'msg' => $msg
        ];

        return $data;
    }
}
