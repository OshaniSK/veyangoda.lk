<x-mail::message>
{{-- Header Branding --}}
# {{ $greeting ?? 'Hello from Veyangoda.lk!' }}

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success' => 'success',
        'error'   => 'error',
        default   => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Warm regards,<br>
**The Veyangoda.lk Team**
@endif

{{-- Subcopy / Fallback URL --}}
@isset($actionText)
<x-slot:subcopy>
If you're having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below into your web browser:
[{{ $displayableActionUrl }}]({{ $actionUrl }})

---

<small style="color: #64748b; font-size: 11px;">
You received this notification because you are a registered seller on Veyangoda.lk.<br>
To manage your ad notifications, visit your <a href="{{ route('profile.edit') }}" style="color: #00A651; text-decoration: underline;">Account Settings</a>. If you have questions or need assistance, reach out to <a href="mailto:support@veyangoda.lk" style="color: #00A651; text-decoration: underline;">support@veyangoda.lk</a>.<br>
&copy; {{ date('Y') }} Veyangoda.lk. All rights reserved. Veyangoda, Sri Lanka.
</small>
</x-slot:subcopy>
@endisset
</x-mail::message>
