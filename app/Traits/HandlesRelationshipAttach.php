<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait HandlesRelationshipAttach
{
    public function attachRelationships($model, array $data)
    {
        $module = Str::plural(Str::lower(class_basename($model)));
        $relations = config("CustomeFields.relationship_fields.$module", []);

        foreach ($relations as $relName => $rel) {
            if (($rel['type'] ?? null) !== 'belongsToMany') continue;

            $value = $data[$rel['related_key']] ?? request($rel['related_key']) ?? [];

            try {
                $model->{$relName}()->sync($value);
            } catch (\Exception $e) {
                Log::error("Failed to sync relationship: $relName", [
                    'model' => $module,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
