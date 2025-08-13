<?php

namespace App\Helpers;

class FormHelper
{
    /**
     * Build dynamic form configuration
     */
    public static function buildFormConfig(string $module, string $type, $model = null): array
    {
        return [
            'formFields' => config("CustomeFields.form_fields.$module"),
            'action' => $type === 'create'
                ? route("$module.store")
                : route("$module.update", $model),
            'method' => $type === 'create' ? 'POST' : 'PUT',
            'routeBase' => $module,
            'data' => $model,
        ];
    }
}
