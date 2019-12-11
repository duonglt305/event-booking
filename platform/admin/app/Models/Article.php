<?php


namespace DG\Dissertation\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is class model for table articles
 * @package DG\Dissertation\Admin\Models
 *
 * @property string $title
 * @property string $slug
 * @property string $thumbnail
 * @property string $description
 * @property string $body
 * @property integer $status
 * @property integer $is_feature
 * @property integer $event_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Event $event
 */
class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'description',
        'status',
        'body',
        'is_feature',
        'event_id'
    ];

    /**
     * @return BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
