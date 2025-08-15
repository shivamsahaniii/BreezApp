<?php

namespace App\Observers;

use App\Traits\HandlesRelationshipAttach;
use Illuminate\Support\Str;

class DynamicModelObserver
{
    use HandlesRelationshipAttach;

    /**
     * Handle belongsTo relationships before saving.
     */
    public function saving($model)
    {
        $module = Str::plural(Str::lower(class_basename($model)));
        $relations = config("CustomeFields.relationship_fields.$module", []);

        foreach ($relations as $method => $relation) {
            if (($relation['type'] ?? null) !== 'belongsTo') continue;
            if (!method_exists($model, $method)) continue;

            $value = request($method) ?? request($method . '_id');

            if ($value) {
                $model->{$method}()->associate($value);
            } else {
                $model->{$method}()->dissociate();
            }
        }
    }

    /**
     * Handle belongsToMany relationships after saving.
     */
    public function saved($model)
    {
        $this->attachRelationships($model, request()->all());
    }
}
