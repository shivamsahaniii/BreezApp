<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\account\StoreAccountRequest;
use App\Http\Requests\account\UpdateAccountRequest;
use App\Jobs\MassUpdateRecords;
use App\Models\Account\Account;
use App\Traits\HandlesProfileImage;
use App\Repositories\Account\AccountRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    protected string $modelClass = Account::class;

    use HandlesProfileImage;

    protected $accountRepo;

    public function __construct(AccountRepositoryInterface $accountRepo)
    {
        $this->accountRepo = $accountRepo;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->accountRepo->getForDataTable($request);
        }
        return view('activities.index', $this->accountRepo->getTableViewData());
    }

    public function create()
    {

        return view('activities.form', $this->accountRepo->getFormConfig('create'));
    }

    public function store(StoreAccountRequest $request)
    {
        // dd($request);
        $validated = $request->validated();
        $validated['profile'] = $this->uploadProfileImage($request);

        $this->accountRepo->createAccount($validated);

        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }

    public function show($id)
    {
        $fields = config('CustomeFields.form_fields.accounts');
        $data = $this->accountRepo->getByIdWithRelations($id);

        return view('accounts.show', [
            'account' => $data['account'],
            'contacts' => $data['contacts'],
            'fields' => $fields,
        ]);
    }

    public function data()
    {
        return DataTables::eloquent(Account::with('user')->latest())
            ->toJson();
    }
    
    public function edit(Account $account)
    {
        return view('activities.form', $this->accountRepo->getFormConfig('edit', $account));
    }

    public function update(UpdateAccountRequest $request, Account $account)
    {
        $validated = $request->validated();
        $validated['profile'] = $this->uploadProfileImage($request, $account->profile);
        $this->accountRepo->updateAccount($account, $validated);

        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        $this->accountRepo->deleteAccount($account);

        return redirect()->route('accounts.index')->with('success', 'Account moved to trash.');
    }

    public function trash(Request $request)
    {
        if ($request->ajax()) {
            return $this->accountRepo->getForDataTable($request, true);
        }

        return view('accounts.trash', $this->accountRepo->getTableViewData(true));
    }

    public function restore($id)
    {
        $this->accountRepo->restoreAccount($id);

        return redirect()->route('accounts.trash')->with('success', 'Account restored successfully.');
    }

    public function forceDelete($id)
    {
        $this->accountRepo->forceDeleteAccount($id);

        return redirect()->route('accounts.trash')->with('success', 'Account permanently deleted.');
    }


    public function massUpdate(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'field' => 'required|string',
            'new_value' => 'required'
        ]);

        $modelClass = $this->modelClass; // Defined in controller property
        MassUpdateRecords::dispatch($modelClass, $validated['ids'], $validated['field'], $validated['new_value']);

        return back()->with('success', 'Mass update initiated.');
    }
}
