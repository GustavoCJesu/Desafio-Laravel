<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{

public function employee(): HasMany{
    return $this->hasMany(Employee::class, 'secot_id');
}

}
