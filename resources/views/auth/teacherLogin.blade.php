<x-guest-layout>
  <x-auth-card>
    <x-slot name="logo">
      @if (session('success'))
        <div class="bg-teal-500 text-white font-bold text-center mb-3 py-5 px-4 rounded-md">
          {{ session('success') }}
        </div>
      @endif
      <a href="/" class="w-20 h-20 fill-current text-gray-500"><img
          src="{{ asset('images/aucaLogo.png') }}"
          alt="Auca logo" width="400"></a>
    </x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <h4 class="text-center text-primary"><b>You are signing in as a TEACHER</b></h4>
    <form method="POST" action="{{ route('teacher.store') }}">
      @csrf

      <!-- Email Address -->
      <div>
        <x-label for="email" :value="__('Email')" />

        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
          autofocus />
      </div>

      <div class='mt-1'>
        <x-button>
          {{ __('Log in') }}
        </x-button>
      </div>
    </form>
    @if (session('error'))
      <div class="mt-2 text-center" style="color: red;font-weight: bold;">
        <strong>{{ session('error') }}</strong>
      </div>
    @endif
  </x-auth-card>
</x-guest-layout>
