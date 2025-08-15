<?php

namespace App\Repositories\Lead;

use App\Helpers\FormHelper;
use App\Models\Lead\Lead;
use App\Models\Product\Product;
use App\Models\User;
use App\Traits\HandlesRelationshipAttach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LeadRepository implements LeadRepositoryInterface
{
    use HandlesRelationshipAttach;

    public function getFormConfig(string $type, $lead = null): array
    {
        $form = FormHelper::buildFormConfig('leads', $type, $lead);

        if (isset($form['formFields']) && is_array($form['formFields'])) {
            $form['formFields'] = array_filter($form['formFields'], function ($field) {
                return !in_array($field['name'], ['id', 'action', 'created_at', 'updated_at']);
            });
        }

        $form['users'] = User::pluck('name', 'id')->toArray();
        $form['products'] = Product::pluck('name', 'id')->toArray();

        if ($lead) {
            $form['data'] = $lead;
            $form['selected_user'] = $lead->users()->pluck('id')->first();
        }

        return $form;
    }

    public function getTableViewData(bool $trashed = false): array
    {
        $headers = config('CustomeFields.form_fields.leads');
        $filteredHeaders = array_filter($headers, fn($field) => $field['name'] !== 'product_id');

        return [
            'headers' => array_values($filteredHeaders),
            'routeBase' => 'leads',
            'isTrash' => $trashed,
        ];
    }

    public function getDataTable(Request $request, bool $isTrashed = false)
    {
        $query = $isTrashed ? Lead::onlyTrashed()->select('leads.*') : Lead::select('leads.*');
        $leads = $query->get();

        foreach ($leads as $lead) {
            $lead->user_name = optional($lead->users()->first())->name ?? '—';
        }

        return DataTables::of($leads)->make(true);
    }

    public function createLead(array $data): Lead
    {
        $lead = Lead::create($data);
        return $lead;
    }

    public function updateLead(Lead $lead, array $data): Lead
    {
        $lead->fill($data)->save();
        return $lead;
    }

    public function getByIdWithRelations($id): Lead
    {
        return Lead::with('users', 'products')->findOrFail($id);
    }

    public function delete(Lead $lead): void
    {
        $lead->delete();
    }

    public function restore($id): void
    {
        Lead::onlyTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete($id): void
    {
        $lead = Lead::onlyTrashed()->findOrFail($id);

        if ($lead->profile) {
            Storage::delete('public/' . $lead->profile);
        }

        $lead->forceDelete();
    }
}
