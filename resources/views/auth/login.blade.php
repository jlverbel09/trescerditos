<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" autocomplete="off"
    >
        @csrf

        <!-- Email Address -->
        <div>
            {{-- <x-input-label for="email" value="Código" /> --}}
            <x-text-input id="email" placeholder="Código de acceso" class="block mt-1 w-full text-white" type="password" name="email" :value="old('email')" required autofocus autocomplete="off"
            spellcheck="false" onfocus="this.removeAttribute('readonly');" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4"  style="display:none">
            <x-input-label for="password" value="Contraseña"  />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password" value="123456789"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
      {{--   <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div> --}}

        <div class="flex items-center justify-end mt-4">
            {{-- @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif --}}

            <x-primary-button class="ms-0 " style="width: 100%; justify-content: center" >
                <div style="text-align:center;justify-content: center;display:flex">Ingresar</div>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
