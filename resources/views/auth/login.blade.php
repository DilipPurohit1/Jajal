<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h3 class="text-lg font-bold text-slate-900">Sign in to your account</h3>
        <p class="text-xs text-slate-500 mt-0.5">Enter your clinical institutional credentials to proceed.</p>
    </div>

    <!-- Quick Fill Helper Buttons for Evaluators -->
    <div class="mb-6 p-3.5 rounded-2xl bg-teal-50/70 border border-teal-100">
        <span class="block text-[11px] font-bold uppercase tracking-wider text-teal-800 mb-2">
            Evaluation Quick-Fill Credentials
        </span>
        <div class="grid grid-cols-2 gap-2">
            <button
                type="button"
                onclick="fillCredentials('admin@jajalmedical.com', 'Password123!')"
                class="px-2.5 py-1.5 rounded-lg bg-white border border-teal-200 text-teal-900 hover:bg-teal-100/60 text-xs font-semibold text-left transition-colors shadow-2xs"
            >
                <div class="font-bold flex items-center justify-between">
                    <span>Admin</span>
                    <span class="text-[9px] uppercase px-1 rounded bg-blue-100 text-blue-700">Full CRUD</span>
                </div>
                <div class="text-[10px] text-teal-700 font-mono truncate">admin@jajalmedical.com</div>
            </button>

            <button
                type="button"
                onclick="fillCredentials('viewer@jajalmedical.com', 'Password123!')"
                class="px-2.5 py-1.5 rounded-lg bg-white border border-teal-200 text-teal-900 hover:bg-teal-100/60 text-xs font-semibold text-left transition-colors shadow-2xs"
            >
                <div class="font-bold flex items-center justify-between">
                    <span>Viewer</span>
                    <span class="text-[9px] uppercase px-1 rounded bg-slate-100 text-slate-700">Read Only</span>
                </div>
                <div class="text-[10px] text-teal-700 font-mono truncate">viewer@jajalmedical.com</div>
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                Email Address
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="clinician@jajalmedical.com"
                class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('email') border-rose-300 ring-rose-200 @enderror"
            />
            @error('email')
                <p class="text-xs font-medium text-rose-600 mt-1 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                Password
            </label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••••••"
                class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('password') border-rose-300 ring-rose-200 @enderror"
            />
            @error('password')
                <p class="text-xs font-medium text-rose-600 mt-1 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center text-xs text-slate-600 cursor-pointer">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500"
                />
                <span class="ms-2">Keep me signed in</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button
                type="submit"
                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold text-sm shadow-md shadow-teal-700/20 transition-all focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                Sign In to Workspace
            </button>
        </div>
    </form>

    <script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</x-guest-layout>
