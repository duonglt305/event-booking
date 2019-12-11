<?php


namespace DG\Dissertation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = ['title', 'description', 'start_time', 'end_time', 'room_id', 'session_type_id', 'speaker_id'];

    public function sessionType()
    {
        return $this->belongsTo(SessionType::class);
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }

    public function room()
    {
        return $this->belongsTo('DG\Dissertation\Admin\Models\Room');
    }

    public function registrations()
    {
        return $this->hasMany('DG\Dissertation\Admin\Models\SessionRegistration');
    }

    public function sessionRatings()
    {
        return $this->hasMany('DG\Dissertation\Admin\Models\SessionRating');
    }
}
