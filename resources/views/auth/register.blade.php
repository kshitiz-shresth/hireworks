<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <title>HireWorks</title>

    <style>
        :root {
            --main-color: {{ $frontTheme->primary_color }};
        }

    </style>
    <link href="{{ asset('assets/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/iCheck/square/blue.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>

<body>

<style>
    html,body{
        background: #FFFFFF 0% 0% no-repeat padding-box !important;
        font-family: "Poppins";
        font-style: normal;
        height: 100% !important;
    }

    .form-control {
        padding: 20px !important;
        width: 100%;
        border: 1px solid #707070;
        border-radius: 5px;
        height: 40px;
    }

    #noofEmp{
        width: 100%;
        height:40px;
        padding: 10px;
        border-radius:5px;
    }

    #registerForm{
        text-align:center;
    }

    #logo{
        zoom:0.8;
    }

    #welcomeNote{
        text-align: center;
        font-size: 35px;
        font-weight: 500;
        letter-spacing: 0px;
    }

    #slogan{
        text-align: center;
        font-size: 15px;
        font-weight: 500;
        letter-spacing: 0px;
    }

    #sideDiv{
        padding:25px;
        height: 100%;
    }

    #firstDiv{
        border-left: 1px solid black;
        height: 100%;
        padding-bottom:20px;
    }

    #buttonSub {
        padding: 10px 20px 10px 20px;
        background: #FF3261 0% 0% no-repeat padding-box;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 15px;
        border: none;
        color: white;
        font-size:14px;
    }

    #img02{
        margin-top:10%;
        width: 40px;
        height: 40px;
        position:fixed;
        -webkit-transform-origin: 100% 50%;
        -webkit-animation: img02 5s both ease-in;
        animation-iteration-count:infinite;
    }
    @-webkit-keyframes img02 {
        0% {
                -webkit-transform: translateX(0px);
        }
        50% {
                -webkit-transform: translateY(50px);

        }
    }


    #img03{
        margin-top:1%;
        margin-left:-20%;
        width: 40px;
        height: 40px;
        transform: matrix(0.99, 0.14, -0.14, 0.99, 0, 0);
        position:fixed;
        -webkit-transform-origin: 100% 50%;
        -webkit-animation: img03 5s both ease-in;
        animation-iteration-count:infinite;
    }

    @-webkit-keyframes img03 {
        0% {
                -webkit-transform: translateY(20px);
        }
        50% {
                -webkit-transform: translateX(50px);
        }

        100% {
                -webkit-transform: translateY(20px);
        }
    }

    #img04{
        margin-top:20%;
        margin-left:-25%;
        width: 40px;
        height: 40px;
        position:fixed;
        -webkit-transform-origin: 100% 50%;
        -webkit-animation: img04 5s both ease-in;
        animation-iteration-count:infinite;
    }

    @-webkit-keyframes img04 {
        0% {
                -webkit-transform: translateY(0px);
        }
        50% {
                -webkit-transform: translateY(40px);
        }

    }

    #img05{
        margin-top: 30%;
        margin-left:-5%;
        width: 40px;
        height: 40px;
        transform: matrix(0.98, 0.17, -0.17, 0.98, 0, 0)  !important;
        position:fixed;
        -webkit-transform-origin: 100% 50%;
        -webkit-animation: img05 5s both ease-in;
        animation-iteration-count:infinite;
    }

    @-webkit-keyframes img05 {
        0% {
                -webkit-transform: translateY(0px);
        }
        50% {
                -webkit-transform: translateX(-80px);
        }

    }


    #img06{
        width: 40px;
        height: 40px;
        transform: matrix(0.44, 0.9, -0.9, 0.44, 0, 0);
        position:fixed;
        opacity: 0.6;
        -webkit-transform-origin: 100% 50%;
        -webkit-animation: img06 5s both ease-in;
        animation-iteration-count:infinite;
    }

    @-webkit-keyframes img06 {
        0% {
                -webkit-transform: translateY(0px);
        }
        50% {
                -webkit-transform: translateX(-80px);
        }

    }

</style>


<div class="container-fluid" style="height:100% !important">
<div class="row" style="height:100% !important">
    <div class="col-md-4 hidden-xs hidden-sm" id="sideDiv">
          <nav class="navbar navbar-expand-sm bg-transparent">
            <ul class="navbar-nav">
                <li class="nav-item">
                        <a href="https://hireworks.us" style="cursor:pointer"><img href="https://hireworks.us" id="logo" src="{{ asset('logo.png') }}"   /></a>
                </li>
            </ul>
        </nav>
        <img style="margin-top:20%" id="img01" src="{{asset('assets/images/login/side_image.png') }}"></img>
        <img id="img02" src="{{ asset('assets/images/login/html.png') }}"></img>
        <img id="img03" src="{{ asset('assets/images/login/swift.png') }}"></img>
        <img id="img04" src="{{ asset('assets/images/login/backimg01.png') }}"></img>
        <img id="img05" src="{{ asset('assets/images/login/python.png') }}"></img>
        <img id="img06" src="{{ asset('assets/images/login/android.png') }}"></img>

        <p style="text-align:center" id="signinTxt"><b>Have an Account? <a href="/login" style="color:#00AFE4">Sign in</a></b></p>
    </div>

    <div class="col-md-8" id="firstDiv" style="height:100% !important">
    <br /><br />
        <p id="welcomeNote">Start Your Free Trial</p>
        <p id="slogan"><span style="color:#FF3261">Hire smarter</span>, not harder.</p>
        <br /><br />
        <div class="col-sm-12 col-sx-12 col-md-12 col-lg-4 col-lg-offset-4 col-md-8 col-md-offset-2">
        <form id="registerForm" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
            <input autocomplete="off" placeholder="Full Name" id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
            </div>

            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif

            <div class="form-group">
            <input autocomplete="off" placeholder="Company Name" id="companyname" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="companyname" value="{{ old('name') }}" required>
            </div>

            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif

            <div class="form-group">
            <input autocomplete="off" id="email" placeholder="Company Email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
            </div>

            @if ($errors->has('email'))
                <span class="invalid-feedbacke">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

            <div class="form-group">
            <input autocomplete="off" placeholder="Company Website" type="text" required class="form-control" id="website" name="website" required>
            </div>

            <div class="form-group">
            <select id="noofEmp" name="package" required>
                <option value="-1">Select Package</option>
                <option value="free">Free</option>
                <option value="plus">Plus</option>
                <option value="premium">Premium</option>
            </select>
            </div>


            <div class="form-group">
            <input autocomplete="off" placeholder="Password" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            </div>

            @if ($errors->has('password'))
                <span class="invalid-feedbacks">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif


            <div class="form-group">
            <input autocomplete="off" placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <div class="form-group">
            <input id="agree" type="checkbox" required class="pull-left"/>
            </div>

            <p id="agreeTxt">I agree to the <a target="_blank" href="http://hireworks.us/privacy-policy/">privacy policy and terms and conditions</a></p>


            <button id="buttonSub" type="submit" class="btn btn-primary">
              Get Started
            </button>

        </form>

        </div>
    </div>

</div>
</div>


<script src="{{ asset('assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        // $(".preloader").fadeOut();
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
</script>

</body>

</html>

