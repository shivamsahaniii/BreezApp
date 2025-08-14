<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HandlesRelationshipAttach
{
    public function attachRelationships($model, array $data)
    {
        $module = $this->guessModuleFromClass($model);
        $relations = config("CustomeFields.relationship_fields.$module", []);

        foreach ($relations as $relName => $rel) {

            if (($rel['type'] ?? null) !== 'belongsToMany') continue;

            // dd($rel,$relName,request()->all());
            // Use $data from form or request
            $value = $data[$rel['related_key']] ?? request($rel['related_key']) ?? [];
            try{
                   $model->{$relName}()->sync($value);
            }
            catch(\Exception $e)
            {

            }
            // Detach existing and attach new
         
        }
    }

    protected function guessModuleFromClass($model): string
    {
        // normalize class basename to lowercase plural
        return Str::plural(Str::lower(class_basename($model)));
    }
}
