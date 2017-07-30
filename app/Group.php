<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\Group
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\GroupTeamspeakInstances[] $TeamspeakInstances
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Group group($group)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Group whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Group whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\GroupTeamspeakInstances[] $Servers
 */
class Group extends Model
{
    protected $hidden = ['created_at', 'id', 'updated_at'];

    public function Servers()
    {
        return $this->hasMany('Api\GroupTeamspeakInstances', 'group_id');
    }

    public function scopeGroup($query, $group)
    {
        $query->where('slug', '=', $group);
    }
}
