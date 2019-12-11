<?php


namespace DG\Dissertation\Api\Models;

use DG\Dissertation\Api\Traits\MakeVerificationCode;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Webpatser\Uuid\Uuid;

/**
 * DG\Dissertation\Api\Models\Attendee
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $photo
 * @property string $registration_code
 * @property string|null $verify_code
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\DG\Dissertation\Api\Models\Registration[] $registrations
 * @property-read int|null $registrations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee query()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee whereRegistrationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Attendee whereVerifyCode($value)
 * @mixin \Eloquent
 */
class Attendee extends Authenticatable implements JWTSubject
{
    use Notifiable, MakeVerificationCode;

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
        'verify_code',
        'email_verified_at',
        'registration_code',
        'photo'
    ];

    protected $hidden = [
        'email_verified_at',
        'verify_code',
        'password',
        'created_at',
        'updated_at'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->registration_code = strtoupper(Uuid::generate(4));
        });
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function registrations()
    {
        return $this->hasMany('DG\Dissertation\Api\Models\Registration');
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
