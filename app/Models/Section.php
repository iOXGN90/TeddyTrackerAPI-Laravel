<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $table = 'section';

    protected $guard = [];
    protected $fillable =
    [
        'task_id',
        'section_name',
        'pin_password'
    ];

    protected $hidden = [
        'pin_password',
        'remember_token',
    ];


    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function task() : HasMany{
        return $this->hasMany(Task::class);
    }
}
