<?php

namespace App\Models\Contact;

use App\Models\Account\Account;
use App\Models\User;
use App\Traits\HandlesModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Contact extends Model
{
    use SoftDeletes;
    use HandlesModelEvents;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'notes',
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

    public function users()
    {
        return $this->belongsToMany(User::class, 'contact_user', 'contact_id', 'user_id');
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'account_contact', 'contact_id', 'account_id');
    }
}
