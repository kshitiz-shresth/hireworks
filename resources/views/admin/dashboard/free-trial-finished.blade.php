<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Credit Card Validation Demo</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/payment-assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/payment-assets/css/demo.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="container-fluid">
        <div class="creditCardForm">
            <div class="heading">
                <h1>Confirm Purchase</h1>
            </div>
            @if(session('unauthorized'))
            <div class="alert alert-danger">{{ session('unauthorized') }}</div>
            @endif
            <div class="payment">
                <form action="/admin/pay" method="GET">

                    <div class="form-group" id="expiration-date">
                        <label>Select Plan</label>
                        <select name="plan">
                            <option value="plus">Plus</option>
                            <option value="premium">Premium </option>
                        </select>
                    </div>
                    <div class="form-group" id="pay-now">
                        <button type="submit" class="btn btn-default" id="confirm-purchase">Confirm</button>
                    </div>
                </form>
            </div>
        </div>


    </div>

</body>

</html>
