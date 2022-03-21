This is your purchase: <br>
@php
    $total = 0;
@endphp
<table>
    <tr>
        <th style="width: 70%;">Product</th>
        <th style="width: 10%;">Unit Price</th>
        <th style="width: 10%;">Quantity</th>
        <th style="width: 10%;">Subtotal</th>
    </tr>
    @foreach($cartProducts as $product)
        <tr>
            <td>{{ $product->title }}</td>
            <td>$ {{ number_format($product->price, 2, '.', ',') }}</td>
            <td>{{ number_format($product->quantity, 2, '.', ',') }}</td>
            <td>$ {{ number_format($product->price * $product->quantity, 2, '.', ',') }}</td>
        </tr>
        @php
            $total += $product->price * $product->quantity;
        @endphp
    @endforeach
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" style="font-weight: bold;">TOTAL:</td>
        <td>$ {{ number_format($total, 2, '.', ',') }}</td>
    </tr>
</table>
