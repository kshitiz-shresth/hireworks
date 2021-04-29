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

    #logo{
        zoom:0.8;

    }

    #forgot{

        letter-spacing: 0px;
        color: #383838BC;
        font-weight:500;
        opacity:0.8;
        cursor:pointer;
    }


    .form-control {
        padding: 20px !important;
        width: 100%;
        border: 1px solid #707070;
        border-radius: 5px;
        height: 40px;
    }

    #sideDiv{
        padding:20px;
        height: 100%;
        text-align:center;
    }

    #welcomeNote{
        text-align: center!important;
        font-size: 35px;
        font-weight: 500;
        letter-spacing: 0px;
        color: #3C3C3C!important;
        margin-top:13%;
    }

    #slogan{
        text-align: center;
        font-size: 15px;
        font-weight: 500;
        letter-spacing: 0px;
        margin-bottom:5%;
    }

    #buttonSub {
        padding: 10px 40px 10px 40px;
        background: #FF3261 0% 0% no-repeat padding-box;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 15px;
        border: none;
        color: white;
        font-size:15px;
        font-weight:500;
    }

    #loginForm{
        text-align:center;
    }

    #firstDiv{
        border-right: 1px solid black;
        height: 100%;
        padding:20px;
    }

    #img02{
        margin-top:20%;
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
        margin-top:5%;
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
        margin-top:30%;
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
        margin-top: 35%;
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
        margin-top:10%;
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

    .alert .close, .alert .mailbox-attachment-close {
        color: #000;
        opacity:1;
    }

    #overlay {
        position: fixed; /* Sit on top of the page content */
        display: none; /* Hidden by default */
        width: 100%; /* Full width (cover the whole page) */
        height: 100%; /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.5); /* Black background with opacity */
        z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
        cursor: pointer; /* Add a pointer on hover */
        }

</style>


<div class="container-fluid" style="height:100%;position:relative;">
    <div class="row"  style="height:100%">
        <div class="col-md-8" id="firstDiv"  style="height:100% !important">
            <nav class="navbar navbar-expand-sm bg-transparent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                <a href="https://hireworks.us"> <img id="logo" src="{{ asset('logo.png') }}"   /></a>
                    </li>
                </ul>
            </nav>

            <p id="welcomeNote">Welcome Back to HireWorks</p>

            <p id="slogan"><span style="color:#FF3261">Hire smarter</span>, not harder.</p>

            <div class="col-sm-12 col-sx-12 col-md-12 col-lg-4 col-lg-offset-4 col-md-8 col-md-offset-2">
            <form id="loginForm" action="{{ route('login') }}" id="loginform" method="post">
            <div class="form-group">
            <input  autocomplete="off" id="email" type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                    placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group">
                <input id="password" type="password" placeholder="{{ __('Password') }}"
                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                @endif
            </div>
            <a id="forgot" data-toggle="modal" data-target="#forgotPass">Forgot your password?</a><br /><br />
            <button type="submit" id="buttonSub">Login</button>

            </form>
            </div>
        </div>

        <div class="col-md-4" id="sideDiv">
            <img style="margin-top:30%;" id="img01" src="{{asset('assets/images/login/side_image.png') }}"></img>
            <img id="img02" src="{{ asset('assets/images/login/html.png') }}"></img>
            <img id="img03" src="{{ asset('assets/images/login/swift.png') }}"></img>
            <img id="img04" src="{{ asset('assets/images/login/backimg01.png') }}"></img>
            <img id="img05" src="{{ asset('assets/images/login/python.png') }}"></img>
            <img id="img06" src="{{ asset('assets/images/login/android.png') }}"></img>
            <p id="textReg"><b>Not a member yet ? &nbsp;<a  href="/register" style="color:#6bd1ef">  Join For Free.</a></b></p>
        </div>
    </div>
</div>

<div class="modal fade" id="forgotPass" tabindex="-1" role="dialog" style='margin-top:10%;'>
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-top:1px solid black;">
      <div class="modal-body">
        <form class="form-horizontal" method="post" id="recoverform"
                action="{{ route('password.email') }}">
                {{ csrf_field() }}


                @if (session('status'))

                    <div class="alert alert-success alert-dismissible" style="background-image:none !important;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:white!important;opacity:1 !important;margin-top:-5px;">&times;</a>
                    <a>{{ session('status') }} Please try again if you haven't received our email.</a>
                    </div>

                    <script>
                       $("#forgotPass").modal('show');
                    </script>

                @endif

                <div class="form-group ">
                    <div class="col-xs-12">
                        <h3>@lang('app.recoverPassword')</h3>
                        <p class="text-muted">@lang('app.enterEmailInstruction')</p>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-xs-12">
                        <input style="height:40px;" class="form-control" type="email" id="emaila" name="email" required=""
                            placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                </div>
                <br/>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light"
                                type="submit">@lang('app.sendPasswordLink')</button>
                    </div>
                </div>

                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-default imary btn-lg btn-block text-uppercase waves-effect waves-light"
                        data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>

      </div>

    </div>
  </div>
</div>


<script src="{{ asset('assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript">
    $('#forgot').on("click", function() {
       // $("#loginform").slideUp();
        $(".recoverform").fadeIn();
    });

    $(document).ready(function() {
        $("body").prepend('<div id="overlay" class="ui-widget-overlay" style="z-index: 999999; display: none;"></div>');
        $("body").prepend("<div id='PleaseWait' style='display: none;margin-top:20%;z-index: 9999999;opacity:10;margin-left:50%;position:fixed;'><img src='{{ asset('assets/hireworks_spinner.gif') }}'/></div>");
    });

    $('#recoverform').submit(function() {
        var pass = true;
        //some validations

        if(pass == false){
            return false;
        }
        $("#overlay, #PleaseWait").show();

        return true;
    });


</script>

</body>

</html>

