<?php


namespace DG\Dissertation\Api\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * DG\Dissertation\Api\Models\Article
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $thumbnail
 * @property string|null $description
 * @property string|null $body
 * @property int $status
 * @property int $event_id
 * @property int $is_feature
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DG\Dissertation\Api\Models\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
}
