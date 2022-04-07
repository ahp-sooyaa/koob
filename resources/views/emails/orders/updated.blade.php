@component('mail::message')
# Hello, {{ $order->user->name }}.

Your order #{{ $order->id }} status is updated.   
Please check your order detail via this [link]({{ asset("/orders/$order->id") }}).
{{-- {{ $order }} --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
