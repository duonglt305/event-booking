<?php


namespace DG\Dissertation\Admin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * This is class for table events
 * @package DG\Dissertation\Admin\Models
 *
 * @property int id
 * @property string $name
 * @property string $slug
 * @property string $date
 * @property string $address
 * @property string $thumbnail
 * @property string $description
 * @property integer $status
 * @property integer $organizer_id
 */
class Event extends Model
{
    protected $fillable = ['name', 'slug', 'date', 'address', 'thumbnail', 'description', 'organizer_id','status'];

    /**
     * @return string
     */
    public function getDateFormattedAttribute()
    {
        return Carbon::parse($this->date)->format('F j, Y H:i');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function registrations()
    {
        return $this->hasManyThrough(Registration::class, Ticket::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function rooms()
    {
        return $this->hasManyThrough(Room::class, Channel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessionTypes()
    {
        return $this->hasMany(SessionType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function sessions()
    {
        return $this->hasManyThrough(Session::class, SessionType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function speakers()
    {
        return $this->hasMany(Speaker::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partners()
    {
        return $this->hasMany(Partner::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function ratings()
    {
        return $this->hasMany(EventRating::class);
    }
}
