<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Column;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Card extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'position', 'column_id', 'assigned_user_id'];

    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}
