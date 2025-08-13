<?php

namespace App\Repositories\Lead;

use Illuminate\Http\Request;
use App\Models\Lead\Lead;

interface LeadRepositoryInterface
{
    public function getFormConfig(string $type, $lead = null): array;
    public function getTableViewData(bool $trashed = false): array;
    public function getDataTable(Request $request, bool $isTrashed = false);
    public function createLead(array $data): Lead;
    public function updateLead(Lead $lead, array $data): Lead;
    public function getByIdWithRelations($id): Lead;
    public function delete(Lead $lead): void;
    public function restore($id): void;
    public function forceDelete($id): void;
}
