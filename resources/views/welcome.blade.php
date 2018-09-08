<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MyFinancial</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">

        <!-- bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <style>
            html, body {
                background-color: #E3F2FD;             
                font-family: 'Roboto Condensed', sans-serif;
                margin: 0;
            }

            .title {
                margin-top: 50px; 
                font-size: 60px; 
                font-style: bolder;
            }

            .subtitle {
                margin-top: 10px; 
                font-size: 24px; 
                font-style: bolder;
            }

            
        </style>

         <!-- Styles -->
        <!--
        <style>
            html, body {
                background-color: #E3F2FD;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 48vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 24px;
                font-style: bolder;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-sm {
                margin-bottom: 30px;
            }

            .subtitle {
                font-size: 18px;
                font-style: bolder;
            }

        </style>
    -->
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="col-sm text-center">
                
                <h1 class="col-sm title" >MyFinancial</h1>
                <h3 class="col-sm subtitle">Gerencie seus gastos de forma simples!</h3>

                <div class="row">             
                    <div class="col-sm"></div>
                    <div class="col-sm">    
                         @if (Route::has('login')) 
                            @auth
                                 <a href="{{ url('/home') }}" class="btn btn-block btn-primary">Ir para a Dashboard</a> 
                            @else
                                 <a href="{{ route('login') }}" class="btn btn-block btn-success" style="margin-top: 10px;">Entrar</a> 
                                 <br>
                                 <p>Não possui uma conta? Cadastre-se agora!</p>
                                 <a href="{{ route('register') }}" class="btn btn-block btn-primary">Cadastre-se</a>
                            @endauth
                         @endif 
                    </div>
                    <div class="col-sm"></div>
                </div>
                
            </div>
        </div>
    </body>
</html>
