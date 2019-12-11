<?php


namespace DG\Dissertation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $fillable = ['firstname', 'lastname', 'username', 'email', 'password', 'verify_code', 'registration_code'];

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
