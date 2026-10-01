<x-guest-layout>
    <div style="max-width: 440px; margin: 0 auto; width: 100%;">
        <!-- Header / Logo Area -->
        <div style="text-align: center; margin-bottom: 24px;">
            <a href="/" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; margin-bottom: 12px;">
                <span style="background-color: #005327; color: white; padding: 6px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                </span>
                <span style="font-size: 22px; font-weight: 700; color: #1C2826; font-family: sans-serif;">MarketLink</span>
            </a>
            <h2 style="font-size: 24px; font-weight: 700; color: #005327; margin: 0;">Welcome back</h2>
            <p style="font-size: 14px; color: #6b7280; margin-top: 6px;">Sign in to manage your orders and farm fresh harvest.</p>
        </div>

        <!-- Form Card -->
        <div style="background-color: #ffffff; border: 1px solid #E5DFD5; border-radius: 12px; padding: 32px 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div style="margin-bottom: 18px;">
                    <x-input-label for="email" :value="__('Email')" style="display: block; font-size: 14px; font-weight: 600; color: #1C2826; margin-bottom: 6px;" />
                    <x-text-input 
                        id="email" 
                        style="width: 100%; border: 1px solid #E5DFD5; border-radius: 8px; padding: 10px 12px; font-size: 14px; outline: none; box-sizing: border-box;" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username" 
                        placeholder="you@example.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div style="margin-bottom: 18px;">
                    <x-input-label for="password" :value="__('Password')" style="display: block; font-size: 14px; font-weight: 600; color: #1C2826; margin-bottom: 6px;" />
                    <x-text-input 
                        id="password" 
                        style="width: 100%; border: 1px solid #E5DFD5; border-radius: 8px; padding: 10px 12px; font-size: 14px; outline: none; box-sizing: border-box;"
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password" 
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                    <label for="remember_me" style="display: inline-flex; align-items: center; cursor: pointer;">
                        <input id="remember_me" type="checkbox" style="border-radius: 4px; border: 1px solid #E5DFD5; accent-color: #005327; width: 16px; height: 16px;" name="remember">
                        <span style="margin-left: 8px; font-size: 14px; color: #4b5563;">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a style="font-size: 14px; font-weight: 500; color: #005327; text-decoration: none;" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" style="width: 100%; padding: 12px; border: none; border-radius: 8px; background-color: #005327; color: white; font-size: 14px; font-weight: 600; cursor: pointer; transition: background-color 0.2s;">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>

            <!-- Register Redirect Footer -->
            <div style="margin-top: 24px; border-top: 1px solid #E5DFD5; padding-top: 20px; text-align: center;">
                <p style="font-size: 14px; color: #4b5563; margin: 0;">
                    Don't have an account? 
                    <a href="{{ route('register') }}" style="font-weight: 600; color: #005327; text-decoration: underline;">
                        Create an account
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>