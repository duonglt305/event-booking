<?php


namespace DG\Dissertation\Api\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * DG\Dissertation\Api\Models\Registration
 *
 * @property string attended_session_ids
 * @property int $id
 * @property int $attendee_id
 * @property int $ticket_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\SessionRegistration[] $sessionRegistrations
 * @property-read int|null $session_registrations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\Session[] $sessions
 * @property-read int|null $sessions_count
 * @property-read \DG\Dissertation\Api\Models\Ticket $ticket
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Registration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Registration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Registration query()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Registration whereAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Registration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Registration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Registration whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Registration whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Registration whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Registration extends Model
{
    protected $fillable = ['attendee_id', 'ticket_id', 'attended_session_ids', 'status'];

    public function sessions()
    {
        return $this->belongsToMany('DG\Dissertation\Api\Models\Session', 'session_registration')
            ->using('DG\Dissertation\Api\Models\SessionRegistration')->withPivot(['cost']);
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
