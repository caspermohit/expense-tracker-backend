<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;
    protected $fillable = ['expense_name','expense_amount','user_id', 'description','date'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this-> belongsTo(category::class);
    }

}
