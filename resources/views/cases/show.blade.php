<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('cases.index') }}" class="p-2 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Case #{{ $case->case_number }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">Comprehensive surgical implant dossier and audit details.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Top Summary Bar with Actions -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="text-xs font-mono font-bold text-slate-400">ID: #{{ $case->id }}</span>
                <span class="h-4 w-px bg-slate-200"></span>
                <x-status-badge :status="$case->status" class="text-sm py-1 px-3" />
                <x-priority-badge :priority="$case->priority" class="text-sm py-1 px-3" />
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5">
                <a href="{{ route('cases.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Cases
                </a>

                @can('update', $case)
                    <a href="{{ route('cases.edit', $case) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold shadow-sm shadow-teal-600/20 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        Edit Case
                    </a>
                @endcan

                @can('delete', $case)
                    <form
                        action="{{ route('cases.destroy', $case) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete medical case #{{ $case->case_number }}? This action is permanent and cannot be undone.');"
                        class="inline-block"
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition-colors">
                            <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>

        <!-- 2-Column Detail Specification -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Clinical Info (2 cols) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Clinical & Implant Specifications
                    </h3>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5 text-sm">
                        <!-- Case ID -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Database ID</dt>
                            <dd class="mt-1 font-mono font-bold text-slate-900">{{ $case->id }}</dd>
                        </div>

                        <!-- Case Number -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Case Number</dt>
                            <dd class="mt-1 font-mono font-extrabold text-teal-700">{{ $case->case_number }}</dd>
                        </div>

                        <!-- Patient Reference -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Patient Reference Code</dt>
                            <dd class="mt-1 font-mono font-semibold text-slate-800">{{ $case->patient_reference }}</dd>
                        </div>

                        <!-- Surgery Date -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Surgery Date</dt>
                            <dd class="mt-1 font-medium text-slate-900">
                                @if($case->surgery_date)
                                    <span class="inline-flex items-center gap-1.5 font-semibold text-slate-900">
                                        <svg class="w-4 h-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $case->surgery_date->format('l, F j, Y') }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Not scheduled yet</span>
                                @endif
                            </dd>
                        </div>

                        <!-- Surgeon Name -->
                        <div class="sm:col-span-2 p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Lead Operating Surgeon</dt>
                            <dd class="mt-1 text-base font-bold text-slate-900 flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $case->surgeon_name }}
                            </dd>
                        </div>

                        <!-- Implant Type -->
                        <div class="sm:col-span-2 p-4 rounded-xl bg-teal-50/60 border border-teal-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-teal-800">Target Implant Architecture</dt>
                            <dd class="mt-1.5 text-base font-extrabold text-teal-950 flex items-center gap-2">
                                <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                </svg>
                                {{ $case->implant_type }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Right Meta & Audit Info (1 col) -->
            <div class="space-y-6">
                <!-- Status & Priority Card -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">
                        Status & Workflow
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <span class="block text-xs text-slate-400 uppercase font-semibold mb-1">Current State</span>
                            <x-status-badge :status="$case->status" class="py-1 px-3 text-sm" />
                        </div>

                        <div>
                            <span class="block text-xs text-slate-400 uppercase font-semibold mb-1">Priority Rank</span>
                            <x-priority-badge :priority="$case->priority" class="py-1 px-3 text-sm" />
                        </div>
                    </div>
                </div>

                <!-- Audit Metadata Card -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">
                        System Audit Trail
                    </h3>

                    <dl class="space-y-4 text-xs">
                        <div>
                            <dt class="font-semibold text-slate-500 uppercase tracking-wider text-[10px]">Created By</dt>
                            <dd class="mt-1 flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-700 font-bold flex items-center justify-center text-[11px]">
                                    {{ strtoupper(substr($case->creator->name ?? 'U', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $case->creator->name ?? 'System' }}</p>
                                    <p class="text-slate-400 text-[11px]">{{ $case->creator->email ?? 'N/A' }}</p>
                                </div>
                            </dd>
                        </div>

                        <div class="border-t border-slate-100 pt-3">
                            <dt class="font-semibold text-slate-500 uppercase tracking-wider text-[10px]">Created At</dt>
                            <dd class="mt-1 font-medium text-slate-800">
                                {{ $case->created_at->format('M d, Y \a\t H:i:s T') }}
                                <span class="block text-[11px] text-slate-400">{{ $case->created_at->diffForHumans() }}</span>
                            </dd>
                        </div>

                        <div class="border-t border-slate-100 pt-3">
                            <dt class="font-semibold text-slate-500 uppercase tracking-wider text-[10px]">Last Updated</dt>
                            <dd class="mt-1 font-medium text-slate-800">
                                {{ $case->updated_at->format('M d, Y \a\t H:i:s T') }}
                                <span class="block text-[11px] text-slate-400">{{ $case->updated_at->diffForHumans() }}</span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
