<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Apotek extends Model
{
    use HasUuids;

    protected $table = 'apoteks';

    protected $fillable = [
        'nama',
        'deskripsi',
        'alamat',
        'phone_number',
        'foto_apotek',
        'status',
        'jam_buka',
        'jam_tutup',
    ];
}
