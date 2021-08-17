<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    const STATUS_COMPLETE = 1;
    const STATUS_INCOMPLETE = 0;

    protected $fillable = ['body','is_complete','user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
