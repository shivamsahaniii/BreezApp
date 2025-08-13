<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\contact\StoreContactRequest;
use App\Http\Requests\contact\UpdateContactRequest;
use App\Jobs\MassUpdateRecords;
use App\Models\Contact\Contact;
use App\Traits\HandlesProfileImage;
use App\Repositories\Contact\ContactRepositoryInterface;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use HandlesProfileImage;
    protected string $modelClass = Contact::class;

    protected $contactRepo;

    public function __construct(ContactRepositoryInterface $contactRepo)
    {
        $this->contactRepo = $contactRepo;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->contactRepo->getForDataTable($request);
        }

        return view('activities.index', $this->contactRepo->getTableViewData());
    }

    public function create()
    {
        return view('activities.form', $this->contactRepo->getFormConfig('create'));
    }

    public function store(StoreContactRequest $request)
    {
        $validated = $request->validated();
        $validated['profile'] = $this->uploadProfileImage($request);

        $this->contactRepo->createContact($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    public function show($id)
    {
        $data = $this->contactRepo->getByIdWithRelations($id);
        $fields = config('CustomeFields.form_fields.contacts');

        return view('contacts.show', [
            'contact' => $data['contact'],
            'accounts' => $data['accounts'],
            'fields' => $fields,
        ]);
    }

    public function edit(Contact $contact)
    {
        return view('activities.form', $this->contactRepo->getFormConfig('edit', $contact));
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $validated = $request->validated();
        $validated['profile'] = $this->uploadProfileImage($request, $contact->profile);

        $this->contactRepo->updateContact($contact, $validated);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $this->contactRepo->deleteContact($contact);

        return redirect()->route('contacts.index')->with('success', 'Contact moved to trash.');
    }

    public function trash(Request $request)
    {
        if ($request->ajax()) {
            return $this->contactRepo->getForDataTable($request, true);
        }

        return view('contacts.trash', $this->contactRepo->getTableViewData(true));
    }

    public function restore($id)
    {
        $this->contactRepo->restoreContact($id);

        return redirect()->route('contacts.trash')->with('success', 'Contact restored.');
    }

    public function forceDelete($id)
    {
        $this->contactRepo->forceDeleteContact($id);
        return redirect()->route('contacts.trash')->with('success', 'Contact permanently deleted.');
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
