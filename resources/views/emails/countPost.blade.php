@component('mail::message')
# {{ trans('message.notification') }}

**{{ trans('message.hello') }}**, **{{ $user->name }}**
<br>
<br>
{{ trans('message.statistic') }}**{{ $user->name }}** {{ trans('message.onMonth') }}
<br>
@component('mail::panel')
    {{ trans('message.totalPending') }} **{{ $totalPendingPost }}**
    <br>
    {{ trans('message.totalApproved') }} **{{ $totalApprovedPost }}**
@endcomponent
<br>
{{ trans('message.thanks') }},<br>
{{ trans('message.admin') }}
@endcomponent
