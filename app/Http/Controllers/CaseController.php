<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaseRequest;
use App\Http\Requests\UpdateCaseRequest;
use App\Models\MedicalCase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CaseController extends Controller
{
    /**
     * Display a listing of medical cases with search, filter, and pagination.
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', MedicalCase::class);

        $query = MedicalCase::with('creator:id,name,email');

        // Search by general keyword or specific fields
        if ($request->filled('search')) {
            $query->search($request->query('search'));
        }

        if ($request->filled('case_number')) {
            $query->where('case_number', 'like', '%' . trim($request->query('case_number')) . '%');
        }

        if ($request->filled('surgeon_name')) {
            $query->where('surgeon_name', 'like', '%' . trim($request->query('surgeon_name')) . '%');
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->filterStatus($request->query('status'));
        }

        // Filter by Priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->query('priority'));
        }

        // 10 cases per page with preserved query parameters
        $cases = $query->latest('id')->paginate(10)->withQueryString();

        return view('cases.index', compact('cases'));
    }

    /**
     * Show the form for creating a new medical case (Admin only).
     */
    public function create(): View
    {
        Gate::authorize('create', MedicalCase::class);

        $case = new MedicalCase([
            'status' => MedicalCase::STATUS_DRAFT,
            'priority' => MedicalCase::PRIORITY_MEDIUM,
        ]);

        return view('cases.create', compact('case'));
    }

    /**
     * Store a newly created medical case in storage (Admin only).
     */
    public function store(StoreCaseRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['created_by'] = Auth::id();

        $case = MedicalCase::create($validated);

        return redirect()
            ->route('cases.show', $case)
            ->with('success', "Medical Case {$case->case_number} was successfully created.");
    }

    /**
     * Display the specified medical case details.
     */
    public function show(MedicalCase $case): View
    {
        Gate::authorize('view', $case);

        $case->load('creator:id,name,email');

        return view('cases.show', compact('case'));
    }

    /**
     * Show the form for editing the specified medical case (Admin only).
     */
    public function edit(MedicalCase $case): View
    {
        Gate::authorize('update', $case);

        return view('cases.edit', compact('case'));
    }

    /**
     * Update the specified medical case in storage (Admin only).
     */
    public function update(UpdateCaseRequest $request, MedicalCase $case): RedirectResponse
    {
        Gate::authorize('update', $case);

        $case->update($request->validated());

        return redirect()
            ->route('cases.show', $case)
            ->with('success', "Medical Case {$case->case_number} was successfully updated.");
    }

    /**
     * Remove the specified medical case from storage (Admin only).
     */
    public function destroy(MedicalCase $case): RedirectResponse
    {
        Gate::authorize('delete', $case);

        $caseNumber = $case->case_number;
        $case->delete();

        return redirect()
            ->route('cases.index')
            ->with('success', "Medical Case {$caseNumber} was successfully deleted.");
    }
}
