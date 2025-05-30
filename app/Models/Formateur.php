<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formateur extends Model
{
    /** @use HasFactory<\Database\Factories\FormateurFactory> */
    use HasFactory;


    const FORMATEURS = [
        [
            'name' => 'Mlle nantenaina',
            'slug' => 'mlle-nantenaina-02012',
            'profile' => 'Formatrice francophone',
        ],
        [
            'name' => 'Md Rina',
            'slug' => 'md-rina-4532132',
            'profile' => 'Formatrice francophone',
        ],
        [
            'name' => 'Md lurone',
            'slug' => 'md-lurone-154125',
            'profile' => 'Formatrice francophone',
        ]
    ];

    protected $fillable = [
        'name',
        'slug',
        'profile',
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
