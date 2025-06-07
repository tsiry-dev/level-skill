<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'password',
        'formateur_id',
        'niveau_id',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function formateur(): BelongsTo
    {
        return $this->belongsTo(Formateur::class,'formateur_id');
    }

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class, 'niveau_id');
    }

    public function scopeFilter(Builder | QueryBuilder $query)
    {

          $query->where('role', '=', 'user');

          $query->when(request('search') ?? null, function($query, $search) {
              $query->where(function($q) use ($search) {
                  $q->whereAny(['name', 'email'], 'LIKE', '%' . $search .'%');
              });
          });

          $query->when(request('status') ?? false, function($query, $status) {
                if ($status === 'terminer') {
                    $query->whereHas('submissions'); // A au moins une soumission
                } elseif ($status === 'non-terminer') {
                    $query->whereDoesntHave('submissions'); // Aucune soumission
                }
          });

          $query->when(request('byFormateur') ?? null, function($query, $byFormateur) {
              $query->whereHas('formateur', function ($q) use ($byFormateur) {
                   $q->where('slug', $byFormateur);
              });
          });

          $query->when(request('byNiveau') ?? null, function($query, $byNiveau) {
              $query->whereHas('niveau', function ($q) use ($byNiveau) {
                   $q->where('slug', $byNiveau);
              });
          });

          return $query;
    }
}
