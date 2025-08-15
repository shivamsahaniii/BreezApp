<?php

namespace App\Models\Product;

use App\Models\Lead\Lead;
use App\Traits\HasDynamicRelationships;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasUlids, HasDynamicRelationships;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'description', 'price'];
}
