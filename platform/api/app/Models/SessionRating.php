<?php


namespace DG\Dissertation\Admin\Api;


use DG\Dissertation\Api\Models\Attendee;
use DG\Dissertation\Api\Models\Session;
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
