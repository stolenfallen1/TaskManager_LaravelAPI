<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use HasFactory;

    // Define the fields that can be mass assigned
    protected $fillable = [
        'title',
    ];

    // Define one to many relationship with Task model
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // Define many to one relationship with User model
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // Define many to many relationship with Member model
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Member::class);
    }

    // Add global scope to only show projects created by the authenticated user
    protected static function booted(): void
    {
        static::addGlobalScope('member', function (Builder $builder) {
            $builder->whereRelation('members', 'user_id', Auth::id());
        });
    }
}
