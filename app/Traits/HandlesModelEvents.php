<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait HandlesModelEvents
{
    public static function bootHandlesModelEvents()
    {
        static::saving(function ($model) {
            $module = Str::plural(Str::lower(class_basename($model)));
            $relations = config("CustomeFields.relationship_fields.$module", []);

            
            foreach ($relations as $method => $relation) {
                if (($relation['type'] ?? null) !== 'belongsTo') {
                    continue;
                }

                $value = request($method) ?? request($method . '_id');
                if (!method_exists($model, $method)) {
                    continue;
                }

                if ($value) {
                    $model->{$method}()->associate($value);
                } else {
                    $model->{$method}()->dissociate();
                }
            }
        });
    }
}
