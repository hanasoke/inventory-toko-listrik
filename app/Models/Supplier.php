<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protect $fillable = [
        'code',
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
    ]
}
