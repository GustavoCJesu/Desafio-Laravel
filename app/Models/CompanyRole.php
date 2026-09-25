<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyRole extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status'];

    public function employee(): HasMany
    {
        return $this->hasMany(Employee::class, 'company_role_id');
    }
}
