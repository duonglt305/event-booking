<?php


namespace DG\Dissertation\Admin\Models;


use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * This is class model for table organizers
 * @package DG\Dissertation\Admin\Models
 *
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $address
 * @property string $description
 * @property string $website
 *
 * @property Event $events
 */
class Organizer extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'slug', 'email', 'password', 'phone', 'address', 'description', 'website','organizer_id'];

    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * @return HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
