<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\BasicInfo;
use App\Models\Education;
use App\Models\Organization;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Portofolio;
use App\Models\SocialMedia;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'slug',
    ];

    public function generateSlug($name)
    {
        $baseSlug = Str::slug($name, '-');
        $slug = $baseSlug;
        $count = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        return $slug;
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->slug = $user->generateSlug($user->name);
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function basic_info(): HasOne
    {
        return $this->hasOne(BasicInfo::class);
    }

    public function education(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function experience(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function organization(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    public function portofolio(): HasMany
    {
        return $this->hasMany(Portofolio::class);
    }

    public function skill(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function social_media(): HasMany
    {
        return $this->hasMany(SocialMedia::class);
    }
}
