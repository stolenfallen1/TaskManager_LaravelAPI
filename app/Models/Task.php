<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    // Define the fields that can be mass assigned
    protected $fillable = [
        'title',
        'is_done',
        'project_id',
    ];

    // Define which fields should be cast to what type
    protected $casts = [
        'is_done' => 'boolean',
    ];

    // Define a many to one relationship with User model
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // Define a many to one relationship with Project model
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Add a global scope to only show tasks created by the current user
    protected static function booted(): void
    {
        static::addGlobalScope('member', function (Builder $builder) {
            $builder->where('creator_id', Auth::id())
                ->orWhereIn('project_id', Auth::user()->memberships->pluck('id'));
        });
    }
}
