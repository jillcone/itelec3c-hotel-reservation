<x-layouts.app title="Register">
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
        </div>
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="full_name" class="sr-only">Full name</label>
                    <input id="full_name" name="full_name" type="text" autocomplete="name" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Full Name" value="{{ old('full_name') }}">
                </div>
                <div>
                    <label for="username" class="sr-only">Username</label>
                    <input id="username" name="username" type="text" autocomplete="username" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Username" value="{{ old('username') }}">
                </div>
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address" value="{{ old('email') }}">
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3">
                        <input id="password" name="password" type="password" autocomplete="new-password" required aria-describedby="password_requirements password_requirements_message" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">

                        <div id="password_requirements" class="mt-2 sm:mt-0 flex flex-wrap gap-1">
                            <span id="pw_rule_length" class="inline-flex items-center rounded border border-gray-200 px-2 py-0.5 text-xs text-gray-600 transition-colors duration-200">8+</span>
                            <span id="pw_rule_upper" class="inline-flex items-center rounded border border-gray-200 px-2 py-0.5 text-xs text-gray-600 transition-colors duration-200">A-Z</span>
                            <span id="pw_rule_lower" class="inline-flex items-center rounded border border-gray-200 px-2 py-0.5 text-xs text-gray-600 transition-colors duration-200">a-z</span>
                            <span id="pw_rule_number" class="inline-flex items-center rounded border border-gray-200 px-2 py-0.5 text-xs text-gray-600 transition-colors duration-200">0-9</span>
                            <span id="pw_rule_special" class="inline-flex items-center rounded border border-gray-200 px-2 py-0.5 text-xs text-gray-600 transition-colors duration-200">!@#</span>
                        </div>
                    </div>

                    <p id="password_requirements_message" class="mt-2 text-sm text-red-600 hidden opacity-0 transition-opacity duration-200" aria-live="assertive"></p>
                </div>
                <div>
                    <label for="password_confirmation" class="sr-only">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required aria-describedby="password_match_message" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Confirm Password">
                    <p id="password_match_message" class="mt-2 text-sm text-red-600 hidden opacity-0 transition-opacity duration-200" aria-live="assertive"></p>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Register
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Already have an account? Sign in
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form[action="{{ route('register') }}"]');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const messageEl = document.getElementById('password_requirements_message');
        const matchMessageEl = document.getElementById('password_match_message');

        const ruleEls = {
            length: document.getElementById('pw_rule_length'),
            upper: document.getElementById('pw_rule_upper'),
            lower: document.getElementById('pw_rule_lower'),
            number: document.getElementById('pw_rule_number'),
            special: document.getElementById('pw_rule_special'),
        };

        if (!form || !passwordInput || !confirmPasswordInput || !messageEl || !matchMessageEl) return;

        const checkPassword = (password) => {
            return {
                length: (password || '').length >= 8,
                upper: /[A-Z]/.test(password || ''),
                lower: /[a-z]/.test(password || ''),
                number: /\d/.test(password || ''),
                special: /[^A-Za-z0-9]/.test(password || ''),
            };
        };

        const setRuleState = (el, met) => {
            if (!el) return;
            el.classList.toggle('text-green-600', met);
            el.classList.toggle('border-green-200', met);
            el.classList.toggle('text-gray-600', !met);
            el.classList.toggle('border-gray-200', !met);
            el.classList.toggle('font-medium', met);
        };

        const updateUI = (showMessage = false) => {
            const value = passwordInput.value || '';
            const results = checkPassword(value);
            const allMet = Object.values(results).every(Boolean);

            setRuleState(ruleEls.length, results.length);
            setRuleState(ruleEls.upper, results.upper);
            setRuleState(ruleEls.lower, results.lower);
            setRuleState(ruleEls.number, results.number);
            setRuleState(ruleEls.special, results.special);

            const shouldMarkInvalid = value.length > 0 && !allMet;
            passwordInput.setAttribute('aria-invalid', shouldMarkInvalid ? 'true' : 'false');

            if (showMessage && !allMet) {
                messageEl.textContent = 'Please meet all password requirements before registering.';
                messageEl.classList.remove('hidden');
                // allow transition to apply
                requestAnimationFrame(() => messageEl.classList.remove('opacity-0'));
            } else {
                messageEl.textContent = '';
                messageEl.classList.add('opacity-0');
                // hide after transition
                setTimeout(() => {
                    if (messageEl.textContent === '') messageEl.classList.add('hidden');
                }, 180);
            }

            return allMet;
        };

        const updateMatchUI = (showMessage = false) => {
            const pw = passwordInput.value || '';
            const confirm = confirmPasswordInput.value || '';

            // Don't show mismatch noise when confirm field is empty.
            const hasTypedConfirm = confirm.length > 0;
            const matches = pw === confirm;

            confirmPasswordInput.setAttribute('aria-invalid', (hasTypedConfirm && !matches) ? 'true' : 'false');

            if (showMessage && hasTypedConfirm && !matches) {
                matchMessageEl.textContent = 'Passwords do not match.';
                matchMessageEl.classList.remove('hidden');
                requestAnimationFrame(() => matchMessageEl.classList.remove('opacity-0'));
            } else {
                matchMessageEl.textContent = '';
                matchMessageEl.classList.add('opacity-0');
                setTimeout(() => {
                    if (matchMessageEl.textContent === '') matchMessageEl.classList.add('hidden');
                }, 180);
            }

            return !hasTypedConfirm || matches;
        };

        passwordInput.addEventListener('input', () => {
            updateUI(false);
            updateMatchUI(false);
        });
        passwordInput.addEventListener('blur', () => {
            updateUI(true);
            updateMatchUI(true);
        });

        confirmPasswordInput.addEventListener('input', () => updateMatchUI(false));
        confirmPasswordInput.addEventListener('blur', () => updateMatchUI(true));

        form.addEventListener('submit', (e) => {
            const ok = updateUI(true);
            const matchOk = updateMatchUI(true);
            if (!ok || !matchOk) {
                e.preventDefault();
                (!ok ? passwordInput : confirmPasswordInput).focus();
            }
        });

        updateUI(false);
        updateMatchUI(false);
    });
</script>
</x-layouts.app>