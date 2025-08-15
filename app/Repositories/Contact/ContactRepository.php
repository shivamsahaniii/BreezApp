<?php

namespace App\Repositories\Contact;

use App\Helpers\FormHelper;
use App\Models\Contact\Contact;
use App\Models\Account\Account;
use App\Models\User;
use App\Traits\HandlesRelationshipAttach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ContactRepository implements ContactRepositoryInterface
{

    public function getFormConfig(string $type, $contact = null): array
    {
        $form = FormHelper::buildFormConfig('contacts', $type, $contact);

        // Filter out unwanted fields
        if (isset($form['formFields']) && is_array($form['formFields'])) {
            $form['formFields'] = array_filter($form['formFields'], function ($field) {
                return !in_array($field['name'], ['id', 'action', 'created_at', 'updated_at']);
            });
        }

        // Inject user and account options
        $form['users'] = User::pluck('name', 'id')->toArray();
        $form['accounts'] = Account::pluck('name', 'id')->toArray();

        return $form;
    }

    public function getTableViewData(bool $trashed = false): array
    {
        return [
            'headers' => config('CustomeFields.form_fields.contacts'),
            'routeBase' => 'contacts',
            'isTrash' => $trashed,
        ];
    }

    public function getForDataTable(Request $request, bool $trashed = false)
    {
        $query = $trashed
            ? Contact::onlyTrashed()->with(['accounts', 'users'])->select('contacts.*')
            : Contact::with(['accounts', 'users'])->select('contacts.*');

        $contacts = $query->get();

        foreach ($contacts as $contact) {
            $contact->user_name = $contact->users->pluck('name')->implode(', ') ?: 'N/A';
            $contact->account_name = $contact->accounts->pluck('name')->implode(', ') ?: 'N/A';
        }

        return DataTables::of($contacts)->make(true);
    }

    public function createContact(array $data): Contact
    {
        $contact = Contact::create($data);
        return $contact;
    }

    public function updateContact(Contact $contact, array $data): Contact
    {
        $contact->fill($data)->save();
        return $contact;
    }

    public function getByIdWithRelations($id)
    {
        $contact = Contact::with(['accounts', 'users'])->findOrFail($id);

        return [
            'contact' => $contact,
            'accounts' => $contact->accounts,
            'users' => $contact->users,
        ];
    }

    public function deleteContact(Contact $contact): void
    {
        $contact->delete();
    }

    public function restoreContact($id): void
    {
        Contact::onlyTrashed()->findOrFail($id)->restore();
    }

    public function forceDeleteContact($id): void
    {
        $contact = Contact::onlyTrashed()->findOrFail($id);

        if ($contact->profile) {
            Storage::delete('public/' . $contact->profile);
        }

        $contact->forceDelete();
    }
}
