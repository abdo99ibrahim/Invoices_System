<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices extends Model
{
    use HasFactory;
    // protected $fillable= ['invoice_number','invoice_date','due_date','product','section'];
    protected $guarded = [];

    public function section(){
        return $this->belongsTo(sections::class);
     }
}
