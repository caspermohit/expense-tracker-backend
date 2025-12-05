<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;
    protected $fillable = ['expense_type','expense_name','expense_amount','user_id', 'description','expense_category'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function expense_type(){
        return $this-> belongsTo(ExpenseType::class);
    }
   

}
