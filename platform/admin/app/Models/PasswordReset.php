<?php


namespace DG\Dissertation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = ['email', 'token'];

    public const UPDATED_AT = null;

    protected $primaryKey = null;

    public $incrementing = false;
}
