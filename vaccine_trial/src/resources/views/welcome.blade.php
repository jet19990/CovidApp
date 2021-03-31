<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('/images/logo/Logo.png')}}" type="image/x-icon">

        <title>Vaccine Trials</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background:linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.6)), url('/images/bg-min.jpg');
                background-size: cover;
                background-position: center;
                color: #f7f7f7;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
                /* background: #03033a87; */
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .home-nav{
                position: absolute;
                top: 0;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid rgba(102, 102, 102, 0.4);
                width:100%;
            }

            .top-right {
                margin-right: 20px;
            }

            .top-left {
                margin-left: 20px;     
            }
            .top-left img {
                margin-top: 10px;
                width: 100px;
                height: auto;
            }

            .divider{
               position: absolute;
               top: 80px;
               height: 1px;
               background: rgba(102, 102, 102, 0.4);
               width:100%;
            }


            .content {
                text-align: center;
            }

            .title {
                font-size: 65px;
                margin: 20px;
                font-weight: 100;
            }

            @media only screen and (max-width: 760px){
                .title {
                    font-size: 30px;
                }
            }

            .links > a {
                color: #f7f7f7;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .linkstop > a {
                color: #f7f7f7;
                font-size: 13px;
                padding: 0 25px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .btn {
                display: inline-block;
                padding: 9px 12px;
                padding-top: 7px;
                margin-bottom: 0;
                font-size: 14px;
                line-height: 20px;
                color: #5e5e5e;
                text-align: center;
                vertical-align: middle;
                cursor: pointer;
                background-color: #d1dade;
                -webkit-border-radius: 3px;
                -webkit-border-radius: 3px;
                -webkit-border-radius: 3px;
                background-image: none !important;
                border: none;
                text-shadow: none;
                box-shadow: none;
                transition: all 0.12s linear 0s !important;
                font: 14px/20px "Helvetica Neue",Helvetica,Arial,sans-serif;
            }

            .btn-info {
                color: #fff;
                background-color: #5bc0de;
                border-color: #46b8da;
                }

            .m-b-md {
                margin-bottom: 30px;
            }
            @media only screen and (max-width: 760px){
   
                .linkstop > a{
                    padding: 0 15px;
                }
           }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
        <div class="home-nav">
            <div class="top-left">
                <img src="{{asset('images/logo/Logo.png')}}" alt="">
            </div>
                @if (Route::has('login'))
                    <div class="top-right linkstop">
                        @auth
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
        </div>
            <!-- <div class="divider"></div> -->
            <div class="content">
                <div class="title m-b-md">
                The Valley of Shangri-La  Vaccine Administration
                </div>

                <div class="links">
                    <a href="/register" class="btn btn-info">Click Here To Get Started For Free</a>
                </div>
            </div>
        </div>
    </body>
</html>
