<?php


namespace DG\Dissertation\Api\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * DG\Dissertation\Api\Models\Channel
 *
 * @property int $id
 * @property string $name
 * @property int $event_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\Room[] $rooms
 * @property-read int|null $rooms_count
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Channel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Channel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Channel whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Channel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Channel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Channel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Channel extends Model
{
    public function rooms()
    {
        return $this->hasMany('DG\Dissertation\Api\Models\Room');
    }
}
