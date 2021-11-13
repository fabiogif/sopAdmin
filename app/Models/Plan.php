<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'url', 'price', 'description'];

    public function details()
    {
        return $this->hasMany(DetailPlan::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function search($filtter = null)
    {
        $result = $this->where('name', 'LIKE', "%{$filtter}%")
            ->orWhere('price', 'LIKE', "%{$filtter}%")
            ->paginate(10);
        return $result;
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function profilesAvailable($filter = null)
    {
        $profiles = Profile::whereNotIn('profiles.id', function ($query) {
            $query->select('plan_profile.profile_id');
            $query->from('plan_profile');
            $query->whereRaw("plan_profile.plan_id={$this->id}");
        })->where(function ($queryFilter) use ($filter) {
            if ($filter) {
                $queryFilter->where('profiles.name', 'LIKE', "%{$filter}%");
            }
        })->paginate();

        return $profiles;
    }
}
