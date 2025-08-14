<?php

namespace App\Http\Controllers\Lead;

use App\Http\Controllers\Controller;
use App\Http\Requests\lead\StoreLeadRequest;
use App\Http\Requests\lead\UpdateLeadRequest;
use App\Jobs\MassUpdateRecords;
use App\Models\Lead\Lead;
use App\Traits\HandlesProfileImage;
use App\Repositories\Lead\LeadRepositoryInterface;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    use HandlesProfileImage;
    protected string $modelClass = Lead::class;
    protected $leadRepo;

    public function __construct(LeadRepositoryInterface $leadRepo)
    {
        $this->leadRepo = $leadRepo;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->leadRepo->getDataTable($request);
        }
        return view('activities.index', $this->leadRepo->getTableViewData());
    }

    public function create()
    {
        return view('activities.form', $this->leadRepo->getFormConfig('create'));
    }

    public function store(StoreLeadRequest $request)
    {
        $validated = $request->validated();
        $validated['profile'] = $this->uploadProfileImage($request);
        $this->leadRepo->createLead($validated);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    public function show($id)
    {
        $lead = $this->leadRepo->getByIdWithRelations($id);
        $fields = config('CustomeFields.form_fields.leads');

        return view('leads.show', compact('lead', 'fields'));
    }

    public function edit(Lead $lead)
    {
        return view('activities.form', $this->leadRepo->getFormConfig('edit', $lead));
    }

    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $validated = $request->validated();
        $validated['profile'] = $this->uploadProfileImage($request, $lead->profile);
        $this->leadRepo->updateLead($lead, $validated);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $this->leadRepo->delete($lead);
        return redirect()->route('leads.index')->with('success', 'Lead moved to trash.');
    }

    public function trash(Request $request)
    {
        if ($request->ajax()) {
            return $this->leadRepo->getDataTable($request, true);
        }

        return view('leads.trash', $this->leadRepo->getTableViewData(true));
    }

    public function restore($id)
    {
        $this->leadRepo->restore($id);
        return redirect()->route('leads.trash')->with('success', 'Lead restored successfully.');
    }

    public function forceDelete($id)
    {
        $this->leadRepo->forceDelete($id);
        return redirect()->route('leads.trash')->with('success', 'Lead permanently deleted.');
    }

    public function massUpdate(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'field' => 'required|string',
            'new_value' => 'required'
        ]);

        MassUpdateRecords::dispatch($this->modelClass, $validated['ids'], $validated['field'], $validated['new_value']);

        return back()->with('success', 'Mass update initiated.');
    }
}
