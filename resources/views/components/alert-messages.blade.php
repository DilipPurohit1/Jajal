@if (session('success'))
    <div x-data="{ show: true }" x-show="show" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 shadow-sm text-emerald-800 transition-all">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-3">
                <div class="rounded-lg bg-emerald-100 p-2 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-emerald-900">Success</h4>
                    <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
            <button @click="show = false" type="button" class="text-emerald-500 hover:text-emerald-700 focus:outline-none">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 shadow-sm text-rose-800 transition-all">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-3">
                <div class="rounded-lg bg-rose-100 p-2 text-rose-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-rose-900">Error</h4>
                    <p class="text-sm text-rose-700 mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
            <button @click="show = false" type="button" class="text-rose-500 hover:text-rose-700 focus:outline-none">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-show="show" class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 shadow-sm text-rose-800 transition-all">
        <div class="flex items-start justify-between">
            <div class="flex items-start gap-3">
                <div class="rounded-lg bg-rose-100 p-2 text-rose-600 flex-shrink-0 mt-0.5">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-rose-900">Please review the following errors:</h4>
                    <ul class="mt-1.5 list-disc list-inside text-sm text-rose-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button @click="show = false" type="button" class="text-rose-500 hover:text-rose-700 focus:outline-none">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@endif
