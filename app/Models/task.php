<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;

    public function list()
    {
        return $this->belongsTo(Todolists::class);
    }
    protected $fillable = ['content','list_id'];
}
