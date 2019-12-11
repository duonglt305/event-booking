<?php


namespace DG\Dissertation\Api\Models;


use DG\Dissertation\Admin\Models\SessionRating;
use Illuminate\Database\Eloquent\Model;

/**
 * DG\Dissertation\Api\Models\Session
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $start_time
 * @property string $end_time
 * @property int $room_id
 * @property int $session_type_id
 * @property int $speaker_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float $cost
 * @property-read \DG\Dissertation\Api\Models\SessionType $sessionType
 * @property-read \DG\Dissertation\Api\Models\Speaker $speaker
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session query()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session whereSessionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session whereSpeakerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Session whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Session extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sessionType()
    {
        return $this->belongsTo('DG\Dissertation\Api\Models\SessionType');

    }

    /**
     * @return float
     */
    public function getCostAttribute()
    {
        return $this->sessionType->cost;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function speaker()
    {
        return $this->belongsTo('DG\Dissertation\Api\Models\Speaker');
    }

    public function sessionRatings()
    {
        return $this->hasMany(SessionRating::class);
    }

    public function getRatingsAverage()
    {
        $ratings = $this->sessionRatings();
        $average = 0;
        foreach ($ratings as $rating) {
            $average += intval($rating->rate);
        }
        return round($average / $ratings->count(), 2);
    }
}
