<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Board;
use App\Models\User;

class BoardHasUser extends Model
{
    protected $fillable = [
        'board_id',
        'user_id'
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'board_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_has_users', 'board_id', 'user_id');
    }
}
