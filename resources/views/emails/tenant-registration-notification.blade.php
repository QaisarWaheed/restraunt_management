@component('mail::message')
# New Tenant Registration

A new restaurant has registered with {{ config('app.name') }}.

## Tenant Details
- **Restaurant Name:** {{ $tenant->name }}
- **Domain:** {{ $tenant->domain }}
- **Status:** {{ ucfirst($tenant->status) }}
@if($isTrial)
- **Trial Ends:** {{ $trialEndsAt }}
@endif

## Admin User Details
- **Name:** {{ $user->name }}
- **Email:** {{ $user->email }}
- **Phone:** {{ $user->phone }}
- **Address:** {{ $user->address }}

@component('mail::button', ['url' => route('super-admin.tenants.show', $tenant)])
View Tenant Details
@endcomponent

Thanks,<br>
{{ config('app.name') }} System
@endcomponent 