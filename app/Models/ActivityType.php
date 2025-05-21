<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'activity_id'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function slug(string $value)
    {
        // $baseSlug = \Illuminate\Support\Str::slug($value);
        // $slug = $baseSlug;
        // $i = 1;

        // while (ActivityType::where('slug', $slug)->exists()) {
        //     $slug = $baseSlug . '-' . $i;
        //     $i++;
        // }

        return \Illuminate\Support\Str::slug($value) . '-' .mt_rand(785, 15685) . time();
    }

    public function activity()
    {
        return $this->belongsTo(ActivityType::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'activity_type_id');
    }
}
