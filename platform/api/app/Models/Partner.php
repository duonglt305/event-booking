<?php


namespace DG\Dissertation\Api\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * DG\Dissertation\Api\Models\Partner
 *
 * @property int $id
 * @property string $name
 * @property string $logo
 * @property string|null $description
 * @property int $event_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Partner whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Partner whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Partner whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Partner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Partner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Partner extends Model
{
}
