<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\LeadFollowup;
use App\Models\LeadSource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lead::with(['source', 'assignedEmployee', 'branch']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('lead_number', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        $leads = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $sources = LeadSource::where('is_active', true)->get();
        $staffMembers = User::whereIn('role', ['super_admin', 'admin', 'staff'])->get();

        return view('admin.leads.index', compact('leads', 'sources', 'staffMembers'));
    }

    public function create(): View
    {
        $sources = LeadSource::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        $staffMembers = User::whereIn('role', ['super_admin', 'admin', 'staff'])->get();

        return view('admin.leads.create', compact('sources', 'branches', 'staffMembers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:25',
            'email' => 'nullable|email|max:150',
            'destination' => 'required|string|max:150',
            'departure_city' => 'nullable|string|max:100',
            'lead_source_id' => 'nullable|exists:lead_sources,id',
            'assigned_to' => 'nullable|exists:users,id',
            'branch_id' => 'nullable|exists:branches,id',
            'category' => 'required|string',
            'priority' => 'required|string|in:low,medium,high,urgent',
            'status' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'travel_start_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $leadNumber = 'LEAD-'.date('Y').'-'.rand(1000, 9999);

        $lead = Lead::create(array_merge($validated, [
            'lead_number' => $leadNumber,
            'created_by' => Auth::id(),
        ]));

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => 'status_change',
            'summary' => 'Lead Created',
            'details' => 'Lead manually registered by '.Auth::user()->name,
        ]);

        return redirect()->route('admin.leads.show', $lead->id)->with('success', "Lead #{$leadNumber} created successfully.");
    }

    public function show(int $id): View
    {
        $lead = Lead::with(['source', 'assignedEmployee', 'branch', 'followups.user', 'activities.user', 'quotations', 'customer'])
            ->findOrFail($id);

        $staffMembers = User::whereIn('role', ['super_admin', 'admin', 'staff'])->get();

        return view('admin.leads.show', compact('lead', 'staffMembers'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $lead = Lead::findOrFail($id);
        $oldStatus = $lead->status;

        $validated = $request->validate([
            'status' => 'required|string',
            'lost_reason' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $lead->update([
            'status' => $validated['status'],
            'lost_reason' => $validated['status'] === 'lost' ? $validated['lost_reason'] : null,
        ]);

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => 'status_change',
            'summary' => "Status changed from {$oldStatus} to {$validated['status']}",
            'details' => $validated['remarks'] ?? null,
        ]);

        return back()->with('success', "Lead status updated to {$validated['status']}.");
    }

    public function addFollowup(Request $request, int $id): RedirectResponse
    {
        $lead = Lead::findOrFail($id);

        $validated = $request->validate([
            'followup_date' => 'required|date',
            'remarks' => 'required|string',
        ]);

        LeadFollowup::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'followup_date' => $validated['followup_date'],
            'status' => 'pending',
            'remarks' => $validated['remarks'],
        ]);

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => 'call',
            'summary' => 'Follow-up Scheduled',
            'details' => 'Follow-up set for '.Carbon::parse($validated['followup_date'])->format('d M Y, h:i A').". Notes: {$validated['remarks']}",
        ]);

        return back()->with('success', 'Follow-up scheduled successfully.');
    }

    public function addActivity(Request $request, int $id): RedirectResponse
    {
        $lead = Lead::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|string|in:call,email,whatsapp,note',
            'summary' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'summary' => $validated['summary'],
            'details' => $validated['details'] ?? null,
        ]);

        return back()->with('success', 'Activity note logged.');
    }

    public function convertToCustomer(int $id): RedirectResponse
    {
        $lead = Lead::findOrFail($id);

        if ($lead->customer_id) {
            return back()->with('info', 'This lead is already mapped to Customer ID #'.$lead->customer_id);
        }

        $customer = Customer::firstOrCreate(
            ['phone' => $lead->phone],
            [
                'customer_code' => 'CUST-'.date('Y').'-'.rand(1000, 9999),
                'name' => $lead->name,
                'email' => $lead->email,
                'status' => 'active',
                'created_by' => Auth::id(),
            ]
        );

        $lead->update([
            'customer_id' => $customer->id,
            'status' => 'converted',
        ]);

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => 'status_change',
            'summary' => 'Converted to Customer Profile',
            'details' => "Converted to Customer #{$customer->customer_code}",
        ]);

        return redirect()->route('admin.customers.show', $customer->id)->with('success', 'Lead converted to Customer profile successfully.');
    }
}
