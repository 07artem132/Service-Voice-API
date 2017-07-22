<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\TaskStatus
 *
 * @property int $id
 * @property int $task_id
 * @property int $in_progress
 * @property string $last_run
 * @property string $next_due
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskStatus actualTasks()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskStatus whereInProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskStatus whereLastRun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskStatus whereNextDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskStatus whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TaskStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskStatus extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'task_statuses';

    /**
     * Заготовка запроса для получения задач которые нужно выполнить.
     * @param $query
     * @return mixed
     */
    public function scopeActualTasks($query)
    {
        return $query->where('next_due', '>', date('Y-m-d H:i:s'));
    }
}
