<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\StringHelperTrait;

/**
 * Class Task
 * 
 * @property int $id
 * @property string $uuid
 * @property string $nama_task
 * @property int $status
 * @property int $payment_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * @property int $project_id
 * 
 * @property Project $project
 * @property User $user
 *
 * @package App\Models
 */
class Task extends Model
{
	use StringHelperTrait;

	protected $table = 'task';

	protected $casts = [
		'status' => 'int',
		'payment_status' => 'int',
		'user_id' => 'int',
		'project_id' => 'int'
	];

	protected $fillable = [
		'uuid',
		'nama_task',
		'description',
		'status',
		'payment_status',
		'user_id',
		'project_id',
		'created_by',
		'updated_by'
	];

	protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	const 	TASK_NOT_COMPLETED = 0,
			TASK_COMPLETED = 1;

	public static function getStatusMap(int $status = null)
    {
        $statuses = [
            self::TASK_NOT_COMPLETED => 'Not Completed',
            self::TASK_COMPLETED => 'Completed',
        ];

        return $statuses[$status] ?? $status ?? $statuses;
    }
}
