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

</head>

<body>
    <div class="container-fluid">
        <div class="creditCardForm">
            <div class="heading">
                <h1>Confirm Purchase</h1>
            </div>
            <div class="payment">
                <form>
                    <input type="hidden" name="stripe_id" id="stripe_id" value="{{ Auth::user()->customer_id }}">
                    <input type="hidden" name="package" id="package" value="{{ request('plan') ?? Auth::user()->package }}">
                    <div class="form-group owner">
                        <label for="owner">Owner</label>
                        <input type="text" class="form-control" id="owner">
                    </div>
                    <div class="form-group CVV">
                        <label for="cvv">CVV</label>
                        <input type="text" class="form-control" id="cvv">
                    </div>
                    <div class="form-group" id="card-number-field">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber">
                    </div>
                    <div class="form-group" id="expiration-date">
                        <label>Expiration Date</label>
                        <select id="mm">
                            <option value="01">January</option>
                            <option value="02">February </option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <select id="yy">
                            @for($i=16; $i<=40; $i++)
                                <option value="{{ $i }}"> 20{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group" id="credit_cards">
                        <img src="/payment-assets/images/visa.jpg" id="visa">
                        <img src="/payment-assets/images/mastercard.jpg" id="mastercard">
                        <img src="/payment-assets/images/amex.jpg" id="amex">
                    </div>
                    <div class="form-group" id="pay-now">
                        <button type="submit" class="btn btn-default" id="confirm-purchase">Confirm</button>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/payment-assets/js/jquery.payform.min.js" charset="utf-8"></script>
    <script src="/payment-assets/js/script.js"></script>
</body>

</html>