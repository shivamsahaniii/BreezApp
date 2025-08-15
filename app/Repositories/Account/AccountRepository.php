<?php

namespace App\Repositories\Account;

use App\Helpers\FormHelper;
use App\Models\Account\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AccountRepository implements AccountRepositoryInterface
{

    public function getFormConfig(string $type, $account = null): array
    {
        $form = FormHelper::buildFormConfig('accounts', $type, $account);

        // Filter out fields you don't want on the create/edit form
        if (isset($form['formFields']) && is_array($form['formFields'])) {
            $form['formFields'] = array_filter($form['formFields'], function ($field) {
                return !in_array($field['name'], ['id', 'action', 'created_at', 'updated_at']);
            });
        }

        // Inject user list into form
        $form['users'] = User::pluck('name', 'id')->toArray();

        return $form;
    }

    public function getTableViewData(bool $trashed = false): array
    {
        return [
            'headers' => config('CustomeFields.form_fields.accounts'), // correct key here?
            'routeBase' => 'accounts',
            'isTrash' => $trashed,
        ];
    }

    public function getForDataTable(Request $request, bool $trashed = false)
    {
        $query = $trashed
            ? Account::onlyTrashed()->with('users')->select('accounts.*')
            : Account::with('users')->select('accounts.*');

        $accounts = $query->get();

        foreach ($accounts as $account) {
            $account->user_name = optional($account->users->first())->name ?? 'N/A';
        }

        return DataTables::of($accounts)->make(true);
    }

    public function createAccount(array $data): Account
    {
        $account = Account::create($data);
        return $account;
    }

    public function updateAccount(Account $account, array $data): Account
    {
        $account->fill($data)->save();
        return $account;
    }

    public function getByIdWithRelations($id)
    {
        $account = Account::with('contacts', 'users')->findOrFail($id);

        return [
            'account' => $account,
            'contacts' => $account->contacts,
        ];
    }

    public function deleteAccount(Account $account): void
    {
        $account->delete();
    }

    public function restoreAccount($id): void
    {
        Account::onlyTrashed()->findOrFail($id)->restore();
    }

    public function forceDeleteAccount($id): void
    {
        $account = Account::onlyTrashed()->findOrFail($id);

        if ($account->profile) {
            Storage::delete('public/' . $account->profile);
        }

        $account->forceDelete();
    }
}
