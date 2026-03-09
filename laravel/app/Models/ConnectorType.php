<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectorType extends Model
{
    protected $fillable = ['name'];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}
