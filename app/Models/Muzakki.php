<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muzakki extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'muzakki';

    protected $fillable = [
        'code',
        'user_id',
        'created_at',
        'jumlah_bayar',
        'kategori_id',
        'created_by',
        'type',
        'jumlah_jiwa',
        'satuan',
    ];
    public function muzakkiHeader()
    {
        return $this->belongsTo(MuzakkiHeader::class, 'code');
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
 
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}  
