<?php


namespace DG\Dissertation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['name', 'event_id'];


    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function sessions()
    {
        return $this->hasManyThrough(Session::class, Room::class);
    }
}
