<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectorType extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}
