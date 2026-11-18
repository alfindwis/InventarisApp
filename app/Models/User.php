<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: User sebagai peminjam barang
    public function borrowRequests()
    {
        return $this->hasMany(BorrowRequest::class, 'borrower_id');
    }

    // Relasi: User (Petugas/Admin) yang menyetujui peminjaman
    public function approvedRequests()
    {
        return $this->hasMany(BorrowRequest::class, 'approved_by');
    }

    // Relasi: User (Petugas) yang menyerahkan barang
    public function handedOverRequests()
    {
        return $this->hasMany(BorrowRequest::class, 'handed_over_by');
    }

    // Relasi: Pengecekan kondisi barang yang dilakukan oleh petugas
    public function itemConditions()
    {
        return $this->hasMany(ItemCondition::class, 'checked_by');
    }
}