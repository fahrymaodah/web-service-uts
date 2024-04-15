<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class MahasiswaModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table        = 'mahasiswa';
    protected $primaryKey   = 'mahasiswa_id';

    protected $fillable     = ['mahasiswa_id', 'mahasiswa_nim', 'mahasiswa_nama'];

    protected $hidden       = ['created_at', 'updated_at', 'deleted_at'];

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
