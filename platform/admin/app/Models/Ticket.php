<?php


namespace DG\Dissertation\Admin\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property double cost
 * @property object special_validity
 * @property string describe
 * @property string description
 * @property int event_id
 */
class Ticket extends Model
{
    protected $fillable = ['name', 'cost', 'description', 'special_validity', 'event_id'];


    public function getSpecialValidityAttribute($value)
    {
        $specialValidity = json_decode($value);
        if (optional($specialValidity)->type === 'date' || optional($specialValidity)->type == 'both') {
            $specialValidity->formatted = Carbon::parse($specialValidity->date)->format('d/m/Y H:i');
        }
        return $specialValidity;
    }

    public function getSpecialValidityFormattedAttribute()
    {
        $validity = $this->special_validity;
        switch (optional($validity)->type) {
            case 'amount':
            {
                $available = $validity->amount - $this->registrations->count();
                return "{$available} tickets available";
            }
            case 'date':
            {
                return 'Available until ' . Carbon::parse($validity->date)->format('F j, Y H:i');
            }
            case 'both':
            {
                $available = $validity->amount - $this->registrations->count();
                return "{$available} tickets availabel until " . Carbon::parse($validity->date)->format('F j, Y H:i');
            }
            default:
                return '&nbsp';
        }
    }

    public function getCostFormattedAttribute()
    {
        return $this->cost ? number_format($this->cost, 1) : 'Free';
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

}
