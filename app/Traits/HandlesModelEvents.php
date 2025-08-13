<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HandlesModelEvents
{
    public static function bootHandlesModelEvents()
    {
        static::saving(function ($model) {
            $module = self::guessModuleFromClass($model);
            $relations = config("CustomeFields.relationship_fields.$module", []);

            foreach ($relations as $rel) {
                if ($rel['type'] !== 'belongsTo') continue;

                $value = request($rel['field']);
                if (!method_exists($model, $rel['relationship'])) continue;

                $value
                    ? $model->{$rel['relationship']}()->associate($value)
                    : $model->{$rel['relationship']}()->dissociate();
            }
        });
    }

    protected static function guessModuleFromClass($model): string
    {
        return Str::plural(Str::lower(class_basename($model)));
    }
}