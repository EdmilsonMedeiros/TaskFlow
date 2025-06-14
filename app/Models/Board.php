<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Column;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Board extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];

    /**
     * Get the user that owns the board.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_has_users', 'board_id', 'user_id');
    }

    /**
     * Get the columns for the board.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function columns(): HasMany
    {
        return $this->hasMany(Column::class);
    }

    protected static function booted(): void
    {
        static::created(function (Board $board) {
            $columns = [
                ['name' => 'BACKLOG', 'position' => 1, 'color' => '#CCCCCC'],
                ['name' => 'EM PROGRESSO', 'position' => 2, 'color' => '#00008B'], // Azul escuro
                ['name' => 'CONCLUÍDO', 'position' => 3, 'color' => '#008000'], // Verde
            ];

            foreach ($columns as $column) {
                $board->columns()->create($column);
            }

            $board->users()->attach(auth()->user()->id);
        });
    }
}
