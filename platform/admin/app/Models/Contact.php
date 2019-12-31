<?php


namespace DG\Dissertation\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'message', 'status', 'event_id'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
