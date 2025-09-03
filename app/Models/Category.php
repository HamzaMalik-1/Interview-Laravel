<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];
protected $hidden=['updated_at','created_at'];

    // Relationship: A category has many interviews
    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }

}
