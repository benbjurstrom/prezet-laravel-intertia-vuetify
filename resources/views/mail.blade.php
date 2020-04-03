@component('mail::message')
  # Hello {{ $user->name }}

  {{ $message }}

  @isset($action)

  @component('mail::button', ['url' => $action['url']])
  {{ $action['text'] }}
  @endcomponent
  @endisset

  Thanks,<br>
  {{ config('app.name') }} HQ

  @isset($action)

  @component('mail::subcopy')
  @lang(
      "If you’re having trouble clicking the " . $action['text'] ." button, copy and paste the URL below\n".
      'into your web browser: [:url](:url)',
      [
          'url' => $action['url'],
      ]
  )
@endcomponent
@endisset

@endcomponent
