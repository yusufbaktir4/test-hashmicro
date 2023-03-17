<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\StringHelperTrait;

/**
 * Class Project
 * 
 * @property int $id
 * @property string $uuid
 * @property string $nama_proyek
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property int $status
 * @property int $payment_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Task[] $tasks
 *
 * @package App\Models
 */
class Project extends Model
{
    use StringHelperTrait;

	protected $table = 'project';

	protected $casts = [
		'start_date' => 'date',
		'end_date' => 'date',
		'status' => 'int',
		'payment_status' => 'int'
	];

	protected $fillable = [
		'uuid',
		'nama_proyek',
		'start_date',
		'end_date',
		'status',
		'payment_status',
		'created_by',
		'updated_by'
	];

	protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

	const 	PROJECT_STATUS_NOT_STARTED = 0,
			PROJECT_STATUS_IN_PROGRESS = 1,
			PROJECT_STATUS_COMPLETED = 2;

	const 	PROJECT_PAYMENT_STATUS_NOT_COMPLETED = 0,
			PROJECT_PAYMENT_STATUS_COMPLETED = 1;

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}

	public static function getStatusMap(int $status = null)
    {
        $statuses = [
            self::PROJECT_STATUS_NOT_STARTED => 'Not Started',
            self::PROJECT_STATUS_IN_PROGRESS => 'In Progress',
            self::PROJECT_STATUS_COMPLETED => 'Completed',
        ];

        return $statuses[$status] ?? $status ?? $statuses;
    }

    public static function getPaymentStatusMap(int $status = null)
    {
        $statuses = [
            self::PROJECT_PAYMENT_STATUS_NOT_COMPLETED => 'Unpaid',
            self::PROJECT_PAYMENT_STATUS_COMPLETED => 'Paid'
        ];

        return $statuses[$status] ?? $status ?? $statuses;
    }

    public static function getProjectStatus($projectData) {
        if($projectData->status == self::PROJECT_STATUS_COMPLETED) {
            if($projectData->payment_status == self::PROJECT_PAYMENT_STATUS_COMPLETED) {
                $text = "The project has been completed and payment has been paid";
            } else {
                $text = "The project has been completed and payment has not been paid";
            }
        } elseif($projectData->status == self::PROJECT_STATUS_IN_PROGRESS) {
            if(strtotime(Project::dateFormat($projectData->end_date, 'Y-m-d H:i:s')) < strtotime(Project::dateFormat(now(), 'Y-m-d H:i:s'))) {
                $text = "The project in progress but exceeded the deadline";
            } else {
                $text = "The project in progress and still within the deadline";
            }
        } else {
            $text = "The project hasn't started yet";
        }

        return $text;
    }

    public static function getDataProjectStatus() {
        $projectNotStarted = Project::where('status', self::PROJECT_STATUS_NOT_STARTED)->count();
        $projectInProgress = Project::where('status', self::PROJECT_STATUS_IN_PROGRESS)->count();
        $projectCompleted = Project::where('status', self::PROJECT_STATUS_COMPLETED)->count();

        return [
            'projectNotStarted' => $projectNotStarted,
            'projectInProgress' => $projectInProgress,
            'projectCompleted' => $projectCompleted
        ];
    }

    public static function getPersenCompleteProject(Project $projectData) {
        $taskComplete = $projectData->tasks->where('status', Task::TASK_COMPLETED)->count();
        $allTask = $projectData->tasks->count();
        $percent = ($allTask > 0) ? (int)ceil(($taskComplete / $allTask) * 100) : 0;
        
        return $percent . '%';
    }

    public static function getProjectInProgress() {
        $projectInProgress = Project::where('status', self::PROJECT_STATUS_IN_PROGRESS)->get();

        $arrProject = [];
        foreach ($projectInProgress as $keyProject => $valueProject) {
            $arrTemp = [];
            if(!empty($valueProject->tasks->count())) {
                $arrTemp['projectName'] = $valueProject->nama_proyek;
                $arrTemp['progress'] = self::getPersenCompleteProject($valueProject);
                $arrTemp['users'] = [];

                foreach ($valueProject->tasks as $keyTask => $valueTask) {
                    if(!in_array( $valueTask->user->name, $arrTemp['users'])) {
                        $arrTemp['users'][$keyTask] = $valueTask->user->name;
                    }
                }

                array_push($arrProject, $arrTemp);
            }
        }

        return $arrProject;
    }
}
