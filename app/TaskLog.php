<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\TaskLog
 *
 * @property int $id
 * @property int $task_id
 * @property int $status
 * @property string $message
 * @property float|null $run_time
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskLog whereRunTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskLog whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskLog extends Model
{
    public function task()
    {
        return $this->belongsTo('Api\Task', 'id','task_id');
    }

}
