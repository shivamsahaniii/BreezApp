<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasDynamicRelationships
{
    public function __call($method, $parameters)
    {
        $module = class_basename($this); 
        $relations = config("CustomeFields.relationship_fields.$module", []);

        if (isset($relations[$method])) {
            $relation = $relations[$method];

            return match ($relation['type']) {
                'belongsToMany' => $this->belongsToMany(
                    $relation['model'],
                    $relation['pivot_table'],
                    $relation['foreign_key'],
                    $relation['related_key']
                ),
                'hasMany' => $this->hasMany(
                    $relation['model'],
                    $relation['foreign_key'] ?? Str::snake($module) . '_id'
                ),
                'belongsTo' => $this->belongsTo(
                    $relation['model'],
                    $relation['foreign_key'] ?? Str::snake($method) . '_id'
                ),
                default => parent::__call($method, $parameters),
            };
        }

        return parent::__call($method, $parameters);
    }
}
