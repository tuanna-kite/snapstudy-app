<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<input type="number" value="1">
<form action="{{route('paypal.payment')}}" method="post">
    @csrf
    <input type="hidden" value="10" name="price">
    <button>
        Buy now
    </button>
</form>
</body>
</html>