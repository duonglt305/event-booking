<?php


namespace DG\Dissertation\Api\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * DG\Dissertation\Api\Models\Ticket
 *
 * @property int $id
 * @property string $name
 * @property float $cost
 * @property int $event_id
 * @property mixed special_validity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \DG\Dissertation\Api\Models\Event $event
 * @property-read mixed $available
 * @property-read mixed $description
 * @property-read mixed $describe
 * @property-read bool $feature
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\Registration[] $registrations
 * @property-read int|null $registrations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Ticket whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Ticket whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Ticket whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Ticket whereSpecialValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Ticket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ticket extends Model
{
    public function getSpecialValidityAttribute($value)
    {
        return json_decode($value);
    }

    public function registrations()
    {
        return $this->hasMany('DG\Dissertation\Api\Models\Registration');
    }

    public function event()
    {
        return $this->belongsTo('DG\Dissertation\Api\Models\Event');
    }

    public function getAvailableAttribute()
    {
        if (is_null($this->special_validity)) return true;
        switch ($this->special_validity->type) {
            case 'amount':
                return (($this->special_validity->amount - $this->registrations()->where('status', '=', 'PAID')->count()) > 0);
            case 'date':
                return Carbon::now()->lessThanOrEqualTo($this->special_validity->date);
            case 'both':
                return (($this->special_validity->amount - $this->registrations()->where('status', '=', 'PAID')->count()) > 0)
                    && Carbon::now()->lessThanOrEqualTo($this->special_validity->date);
            default:
                return false;
        }
    }

    public function getFeatureAttribute()
    {
        $event = $this->event()->with(['tickets' => function ($query) {
            return $query->with('registrations');
        }])->first();
        return $event->tickets->sortBy(function ($ticket, $key) {
                return count($ticket['registrations']);
            })->values()->toBase()->first()->id === $this->id;
    }

    public function getDescribeAttribute()
    {
        if (is_null($this->special_validity)) return null;
        switch ($this->special_validity->type) {
            case 'date':
                return 'Available until ' . Carbon::parse($this->special_validity->date)->format('F j, Y');
            case 'amount':
                return ($this->special_validity->amount - $this->registrations->count()) . ' tickets available';
            case 'both':
                return ($this->special_validity->amount - $this->registrations->count()) . ' tickets available until ' . Carbon::parse($this->special_validity->date)->format('F j, Y');
            default:
                return null;
        }
    }
}
