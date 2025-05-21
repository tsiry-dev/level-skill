<?php

namespace App\Models;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    /** @use HasFactory<\Database\Factories\ActivitiesFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description'
    ];

    const ACTIVITIES = [
        [
            'title' => 'Quiz',
            'slug' => 'quiz',
            'description' => 'Quiz description',
            'created_at' => null,
            'updated_at' => null,
        ],
        [
            'title' => 'Writting',
            'slug' => 'writting',
            'description' => 'Writting description',
            'created_at' => null,
            'updated_at' => null,
        ],
        [
            'title' => 'Redaction',
            'slug' => 'redaction',
            'description' => 'redaction description',
            'created_at' => null,
            'updated_at' => null,
        ],
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function activityTypes()
    {
        return $this->hasMany(ActivityType::class, 'activity_id');
    }
}
