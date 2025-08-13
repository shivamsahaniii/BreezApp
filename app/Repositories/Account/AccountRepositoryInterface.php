<?php

namespace App\Repositories\Account;
use Illuminate\Http\Request;
use App\Models\Account\Account;

interface AccountRepositoryInterface
    {
    public function getFormConfig(string $type, $account = null): array;
    public function getTableViewData(bool $trashed = false): array;
    public function getForDataTable(Request $request, bool $trashed = false);
    public function createAccount(array $data): Account;
    public function updateAccount(Account $account, array $data): Account;
    public function getByIdWithRelations($id);
    public function deleteAccount(Account $account): void;
    public function restoreAccount($id): void;
    public function forceDeleteAccount($id): void;

}
