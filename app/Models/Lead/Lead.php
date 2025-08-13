<?php

namespace App\Models\Lead;

use App\Models\Product\Product;
use App\Models\User;
use App\Traits\HandlesModelEvents;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Lead extends Model
{
    use SoftDeletes;
    use HandlesModelEvents;
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

    public function users()
    {
        return $this->belongsToMany(User::class, 'lead_user', 'lead_id', 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'lead_product', 'lead_id', 'product_id');
    }    
}
