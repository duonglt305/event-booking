<?php


namespace DG\Dissertation\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @property string title
 * @property string slug
 * @property integer is_feature
 * @property string thumbnail
 * @property string description
 * @property string body
 * @property int status
 */
class Article extends JsonResource
{

    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => asset($this->thumbnail),
            'description' => $this->description,
            'body' => replace_img_url($this->body),
            'status' => $this->status,
            'is_feature' => $this->is_feature
        ];
    }
}
