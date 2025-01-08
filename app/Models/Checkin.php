<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'day1',
        'ticket_id',
        'member_id',
        'coupen_id',
    ];

    // Relationships
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function coupen()
    {
        return $this->belongsTo(CoupenCode::class);
    }
}
