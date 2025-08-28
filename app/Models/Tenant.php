<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
    
    protected $connection = 'mysql';
    protected $guarded = [];

    // protected $fillable = [
    //     'id',
    //     'name',
    //     'business_name',
    //     'subdomain',
    //     'owner_name',
    //     'owner_email',
    //     'owner_phone',
    //     'address',
    //     'postal_code',
    //     'country',
    //     'state',
    //     'city',
    //     'place_id',
    //     'latitude',
    //     'longitude',
    //     'trial_started_at',
    //     'trial_ends_at',
    //     'status',
    //     'database_name'
    // ];

    protected $casts = [
        'trial_started_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float'
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'business_name',
            'subdomain',
            'owner_name',
            'owner_email',
            'owner_phone',
            'address',
            'postal_code',
            'country',
            'state',
            'city',
            'place_id',
            'latitude',
            'longitude',
            'trial_started_at',
            'trial_ends_at',
            'status',
            'database_name'
        ];
    }
    public function getDatabaseName(): string
    {
        return $this->database_name;
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('subdomain', 'like', "%{$search}%")
                ->orWhere('owner_name', 'like', "%{$search}%")
                ->orWhere('owner_email', 'like', "%{$search}%");
        });
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
    
    public function getDomain(): string
    {
        return $this->domains()->first()?->domain ?? 'No Domain';
    }
} 