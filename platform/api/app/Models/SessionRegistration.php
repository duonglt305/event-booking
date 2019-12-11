<?php


namespace DG\Dissertation\Api\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * DG\Dissertation\Api\Models\SessionRegistration
 *
 * @property string registration_code
 * @property string verified_at
 * @property int $registration_id
 * @property int $session_id
 * @property float $cost
 * @property string|null $attended_at
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionRegistration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionRegistration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionRegistration query()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionRegistration whereAttendedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionRegistration whereRegistrationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionRegistration whereSessionId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\SessionRegistration whereCost($value)
 */
class SessionRegistration extends Pivot
{
    protected $table = 'session_registration';
    protected $fillable = ['registration_id', 'session_id', 'cost'];
}
