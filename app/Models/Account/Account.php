<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasDynamicRelationships;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Account extends Model
{
    use SoftDeletes, HasDynamicRelationships, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'industry',
        'email',
        'phone',
        'website',
        'address',
        'profile',
    ];

    public function getNameAttribute($val)
    {
        return ucfirst($val);
    }

    public function getIndustryAttribute($val)
    {
        return ucfirst($val);
    }

    public function getPhoneAttribute($val)
    {
        return "+91" . $val;
    }

    public function setEmailAttribute($val)
    {
        $this->attributes['email'] = lcfirst($val);
    }
}
