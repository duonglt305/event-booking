<?php


namespace DG\Dissertation\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'message', 'status','event_id'];
}
