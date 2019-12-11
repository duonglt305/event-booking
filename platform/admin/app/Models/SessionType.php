<?php


namespace DG\Dissertation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class SessionType
 * @package DG\Dissertation\Admin\Models
 * @property string $name
 * @property double $cost
 * @property Event $event
 */
class SessionType extends Model
{
    protected $fillable = ['name', 'cost'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'session_type_id', 'id');
    }
}
