@component('mail::message')
# Hello,

Your have received a new order from **{{$order->user->name}}** for **{{$order->books->count()}}** item(s) totalling **${{number_format($order->total/100, 2)}}**.

## Your customer ordered
@component('mail::table')
| Cart Items    | Qty    | Item Price | Item Total |
| ------------- |:------:| ----------:| ---------: |
@foreach($order->books as $book)
| {{$book->title}} | {{$book->pivot->quantity}} | ${{number_format($book->price/100, 2)}} | ${{number_format(($book->pivot->quantity * $book->price)/100, 2)}} |
@endforeach
| Sub total      ||| ${{number_format($order->total/100, 2)}} |
| Payment Method ||| Visa |
@endcomponent

To view complete detail of the order: [{{ $orderUrl }}]({{ $orderUrl }}).

Thanks,<br>
{{ config('app.name') }}
@endcomponent
