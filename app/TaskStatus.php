<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

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
