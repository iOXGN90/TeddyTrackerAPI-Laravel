<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    protected $table = 'task';

    protected $guard = [];
    protected $fillable = [
        'admin_id',
        'subject',
        'task_title',
        'task_instruction',
        'type_of_task',
        'task_deadline'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function section() : HasOne {
        return $this->hasOne(Section::class);
    }
}
