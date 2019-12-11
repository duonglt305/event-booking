<?php


namespace DG\Dissertation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class SessionRating extends Model
{
    protected $fillable = ['rate', 'attendee_id', 'session_id'];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function attendee()
    {
        return $this->hasOne(Attendee::class);
    }
}
