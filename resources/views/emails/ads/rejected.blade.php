<x-mail::message>
# Hi {{ $userName }},

<div style="text-align: center; margin: 25px 0 15px;">
    <div style="display: inline-block; width: 64px; height: 64px; line-height: 64px; border-radius: 50%; background-color: #fef2f2; border: 2px solid #ef4444; font-size: 32px;">
        ⚠️
    </div>
</div>

<p style="font-size: 16px; line-height: 1.6; color: #1e293b; text-align: center; margin-bottom: 24px;">
    We reviewed your advertisement <strong>"{{ $adTitle }}"</strong>, but unfortunately it could not be approved at this time.
</p>

<x-mail::panel>
<div style="font-size: 14px; line-height: 1.8;">
<strong style="color: #991b1b; font-size: 15px; display: block; margin-bottom: 6px; border-bottom: 1px solid #fee2e2; padding-bottom: 4px;">
📝 Reason for Rejection
</strong>
<p style="color: #450a0a; margin: 0; padding-top: 4px;">
    {{ $reason }}
</p>
</div>
</x-mail::panel>

<x-mail::button :url="$editUrl" color="primary">
Edit & Resubmit Ad
</x-mail::button>

<p style="text-align: center; margin-top: -10px; margin-bottom: 24px;">
    <a href="{{ $myAdsUrl }}" style="font-size: 13px; font-weight: 600; color: #00A651; text-decoration: underline;">
        View All My Ads &rarr;
    </a>
</p>

<p style="font-size: 14px; color: #475569; line-height: 1.6;">
    You can easily update your ad details to address the feedback and resubmit it. Once updated, our team will review it again promptly.
</p>

<p style="font-size: 14px; color: #334155; margin-top: 24px;">
    Warm regards,<br>
    <strong>— The Veyangoda.lk Team</strong>
</p>

<x-slot:subcopy>
<p style="font-size: 12px; color: #94a3b8; line-height: 1.5; text-align: center;">
    &copy; {{ date('Y') }} Veyangoda.lk | Need assistance? <a href="{{ route('contact.index') }}" style="color: #64748b; text-decoration: underline;">Contact our support team</a>.
</p>
</x-slot:subcopy>
</x-mail::message>
