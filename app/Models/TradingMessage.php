<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingMessage extends Model
{
    use HasFactory;
    
    public function user(){
        return $this->BelongsTo(User::class);
    }
}
