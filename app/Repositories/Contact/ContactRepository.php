<?php

namespace App\Repositories\Contact;

use App\Helpers\FormHelper;
use App\Jobs\SendWelcomeEmail;
use App\Models\Contact\Contact;
use App\Models\Account\Account;
use App\Models\User;
use App\Traits\HandlesRelationshipAttach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ContactRepository implements ContactRepositoryInterface
{
    use HandlesRelationshipAttach;

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
            'headers' => config('CustomeFields.form_fields.contacts'),  // Must NOT be null!
            'routeBase' => 'contacts',
            'isTrash' => $trashed,
        ];
    }


    public function getForDataTable(Request $request, bool $trashed = false)
    {
        $query = $trashed
            ? Contact::onlyTrashed()->with(['accounts', 'users'])->select('contacts.*')
            : Contact::with(['accounts', 'users'])->select('contacts.*');

        return DataTables::of($query)
            ->addColumn('user_name', function ($contact) {
                return $contact->users->pluck('name')->implode(', ') ?: 'N/A';
            })
            ->addColumn('account_name', function ($contact) {
                return $contact->accounts->pluck('name')->implode(', ') ?: 'N/A';
            })
            ->rawColumns(['user_name', 'account_name']) // optional if HTML involved
            ->make(true);
    }


    public function createContact(array $data): Contact
    {
        $contact = Contact::create($data);
        SendWelcomeEmail::dispatch($contact); // 🔥 Queued
        $this->attachRelationships($contact, $data); // <-- Attach manually

        return $contact;
    }

    public function updateContact(Contact $contact, array $data): Contact
    {
        $contact->fill($data)->save();
        $this->attachRelationships($contact, $data); // Re-attach for updates
        return $contact;
    }

    public function getByIdWithRelations($id)
    {
        $contact = Contact::findOrFail($id);

        // Fetch related account IDs from pivot
        $accountIds = DB::table('account_contact')
            ->where('contact_id', $id)
            ->pluck('account_id');

        // Fetch the Account models manually
        $accounts = Account::whereIn('id', $accountIds)->get();

        return compact('contact', 'accounts');
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
