<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Stripe Full Flow</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="antialiased" style="display: flex:1; gap:2rem">
    @foreach($products as $product)
        <div class="text-center; display:flex; gap:3rem">
            <img src="{{$product->image}}" style="max-width:100%"></img>
            <h5>{{$product->name}}</h5>
            <p>{{$product->price}}</p>
            @endforeach

            <p>
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf

        <button>Checkout</button>



                </form>


            </p>
</div>
</body>