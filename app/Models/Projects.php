<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    //

    protected $table = 'projects';

    protected $fillable = [
        'user_id',
        'project_title',
        'description',
        'lot_size',
        'floors',
        'finish_type',
        'image'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
