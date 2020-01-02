<?php


namespace DG\Dissertation\Api\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * DG\Dissertation\Api\Models\Event
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $date
 * @property string|null $address
 * @property string|null $thumbnail
 * @property string|null $description
 * @property integer $status
 * @property int $organizer_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\Session[] $sessions
 * @property-read int|null $sessions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\Channel[] $channels
 * @property-read int|null $channels_count
 * @property-read \DG\Dissertation\Api\Models\Organizer $organizer
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\Partner[] $partners
 * @property-read int|null $partners_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\Registration[] $registrations
 * @property-read int|null $registrations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\Room[] $rooms
 * @property-read int|null $rooms_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\Ticket[] $tickets
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event whereOrganizerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Event whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    protected $fillable = ['name', 'slug', 'date', 'address', 'thumbnail', 'description', 'organizer_id', 'status'];

    public function organizer()
    {
        return $this->belongsTo('DG\Dissertation\Api\Models\Organizer');
    }

    public function channels()
    {
        return $this->hasMany('DG\Dissertation\Api\Models\Channel');
    }

    public function rooms()
    {
        return $this->hasManyThrough('DG\Dissertation\Api\Models\Room', 'DG\Dissertation\Api\Models\Channel');
    }


    public function tickets()
    {
        return $this->hasMany('DG\Dissertation\Api\Models\Ticket');
    }


    public function registrations()
    {
        return $this->hasManyThrough('DG\Dissertation\Api\Models\Registration', 'DG\Dissertation\Api\Models\Ticket');
    }

    public function articles()
    {
        return $this->hasMany('DG\Dissertation\Api\Models\Article');
    }

    public function getLatestArticlesAttribute()
    {
        return $this->articles()
            ->orderByDesc('updated_at')
            ->limit(3)
            ->get();
    }


    public function partners()
    {
        return $this->hasMany('DG\Dissertation\Api\Models\Partner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function sessions()
    {
        return $this->hasManyThrough('DG\Dissertation\Api\Models\Session', 'DG\Dissertation\Api\Models\SessionType');
    }


    public function speakers()
    {
        return $this->hasMany('DG\Dissertation\Api\Models\Speaker');
    }
}

