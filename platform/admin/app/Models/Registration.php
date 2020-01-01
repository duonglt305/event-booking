<?php


namespace DG\Dissertation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = ['attendee_id', 'ticket_id', 'verify_history'];

    public function sessions()
    {
        return $this->belongsToMany('DG\Dissertation\Api\Models\Session', 'session_registration')
            ->using('DG\Dissertation\Api\Models\SessionRegistration');
    }

    public function ticket()
    {
        return $this->belongsTo('DG\Dissertation\Api\Models\Ticket');
    }

    public function event()
    {
        return $this->hasOneThrough(
            'DG\Dissertation\Api\Models\Event',
            'DG\Dissertation\Api\Models\Ticket',
            'id',
            'id',
            'ticket_id',
            'event_id');
    }

    public function paid()
    {
        return $this->status === 'PAID';
    }

    public function sessionRegistrations()
    {
        return $this->hasMany('DG\Dissertation\Api\Models\SessionRegistration');
    }

    public function attendee()
    {
        return $this->belongsTo('DG\Dissertation\Api\Models\Attendee');
    }
}
