@component('mail::message')
# Hello, {{ $order->user->name }}.

Your order **#{{ $order->id }}** status is updated.

Please check your order detail via this [{{$orderUrl}}]({{ $orderUrl }}).

Thanks,<br>
{{ config('app.name') }}
@endcomponent
