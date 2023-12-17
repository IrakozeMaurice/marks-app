@component('mail::message')

  Click the button to continue to the app.

  @component('mail::button', ['url' => url('/auth/token', $token)])
    Login to the app
  @endcomponent

  Thanks,<br>
  {{ config('app.name') }}
@endcomponent
