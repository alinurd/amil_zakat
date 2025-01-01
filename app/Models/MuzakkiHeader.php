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
        'created_by', // Tambahkan ini
    ];

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define a one-to-many relationship with MuzakkiDetal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(Muzakki::class, 'code', 'code');
    }
}
