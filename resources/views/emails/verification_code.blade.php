@component('mail::message')
# Your Verification Code

Hello,

We received a verification request. Please use the 6-digit code below to complete your process:

@component('mail::panel')
<div style="text-align: center;">
    <h2 style="font-size: 32px; font-weight: bold; margin: 0; color: #5D4037;">{{ $code }}</h2>
</div>
@endcomponent

This code will expire in **5 minutes**.

If you did not request this code, please ignore this email.

Regards,  
Shoes Del Rey Team
@endcomponent
