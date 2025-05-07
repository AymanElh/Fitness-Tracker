<x-mail::message>
    # Password Reset Request

    Hello, {{ $name }}

    You are receiving this email because we received a password reset request for your account.

    Click the button below to reset your password. This password reset link will expire in 60 minutes.

    <x-mail::button :url="url('/password/reset', $token)">
        Reset Password
    </x-mail::button>

    If you did not request a password reset, no further action is required.

    For security:
    - This link will expire in 60 minutes
    - If you're having trouble clicking the button, copy and paste this URL into your browser: {{ $url }}

    Thanks,<br>
    {{ config('app.name') }}

    <small>If you're having trouble, please contact our support team.</small>
</x-mail::message>
