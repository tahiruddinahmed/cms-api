<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * User has many posts
     */
    public function posts(): HasMany {
        return $this->hasMany(Post::class);
    }

    /**
     * User has may categories
     */
    public function categoreis(): HasMany {
        return $this->hasMany(Category::class);
    }

    /**
     * User has many comments
     */
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }

    /**
     * Admin
     */
    public function admin() {
        return $this->hasMany(Admin::class);
    }

    public function isAdmin() {
        $user = Auth::user();

        // check is user exist in the admin table 
        $isAdmin = Admin::where('user_id', $user->id)->first();
        
        if(!$isAdmin) {
            return false;
        }
    
        return true;
    }

}
