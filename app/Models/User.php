<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'email',
        'password',
        'role',
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
     * Check if user is Dept PIC.
     */
    public function isDeptPic(): bool
    {
        return $this->role === 'dept_pic';
    }

    /**
     * Check if user is Bendahara.
     */
    public function isBendahara(): bool
    {
        return $this->role === 'bendahara';
    }

    /**
     * Check if user is Sekretaris.
     */
    public function isSekretaris(): bool
    {
        return $this->role === 'sekretaris';
    }

    /**
     * Check if user is Ketua.
     */
    public function isKetua(): bool
    {
        return $this->role === 'ketua';
    }

    /**
     * Check if user can approve as specific role.
     */
    public function canApproveAs(string $role): bool
    {
        return $this->role === $role;
    }
}
