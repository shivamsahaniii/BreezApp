<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasDynamicRelationships
{
    public function __call($method, $parameters)
    {
        $module = Str::plural(Str::lower(class_basename($this)));
        $relations = config("CustomeFields.relationship_fields.$module", []);

        if (!isset($relations[$method])) {
            return parent::__call($method, $parameters);
        }

        $relation = $relations[$method];
        $related = $relation['model'];

        return match ($relation['type'] ?? null) {
            'hasMany' => $this->hasMany(
                $related,
                $relation['foreign_key'] ?? null,
                $relation['local_key'] ?? null
            ),
            'hasOne' => $this->hasOne(
                $related,
                $relation['foreign_key'] ?? null,
                $relation['local_key'] ?? null
            ),
            'belongsTo' => $this->belongsTo(
                $related,
                $relation['foreign_key'] ?? null,
                $relation['owner_key'] ?? null
            ),
            'belongsToMany' => $this->belongsToMany(
                $related,
                $relation['pivot_table'] ?? null,
                $relation['foreign_key'] ?? null,
                $relation['related_key'] ?? null
            ),
            default => parent::__call($method, $parameters),
        };
    }
}
