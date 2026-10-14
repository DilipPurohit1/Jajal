<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseRequest;
use App\Http\Requests\UpdateCaseRequest;
use App\Models\MedicalCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CaseApiController extends Controller
{
    /**
     * Display a paginated listing of medical cases.
     */
    public function index(Request $request): JsonResponse
    {
        Gate::authorize('viewAny', MedicalCase::class);

        $query = MedicalCase::with('creator:id,name,email');

        if ($request->filled('search')) {
            $query->search($request->query('search'));
        }

        if ($request->filled('case_number')) {
            $query->where('case_number', 'like', '%' . trim($request->query('case_number')) . '%');
        }

        if ($request->filled('surgeon_name')) {
            $query->where('surgeon_name', 'like', '%' . trim($request->query('surgeon_name')) . '%');
        }

        if ($request->filled('status')) {
            $query->filterStatus($request->query('status'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->query('priority'));
        }

        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);
        $cases = $query->latest('id')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $cases,
            'message' => 'Operation successful',
        ], 200);
    }

    /**
     * Store a newly created medical case.
     */
    public function store(StoreCaseRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['created_by'] = $request->user()->id;

        $case = MedicalCase::create($validated);
        $case->load('creator:id,name,email');

        return response()->json([
            'success' => true,
            'data' => $case,
            'message' => 'Operation successful',
        ], 201);
    }

    /**
     * Display the specified medical case.
     */
    public function show(int $id): JsonResponse
    {
        $case = MedicalCase::with('creator:id,name,email')->find($id);

        if (! $case) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Medical case not found.',
            ], 404);
        }

        Gate::authorize('view', $case);

        return response()->json([
            'success' => true,
            'data' => $case,
            'message' => 'Operation successful',
        ], 200);
    }

    /**
     * Update the specified medical case.
     */
    public function update(UpdateCaseRequest $request, int $id): JsonResponse
    {
        $case = MedicalCase::find($id);

        if (! $case) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Medical case not found.',
            ], 404);
        }

        Gate::authorize('update', $case);

        $case->update($request->validated());
        $case->load('creator:id,name,email');

        return response()->json([
            'success' => true,
            'data' => $case,
            'message' => 'Operation successful',
        ], 200);
    }

    /**
     * Remove the specified medical case.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $case = MedicalCase::find($id);

        if (! $case) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Medical case not found.',
            ], 404);
        }

        Gate::authorize('delete', $case);

        $case->delete();

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Operation successful',
        ], 200);
    }
}
