@component('mail::message')
# Hello,

Your order ID is **#{{$order->id}}**.

Summary of your order is shown below.

To view complete detail of the order: [{{ $orderUrl }}]({{ $orderUrl }}).

@component('mail::table')
| Cart Items    | Qty    | Item Price | Item Total |
| ------------- |:------:| ----------:| ---------: |
@foreach($order->books as $book)
| {{$book->title}} | {{$book->pivot->quantity}} | ${{number_format($book->price/100, 2)}} | ${{number_format(($book->pivot->quantity * $book->price)/100, 2)}} |
@endforeach
| Sub total      ||| ${{number_format($order->total/100, 2)}} |
| Payment Method ||| Visa |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
