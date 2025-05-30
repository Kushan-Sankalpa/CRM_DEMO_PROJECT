<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'title', 'description', 'amount', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}