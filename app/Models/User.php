<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'phone',
        'birth_date',
        'cpf',
        'balance',
        'photo',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'cpf'
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
            'is_admin' => 'boolean',
            'birth_date' => 'date',
            'balance' => 'decimal:2',
        ];
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    public function salesAsSeller()
    {
        return $this->hasMany(Sale::class, 'seller_id');
    }

    public function salesAsBuyer()
    {
        return $this->hasMany(Sale::class, 'buyer_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function cartTotal(): float
    {
        return $this->cartItems()
            ->with('product')
            ->get()
            ->sum(fn($item) => $item->quantity * $item->product->price);
    }

    public function cartItemsCount(): int
    {
        return $this->cartItems()->count();
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function repliedContacts()
    {
        return $this->hasMany(Contact::class, 'replied_by');
    }

    public function scopeWithDetails(Builder $query)
    {
        return $query->with('defaultAddress');
    }

    public function scopeAdmins(Builder $query, string $id)
    {
        return $query->where('is_admin', true);
    }

    public function scopeNotAdmins(Builder $query)
    {
        return $query->where('is_admin', false);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%");
        });
    }
}
