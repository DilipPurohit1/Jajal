@php
    $isEdit = isset($case) && $case->exists;
@endphp

<div class="space-y-6">
    <!-- Grid for Primary Identifiers -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Case Number -->
        <div>
            <label for="case_number" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Case Number <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <input
                    type="text"
                    id="case_number"
                    name="case_number"
                    value="{{ old('case_number', $case->case_number ?? '') }}"
                    placeholder="e.g. CAS-2026-1050"
                    required
                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm font-mono @error('case_number') border-rose-300 ring-rose-200 @enderror"
                />
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Unique institutional medical tracking identifier.</p>
            @error('case_number')
                <p class="text-xs font-medium text-rose-600 mt-1 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Patient Reference -->
        <div>
            <label for="patient_reference" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Patient Reference Code <span class="text-rose-500">*</span>
            </label>
            <input
                type="text"
                id="patient_reference"
                name="patient_reference"
                value="{{ old('patient_reference', $case->patient_reference ?? '') }}"
                placeholder="e.g. PT-JM-8842"
                required
                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm font-mono @error('patient_reference') border-rose-300 ring-rose-200 @enderror"
            />
            <p class="text-[11px] text-slate-400 mt-1">Anonymized de-identified reference code (HIPAA-compliant).</p>
            @error('patient_reference')
                <p class="text-xs font-medium text-rose-600 mt-1 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <!-- Grid for Clinical Details -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Surgeon Name -->
        <div>
            <label for="surgeon_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Lead Surgeon <span class="text-rose-500">*</span>
            </label>
            <input
                type="text"
                id="surgeon_name"
                name="surgeon_name"
                value="{{ old('surgeon_name', $case->surgeon_name ?? '') }}"
                placeholder="e.g. Dr. Sarah Jenkins, MD, FACS"
                required
                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm @error('surgeon_name') border-rose-300 ring-rose-200 @enderror"
            />
            <p class="text-[11px] text-slate-400 mt-1">Operating surgeon or clinical specialist responsible.</p>
            @error('surgeon_name')
                <p class="text-xs font-medium text-rose-600 mt-1 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Implant Type -->
        <div>
            <label for="implant_type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Implant Type <span class="text-rose-500">*</span>
            </label>
            <input
                type="text"
                id="implant_type"
                name="implant_type"
                value="{{ old('implant_type', $case->implant_type ?? '') }}"
                placeholder="e.g. PEEK Patient-Specific Cranial Implant"
                required
                list="implant_suggestions"
                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm @error('implant_type') border-rose-300 ring-rose-200 @enderror"
            />
            <datalist id="implant_suggestions">
                <option value="PEEK Patient-Specific Cranial Implant">
                <option value="3D-Printed Titanium Mandibular Reconstruction Plate">
                <option value="Trabecular Titanium Acetabular Revision Cup">
                <option value="Patient-Specific Maxillofacial Mesh">
                <option value="Custom Porous Hip Stem">
                <option value="Custom Spinal Interbody Fusion Cage">
                <option value="Patient-Specific Knee Surgical Guide & Plate">
                <option value="Custom Sternum Reconstruction Plate">
                <option value="Subperiosteal Dental Implant Framework">
                <option value="Titanium Orbital Floor Mesh">
            </datalist>
            <p class="text-[11px] text-slate-400 mt-1">Specific custom device, mesh, or prosthesis geometry.</p>
            @error('implant_type')
                <p class="text-xs font-medium text-rose-600 mt-1 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <!-- Grid for Workflow & Scheduling -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Status Dropdown -->
        <div>
            <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Case Status <span class="text-rose-500">*</span>
            </label>
            <select
                id="status"
                name="status"
                required
                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm @error('status') border-rose-300 ring-rose-200 @enderror"
            >
                @foreach(App\Models\MedicalCase::STATUSES as $statusOption)
                    <option value="{{ $statusOption }}" {{ old('status', $case->status ?? 'Draft') === $statusOption ? 'selected' : '' }}>
                        {{ $statusOption }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="text-xs font-medium text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Priority Dropdown -->
        <div>
            <label for="priority" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Priority Level <span class="text-rose-500">*</span>
            </label>
            <select
                id="priority"
                name="priority"
                required
                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm @error('priority') border-rose-300 ring-rose-200 @enderror"
            >
                @foreach(App\Models\MedicalCase::PRIORITIES as $priorityOption)
                    <option value="{{ $priorityOption }}" {{ old('priority', $case->priority ?? 'Medium') === $priorityOption ? 'selected' : '' }}>
                        {{ $priorityOption }} Priority
                    </option>
                @endforeach
            </select>
            @error('priority')
                <p class="text-xs font-medium text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Surgery Date -->
        <div>
            <label for="surgery_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Scheduled Surgery Date <span class="text-slate-400 font-normal lowercase">(optional)</span>
            </label>
            <input
                type="date"
                id="surgery_date"
                name="surgery_date"
                value="{{ old('surgery_date', isset($case->surgery_date) ? (is_string($case->surgery_date) ? $case->surgery_date : $case->surgery_date->format('Y-m-d')) : '') }}"
                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm @error('surgery_date') border-rose-300 ring-rose-200 @enderror"
            />
            <p class="text-[11px] text-slate-400 mt-1">Planned operation day if determined.</p>
            @error('surgery_date')
                <p class="text-xs font-medium text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Form Actions -->
    <div class="pt-6 border-t border-slate-200 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
        <a
            href="{{ $isEdit ? route('cases.show', $case) : route('cases.index') }}"
            class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-semibold text-center transition-colors"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-sm font-bold shadow-md shadow-teal-700/20 transition-all"
        >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            {{ $isEdit ? 'Save Changes' : 'Create Medical Case' }}
        </button>
    </div>
</div>
