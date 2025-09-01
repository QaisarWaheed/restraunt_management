<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantPdf extends Model
{
    protected $table = 'tenants_pdfs';
    protected $fillable = ['name', 'path'];
}
