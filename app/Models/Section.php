<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $table = 'sections';

    protected $guarded = [];

    protected $primaryKey = 'section_id';

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function task() : HasMany{
        return $this->hasMany(Task::class);
    }
}
