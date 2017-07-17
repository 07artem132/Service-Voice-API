<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    /**
     * Заготовка запроса для получения активных teamspeak 3 серверов.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_enabled', 1);
    }

    /**
     * Заготовка запроса для получения teamspeak 3 серверов.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTeamSpeak($query)
    {
        return $query->where('type', '=', 'teamspeak');
    }
}
