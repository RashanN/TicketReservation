<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'nic',
        'company_name',
        'designation',
        'slimID',
        'other',
    ];

    public function tickets()
    {
    return $this->hasMany(Ticket::class);
    }

}
