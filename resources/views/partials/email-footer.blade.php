<div style="background-color: #e5e7eb; color: #374151; padding: 16px; text-align: center; font-size: 14px; margin-top: 32px;">
    <p style="margin: 0;">{{ $footerTitle ?? config('app.name') }}</p>
    <p style="margin-top: 8px; margin-bottom: 0;">© {{ now()->year }} All rights reserved.</p>
    <p style="font-size: 12px; margin-top: 8px; margin-bottom: 0;">{{ $footerLinks ?? '' }}</p>
</div>
