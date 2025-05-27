<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryTest extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryTestFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    const CATEGORYTEST = [
        [
            'name' => 'Quiz',
            'slug' => 'Quiz'
        ],
        [
            'name' => 'Writting',
            'slug' => 'writting'
        ],
        [
            'name' => 'Conjugaison',
            'slug' => 'conjugaison'
        ],
        [
            'name' => 'Questionnaire',
            'slug' => 'questionnaire'
        ]
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ActivityType::class);
    }
}
