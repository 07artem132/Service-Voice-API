<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 *
 * @package Api
 * @property int $id
 * @property int $priority
 * @property string $class_name
 * @property int $is_enabled
 * @property int $is_periodic
 * @property int $frequency
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Api\TaskStatus $Tasks
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Task active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Task whereClassName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Task whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Task whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Task whereIsPeriodic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Task wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Task whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'tasks';

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
