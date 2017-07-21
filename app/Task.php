<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package Api
 */
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
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_enabled', 1);
    }

}
