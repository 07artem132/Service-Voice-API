<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use Api\TaskStatus;
class Task extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'tasks';

    public function Tasks()
    {
        return $this->hasOne('Api\TaskStatus', 'task_id', 'id');
    }

    /**
     * Заготовка запроса для получения активных задач.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_enabled', 1);
    }

}
