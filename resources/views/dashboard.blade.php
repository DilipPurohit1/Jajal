<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Clinical Dashboard</h1>
            <p class="text-sm text-slate-500 mt-0.5">Real-time status overview of custom surgical implants and patient cases.</p>
        </div>
    </x-slot>

    <!-- Top Action Banner -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gradient-to-r from-teal-900 via-teal-800 to-slate-900 text-white rounded-2xl p-6 sm:p-7 shadow-lg shadow-teal-950/10">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-teal-500/20 text-teal-300 text-xs font-semibold mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                Jajal Medical Case Operations
            </div>
            <h2 class="text-xl sm:text-2xl font-bold tracking-tight">Welcome, {{ Auth::user()->name }}</h2>
            <p class="text-teal-100/80 text-sm mt-1 max-w-2xl">
                You have <span class="font-bold text-white">{{ $planningCases + $inReviewCases }}</span> active cases requiring clinical planning or peer review.
                @if(Auth::user()->isAdmin())
                    You have <span class="text-teal-300 font-semibold">Admin</span> privileges to create, update, and manage all cases.
                @else
                    You have <span class="text-teal-300 font-semibold">Viewer</span> privileges to explore cases and patient references.
                @endif
            </p>
        </div>

        <div class="flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('cases.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-sm font-semibold backdrop-blur-sm transition-all border border-white/10">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M3.75 4.5h16.5m-16.5 3.75h16.5" />
                </svg>
                View Case List
            </a>

            @can('create', App\Models\MedicalCase::class)
                <a href="{{ route('cases.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-teal-500 hover:bg-teal-400 text-slate-950 text-sm font-bold shadow-md shadow-teal-950/20 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    New Medical Case
                </a>
            @endcan
        </div>
    </div>

    <!-- Mandatory 5 Dynamic Statistic Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-5 mb-8">
        <!-- 1. Total Cases -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Cases</span>
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ number_format($totalCases) }}</span>
                <span class="text-xs font-medium text-slate-500">All Database</span>
            </div>
            <div class="mt-3 text-xs text-slate-500 border-t border-slate-100 pt-2 flex items-center justify-between">
                <span>Database registered</span>
                <span class="font-semibold text-slate-700">100%</span>
            </div>
        </div>

        <!-- 2. Planning Cases -->
        <div class="bg-white rounded-2xl p-5 border border-sky-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-700">Planning</span>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-sky-700 tracking-tight">{{ number_format($planningCases) }}</span>
                <span class="text-xs font-medium text-sky-600">In Design</span>
            </div>
            <div class="mt-3 text-xs text-slate-500 border-t border-sky-100 pt-2 flex items-center justify-between">
                <span>CAD/CAM Phase</span>
                <span class="font-semibold text-sky-700">{{ $totalCases > 0 ? round(($planningCases / $totalCases) * 100) : 0 }}%</span>
            </div>
        </div>

        <!-- 3. In Review Cases -->
        <div class="bg-white rounded-2xl p-5 border border-amber-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-700">In Review</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-amber-700 tracking-tight">{{ number_format($inReviewCases) }}</span>
                <span class="text-xs font-medium text-amber-600">Surgeon Sign-off</span>
            </div>
            <div class="mt-3 text-xs text-slate-500 border-t border-amber-100 pt-2 flex items-center justify-between">
                <span>Awaiting feedback</span>
                <span class="font-semibold text-amber-700">{{ $totalCases > 0 ? round(($inReviewCases / $totalCases) * 100) : 0 }}%</span>
            </div>
        </div>

        <!-- 4. Approved Cases -->
        <div class="bg-white rounded-2xl p-5 border border-emerald-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Approved</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-emerald-700 tracking-tight">{{ number_format($approvedCases) }}</span>
                <span class="text-xs font-medium text-emerald-600">Ready to Print</span>
            </div>
            <div class="mt-3 text-xs text-slate-500 border-t border-emerald-100 pt-2 flex items-center justify-between">
                <span>Production ready</span>
                <span class="font-semibold text-emerald-700">{{ $totalCases > 0 ? round(($approvedCases / $totalCases) * 100) : 0 }}%</span>
            </div>
        </div>

        <!-- 5. Completed Cases -->
        <div class="bg-white rounded-2xl p-5 border border-teal-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Completed</span>
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-teal-700 tracking-tight">{{ number_format($completedCases) }}</span>
                <span class="text-xs font-medium text-teal-600">Manufactured</span>
            </div>
            <div class="mt-3 text-xs text-slate-500 border-t border-teal-100 pt-2 flex items-center justify-between">
                <span>Delivered / Closed</span>
                <span class="font-semibold text-teal-700">{{ $totalCases > 0 ? round(($completedCases / $totalCases) * 100) : 0 }}%</span>
            </div>
        </div>
    </div>

    <!-- Recent Medical Cases Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Recent Medical Cases</h3>
                <p class="text-xs text-slate-500 mt-0.5">Latest implant requests entered into the medical administration pipeline.</p>
            </div>
            <a href="{{ route('cases.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-600 hover:text-teal-700 transition-colors">
                View all cases
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        @if($recentCases->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200/70 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-3 px-6">Case Number</th>
                            <th class="py-3 px-4">Patient Ref</th>
                            <th class="py-3 px-4">Surgeon</th>
                            <th class="py-3 px-4">Implant Type</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Priority</th>
                            <th class="py-3 px-4">Surgery Date</th>
                            <th class="py-3 px-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($recentCases as $case)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                    <a href="{{ route('cases.show', $case) }}" class="text-teal-700 hover:text-teal-900 hover:underline">
                                        {{ $case->case_number }}
                                    </a>
                                </td>
                                <td class="py-4 px-4 font-mono text-xs text-slate-600">
                                    {{ $case->patient_reference }}
                                </td>
                                <td class="py-4 px-4 font-medium text-slate-900">
                                    {{ $case->surgeon_name }}
                                </td>
                                <td class="py-4 px-4 text-slate-600 max-w-xs truncate" title="{{ $case->implant_type }}">
                                    {{ $case->implant_type }}
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <x-status-badge :status="$case->status" />
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <x-priority-badge :priority="$case->priority" />
                                </td>
                                <td class="py-4 px-4 text-xs text-slate-600 whitespace-nowrap">
                                    {{ $case->surgery_date ? $case->surgery_date->format('M d, Y') : '—' }}
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <a href="{{ route('cases.show', $case) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-teal-50 hover:text-teal-700 border border-slate-200 transition-colors">
                                        View
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-12 text-center text-slate-500">
                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="font-medium text-slate-700">No medical cases recorded yet.</p>
                <p class="text-xs text-slate-400 mt-1">Cases entered into the system will show up here automatically.</p>
            </div>
        @endif
    </div>

    <!-- System Roles & Compliance Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">Role-Based Access Control</h4>
                    <p class="text-xs text-slate-500">Configured roles & backend policy enforcement</p>
                </div>
            </div>
            <div class="space-y-3 text-xs">
                <div class="flex items-start gap-2.5 p-3 rounded-xl bg-blue-50/50 border border-blue-100">
                    <span class="px-2 py-0.5 rounded font-bold bg-blue-100 text-blue-800 text-[10px] uppercase">Admin</span>
                    <span class="text-slate-600">Full CRUD capabilities: Create, view, edit surgical details, transition statuses, and delete records.</span>
                </div>
                <div class="flex items-start gap-2.5 p-3 rounded-xl bg-teal-50/50 border border-teal-100">
                    <span class="px-2 py-0.5 rounded font-bold bg-teal-100 text-teal-800 text-[10px] uppercase">Viewer</span>
                    <span class="text-slate-600">Read-only capabilities: Search, filter, view all medical cases and clinical details. Actions returning 403 Forbidden on write attempts.</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">REST API Integration</h4>
                    <p class="text-xs text-slate-500">Sanctum token-based medical integration endpoints</p>
                </div>
            </div>
            <p class="text-xs text-slate-600 leading-relaxed mb-3">
                All cases can be consumed programmatically via <code class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-800 font-mono text-[11px]">/api/cases</code> with standard JSON responses, pagination, and authorization filters.
            </p>
            <div class="text-[11px] font-mono text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-200 flex items-center justify-between">
                <span>POST /api/login &bull; GET /api/cases</span>
                <span class="text-teal-700 font-semibold">Sanctum v4</span>
            </div>
        </div>
    </div>
</x-app-layout>
