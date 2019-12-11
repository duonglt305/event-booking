<?php


namespace DG\Dissertation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Speaker
 * @package DG\Dissertation\Admin\Models
 *
 * @property string $firstname
 * @property string $lastname
 * @property string $photo
 * @property string $company
 * @property string $position
 * @property string $description
 * @property integer $event_id
 */
class Speaker extends Model
{
    protected $fillable = ['firstname', 'lastname', 'photo', 'company', 'position', 'description', 'event_id'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'speaker_id', 'id');
    }
}
