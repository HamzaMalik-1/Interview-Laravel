<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    //
    protected $fillable = [
        "question",
        'answer',
        'difficultyLevel',
        'categoryId'
        ];

        protected $hidden = ['created_at','updated_at'];

        public function category()
        {
            return $this->belongsTo(category::class);
        }
}
