<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'task_id';

    protected $guarded = [];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function section() : HasOne {
        return $this->hasOne(Section::class);
    }
}
