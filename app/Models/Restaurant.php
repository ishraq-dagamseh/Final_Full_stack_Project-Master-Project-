<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'name',
        'phone',
        'description',
        'location',
    ];
    

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menuItems()
    {
        return $this->hasMany(\App\Models\MenuItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


}
