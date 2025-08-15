<?php

namespace App\Models\Lead;

use App\Traits\HasDynamicRelationships;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;
    use HasDynamicRelationships;
    use HasUuids;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'source',
        'status',
        'message',
        'profile',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
  
}
