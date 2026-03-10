<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = [
        'name',
        'city',
        'location',
        'connector_type_id',
        'power',
        'is_available',
    ];

    public function connectorType()
    {
        return $this->belongsTo(ConnectorType::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
