<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuzakkiHeader extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'muzakki_header';

    protected $fillable = [
        'user_id',
        'code',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}  
