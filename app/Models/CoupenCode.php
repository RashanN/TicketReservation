<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoupenCode extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'ticket_id','image',];

    /**
     * Define the relationship with the Ticket model.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    
}
