<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">All Medical Cases</h1>
                <p class="text-sm text-slate-500 mt-0.5">Manage, track, and filter patient-specific surgical implant cases.</p>
            </div>

            @can('create', App\Models\MedicalCase::class)
                <a href="{{ route('cases.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-sm font-bold shadow-md shadow-teal-600/20 transition-all flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Create Case
                </a>
            @endcan
        </div>
    </x-slot>

    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
        <form method="GET" action="{{ route('cases.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search by Case Number -->
                <div>
                    <label for="case_number" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">
                        Case Number
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="case_number"
                            name="case_number"
                            value="{{ request('case_number') }}"
                            placeholder="e.g. CAS-2026"
                            class="w-full pl-9 pr-3 py-2 rounded-xl border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500 font-mono"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Search by Surgeon Name -->
                <div>
                    <label for="surgeon_name" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">
                        Surgeon Name
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="surgeon_name"
                            name="surgeon_name"
                            value="{{ request('surgeon_name') }}"
                            placeholder="e.g. Dr. Patel"
                            class="w-full pl-9 pr-3 py-2 rounded-xl border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filter by Status -->
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">
                        Status Filter
                    </label>
                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500"
                    >
                        <option value="">All Statuses</option>
                        @foreach(App\Models\MedicalCase::STATUSES as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Priority -->
                <div>
                    <label for="priority" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">
                        Priority Level
                    </label>
                    <select
                        id="priority"
                        name="priority"
                        class="w-full rounded-xl border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500"
                    >
                        <option value="">All Priorities</option>
                        @foreach(App\Models\MedicalCase::PRIORITIES as $priority)
                            <option value="{{ $priority }}" {{ request('priority') === $priority ? 'selected' : '' }}>
                                {{ $priority }} Priority
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Filter Controls Buttons -->
            <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-slate-500">
                    Showing <span class="font-bold text-slate-800">{{ $cases->firstItem() ?? 0 }}</span> to <span class="font-bold text-slate-800">{{ $cases->lastItem() ?? 0 }}</span> of <span class="font-bold text-slate-800">{{ $cases->total() }}</span> matching cases
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    @if(request()->hasAny(['case_number', 'surgeon_name', 'status', 'priority', 'search']))
                        <a href="{{ route('cases.index') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-semibold transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear Filters
                        </a>
                    @endif

                    <button type="submit" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold shadow-sm shadow-teal-600/20 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Case Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($cases->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-3.5 px-6">Case Number</th>
                            <th class="py-3.5 px-4">Patient Ref</th>
                            <th class="py-3.5 px-4">Surgeon Name</th>
                            <th class="py-3.5 px-4">Implant Type</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4">Priority</th>
                            <th class="py-3.5 px-4">Surgery Date</th>
                            <th class="py-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($cases as $case)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- Case Number -->
                                <td class="py-4 px-6 font-mono font-bold text-slate-900 whitespace-nowrap">
                                    <a href="{{ route('cases.show', $case) }}" class="text-teal-700 hover:text-teal-900 hover:underline">
                                        {{ $case->case_number }}
                                    </a>
                                </td>

                                <!-- Patient Reference -->
                                <td class="py-4 px-4 font-mono text-xs text-slate-700 whitespace-nowrap">
                                    {{ $case->patient_reference }}
                                </td>

                                <!-- Surgeon Name -->
                                <td class="py-4 px-4 font-medium text-slate-900">
                                    {{ $case->surgeon_name }}
                                </td>

                                <!-- Implant Type -->
                                <td class="py-4 px-4 text-slate-600 max-w-xs truncate" title="{{ $case->implant_type }}">
                                    {{ $case->implant_type }}
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <x-status-badge :status="$case->status" />
                                </td>

                                <!-- Priority Badge -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <x-priority-badge :priority="$case->priority" />
                                </td>

                                <!-- Surgery Date -->
                                <td class="py-4 px-4 text-xs text-slate-600 whitespace-nowrap">
                                    {{ $case->surgery_date ? $case->surgery_date->format('M d, Y') : '—' }}
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <!-- View Details -->
                                        <a
                                            href="{{ route('cases.show', $case) }}"
                                            class="p-1.5 rounded-lg text-slate-600 hover:text-teal-700 hover:bg-teal-50 border border-transparent hover:border-teal-200 transition-colors"
                                            title="View case details"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>

                                        <!-- Edit Case (Admin Only) -->
                                        @can('update', $case)
                                            <a
                                                href="{{ route('cases.edit', $case) }}"
                                                class="p-1.5 rounded-lg text-slate-600 hover:text-blue-700 hover:bg-blue-50 border border-transparent hover:border-blue-200 transition-colors"
                                                title="Edit case"
                                            >
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                        @endcan

                                        <!-- Delete Case (Admin Only) -->
                                        @can('delete', $case)
                                            <form
                                                action="{{ route('cases.destroy', $case) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete medical case #{{ $case->case_number }}?');"
                                                class="inline-block"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="p-1.5 rounded-lg text-slate-600 hover:text-rose-700 hover:bg-rose-50 border border-transparent hover:border-rose-200 transition-colors"
                                                    title="Delete case"
                                                >
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar with Preserved Filters -->
            <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                {{ $cases->links() }}
            </div>
        @else
            <!-- Clear Empty State -->
            <div class="py-16 px-6 text-center">
                <div class="w-16 h-16 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center mx-auto mb-4 border border-teal-100">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">No medical cases found</h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto mt-1">
                    No cases match your active search filters or status parameters. Try adjusting or clearing your filters.
                </p>

                <div class="mt-5 flex items-center justify-center gap-3">
                    <a href="{{ route('cases.index') }}" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition-colors">
                        Clear All Filters
                    </a>

                    @can('create', App\Models\MedicalCase::class)
                        <a href="{{ route('cases.create') }}" class="px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold transition-all shadow-sm">
                            Create First Case
                        </a>
                    @endcan
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
