<x-mail::message>
# Hi {{ $userName }},

<div style="text-align: center; margin: 25px 0 15px;">
    <div style="display: inline-block; width: 64px; height: 64px; line-height: 64px; border-radius: 50%; background-color: #ecfdf5; border: 2px solid #10b981; font-size: 32px;">
        ✅
    </div>
</div>

<p style="font-size: 16px; line-height: 1.6; color: #1e293b; text-align: center; margin-bottom: 24px;">
    Good news! Your advertisement <strong>"{{ $adTitle }}"</strong> has been approved and is now live on <strong>Veyangoda.lk</strong>.
</p>

<x-mail::panel>
<div style="font-size: 14px; line-height: 1.8;">
<strong style="color: #0f172a; font-size: 15px; display: block; margin-bottom: 6px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">
📋 Advertisement Details
</strong>
<table style="width: 100%; border-collapse: collapse; font-size: 14px;">
    <tr>
        <td style="padding: 4px 0; color: #64748b; width: 90px;"><strong>Title:</strong></td>
        <td style="padding: 4px 0; color: #0f172a; font-weight: 600;">{{ $adTitle }}</td>
    </tr>
    <tr>
        <td style="padding: 4px 0; color: #64748b;"><strong>Price:</strong></td>
        <td style="padding: 4px 0; color: #00A651; font-weight: 700;">{{ $price }}</td>
    </tr>
    <tr>
        <td style="padding: 4px 0; color: #64748b;"><strong>Category:</strong></td>
        <td style="padding: 4px 0; color: #334155;">{{ $category }}</td>
    </tr>
    <tr>
        <td style="padding: 4px 0; color: #64748b;"><strong>Location:</strong></td>
        <td style="padding: 4px 0; color: #334155;">{{ $location }}</td>
    </tr>
</table>
</div>
</x-mail::panel>

<x-mail::button :url="$adUrl" color="success">
View My Ad Now
</x-mail::button>

<p style="text-align: center; margin-top: -10px; margin-bottom: 24px;">
    <a href="{{ $myAdsUrl }}" style="font-size: 13px; font-weight: 600; color: #00A651; text-decoration: underline;">
        View All My Ads &rarr;
    </a>
</p>

<p style="font-size: 14px; color: #475569; line-height: 1.6;">
    Your ad is now visible to thousands of buyers. You'll receive a notification if someone contacts you.
</p>

<p style="font-size: 14px; color: #334155; margin-top: 24px;">
    Warm regards,<br>
    <strong>— The Veyangoda.lk Team</strong>
</p>

<x-slot:subcopy>
<p style="font-size: 12px; color: #94a3b8; line-height: 1.5; text-align: center;">
    &copy; {{ date('Y') }} Veyangoda.lk | If you didn't submit this ad, please <a href="{{ route('contact.index') }}" style="color: #64748b; text-decoration: underline;">contact support</a>.
</p>
</x-slot:subcopy>
</x-mail::message>
