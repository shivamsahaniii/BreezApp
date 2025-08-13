<?php

namespace App\Models\Product;

use App\Models\Lead\Lead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Product extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'description', 'price'];

    protected static function booted()
{
    static::creating(function ($model) {
        if (empty($model->id)) {
            $model->id = (string) Str::uuid();
        }
    });
}

    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'lead_product', 'product_id', 'lead_id');
    }
}
