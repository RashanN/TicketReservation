<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'ticket_id',
        'price',
        'currency',
    ];

    /**
     * Get the member associated with the payment.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the ticket associated with the payment.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
