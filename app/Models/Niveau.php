<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Niveau extends Model
{
    /** @use HasFactory<\Database\Factories\NiveauFactory> */
    use HasFactory;

    const NIVAUX = [
        [
            'title' => 'Niveau 1',
            'slug' => 'niveau-1',
        ],
        [
            'title' => 'Niveau 2',
            'slug' => 'niveau-2',
        ],
        [
            'title' => 'Niveau 3',
            'slug' => 'niveau-3',
        ]
    ];

    protected $fillable = [
        'title',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

}
