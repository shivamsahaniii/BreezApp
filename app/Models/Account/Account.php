<?php

namespace App\Models\Account;

use App\Models\Contact\Contact;
use App\Models\User;
use App\Traits\HandlesModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;



class Account extends Model
{
    use SoftDeletes;
    use HandlesModelEvents;

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

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    function getNameAttribute($val)
    {
        return ucfirst($val);
    }

    function getIndustryAttribute($val)
    {
        return ucfirst($val);
    }

    function getPhoneAttribute($val)
    {
        return "+91" . $val;
    }

    function setEmailAttribute($val)
    {
        $this->attributes['email'] = lcfirst($val);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'account_user', 'account_id', 'user_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'account_contact', 'account_id','contact_id');
    }
}