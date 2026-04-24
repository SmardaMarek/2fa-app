<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('You must set up two-factor authentication before continuing. Scan the QR code below with your Google Authenticator app and enter the 6-digit code to verify.') }}
    </div>

    <div class="flex justify-center mb-6">
        {!! $qrCodeSvg !!}
    </div>

    <form method="POST" action="{{ route('mfa.verify_setup') }}">
        @csrf

        <!-- Authentication Code -->
        <div>
            <x-input-label for="code" :value="__('Authentication Code')" />

            <x-text-input id="code" class="block mt-1 w-full text-center tracking-widest text-lg"
                            type="text"
                            inputmode="numeric"
                            autofocus
                            name="code"
                            required autocomplete="one-time-code" />

            <x-input-error :messages="$errors->get('code')" class="mt-2" />
            <x-input-error :messages="$errors->get('error')" class="mt-2" />
        </div>

        {{-- Manuální klíč --}}
        <div class="mt-4 text-center">
            <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">{{ __('Manuální klíč (pokud nelze skenovat):') }}</span>
            <code class="block bg-gray-100 dark:bg-gray-700 text-indigo-600 dark:text-indigo-400 px-3 py-2 rounded-lg font-mono text-xs break-all">{{ $secret }}</code>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Verify and Continue') }}
            </x-primary-button>
        </div>
    </form>
    
    <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
        @csrf
        <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            {{ __('Log Out') }}
        </button>
    </form>
</x-guest-layout>
