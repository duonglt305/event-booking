<?php


namespace DG\Dissertation\Api\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * DG\Dissertation\Api\Models\SessionType
 *
 * @property int $id
 * @property string $name
 * @property float|null $cost
 * @property int $event_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionType whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionType whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SessionType extends Model
{

}
