<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occurrences extends Model
{
    protected $fillable = ['title', 'description', 'address', 'users_id', 'issuings_id', 'type_occurrences_id', 'latitude', 'longitude'];
    use HasFactory;

    public function search($filtter = null)
    {
        $result = $this->where('title', 'LIKE', "%{$filtter}%")
            ->paginate(10);
        return $result;
    }
}
