<?php


namespace DG\Dissertation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Partner
 * @package DG\Dissertation\Admin\Models
 *
 * @property string $name
 * @property string $logo
 * @property string $description
 * @property integer $event_id
 * @property Event $event
 */
class Partner extends Model
{
    protected $fillable = ['name', 'logo', 'description', 'event_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
