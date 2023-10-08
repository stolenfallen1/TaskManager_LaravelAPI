<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
