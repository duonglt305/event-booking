<?php


namespace DG\Dissertation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'capacity', 'channel_id'];


    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
