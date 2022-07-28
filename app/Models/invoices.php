<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use HasFactory;
    use SoftDeletes;
    // protected $fillable= ['invoice_number','invoice_date','due_date','product','section'];
    protected $guarded = [];

    //Export Exel
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    //Relationship
    public function section(){
        return $this->belongsTo(sections::class);
     }
}
