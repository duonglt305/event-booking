<?php


namespace DG\Dissertation\Admin\Api;


use Illuminate\Database\Eloquent\Model;

class EventRating extends Model
{
    protected $fillable = ['rate', 'attendee_id', 'event_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function attendee()
    {
        return $this->hasOne(Attendee::class);
    }
}
