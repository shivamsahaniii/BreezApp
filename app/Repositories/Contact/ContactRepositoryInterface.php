<?php

namespace App\Repositories\Contact;

use Illuminate\Http\Request;
use App\Models\Contact\Contact;

interface ContactRepositoryInterface
{
    public function getFormConfig(string $type, $contact = null): array;
    public function getTableViewData(bool $trashed = false): array;
    public function getForDataTable(Request $request, bool $trashed = false);
    public function createContact(array $data): Contact;
    public function updateContact(Contact $contact, array $data): Contact;
    public function getByIdWithRelations($id);
    public function deleteContact(Contact $contact): void;
    public function restoreContact($id): void;
    public function forceDeleteContact($id): void;
}
