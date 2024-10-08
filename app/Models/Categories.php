<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'category_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
