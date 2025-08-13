<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait HandlesRelationshipAttach
{
    public function attachRelationships($model, array $data)
    {
        $module = $this->guessModuleFromClass($model);
        $relations = config("CustomeFields.relationship_fields.$module", []);

        foreach ($relations as $rel) {
            if ($rel['type'] !== 'belongsToMany') continue;
            if (!method_exists($model, $rel['relationship'])) continue;
            $value = $data[$rel['field']] ?? request($rel['field']);

            // Reset and attach new
            $model->{$rel['relationship']}()->detach();

            if (!empty($value)) {
                $attachValue = is_array($value) ? $value : [$value];
                $model->{$rel['relationship']}()->attach($attachValue);
            }
        }
    }

    
    protected function guessModuleFromClass($model): string
    {
        return Str::plural(Str::lower(class_basename($model)));
    }
}
