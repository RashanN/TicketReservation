<?php

namespace App\Models;

use App\Models\Member;
use App\Models\CoupenCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'Numberof_ticket',
        'AgentID',
        'TotalPrice',
        'DiscountPrice',
        'Date',
        'PaymentStatus',
        'IssuedStatus',
        'IncentivePrice',
        'PaymentType',
        'other',
    ];

    /**
     * Relationship: A ticket belongs to a member.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    
    public function coupenCodes(){
    return $this->hasMany(CoupenCode::class);
    }

}
