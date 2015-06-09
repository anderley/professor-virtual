<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Professor Virtual - Arrase nos concursos!</title>

    <!-- CSS -->
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/bootstrap-theme.min.css') }}
    {{ HTML::style('css/styles.css') }}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '1621934994684546',
                status     : true,
                cookie     : true,
                xfbml      : true,
                version    : 'v2.2'
            });
        };
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/pt_BR/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        </script>
    
    <div class="container">
        <div class="top row">  
            <img class="pull-left" src="{{ asset('img/prof.png') }}" height="60">

            <div class="col-md-6 pull-right text-right">
                @if (Auth::check())
                    <p>Olá {{ Auth::user()->nome }} <a href="{{ url('logout') }}">sair</a> | <a href="{{ url('minha-conta') }}">Minha conta</a></p>
                @else
                    <p>Olá visitante, <a href="{{ url('login') }}">identifique-se aqui</a></p>
                @endif
            </div>

        </div>

        <div class="row">
            <div class="container-fluid menu-bar">
                <div class="col-md-8">
                    <ul class="list-inline">
                        <li class="{{ (isset($active) && $active == 'home') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                        <li class="{{ (isset($active) && $active == 'apostilas') ? 'active' : '' }}"><a href="#">Apostilas</a></li>
                        <li class="{{ (isset($active) && $active == 'concursos') ? 'active' : '' }}"><a href="#">Próximos concursos</a></li>
                        <li class="{{ (isset($active) && $active == 'questoes') ? 'active' : '' }}"><a href="#">Banco de questões</a></li>
                        <li class="{{ (isset($active) && $active == 'videos') ? 'active' : '' }}"><a href="#">Videos</a></li>
                        <li class="{{ (isset($active) && $active == 'provas') ? 'active' : '' }}"><a href="#">Provas</a></li>
                    </ul>
                </div>
                <form class="navbar-form pull-right" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" placeholder="Palavra chave">
                        <span class="input-group-btn">
                            <button class="btn btn-danger btn-sm" type="submit">
                                <span class="glyphicon glyphicon-search" title="Buscar"></span>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">

            @yield('breadcrumb')

        </div>

        <div class="row">
            
            @yield('content')

        </div>

        <div class="row footer">
            <div class="container-fluid">
                <ul class="col-md-3 list-unstyled">
                    <li><h5>INSTITUCIONAL</h5></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                </ul>
                <ul class="col-md-3 list-unstyled">
                    <li><h5>INSTITUCIONAL</h5></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                </ul>
                <ul class="col-md-3 list-unstyled">
                    <li><h5>INSTITUCIONAL</h5></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                    <li><a href="#">Que somos</a></li>
                </ul>
            </div>
        </div>

    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {{ HTML::script('js/bootstrap.min.js') }}
    <!-- Plugin para gerar mascaras nos campos -->
    {{ HTML::script('js/jquery.mask.min.js') }}
    <!-- Plugin para carousel -->
    {{ HTML::script('js/jquery.flexisel.js') }}

    <script type="text/javascript">
        $('#data').mask('00/00/0000', {placeholder: '__/__/____'});
        $('#tel').mask('(00) 0000-0000', {placeholder: '(__) ____-____'});
        $('#cel').mask('(00) 00000-0000', {placeholder: '(__) _____-____'});
        $('#cep').mask('00000-000', {placeholder: '_____-___'});
        (function(){
            $('#cep').blur(function(){
                $(this).after('<p id="loadCep">Localizando endereço...</p>');
                var urlCep = "http://viacep.com.br/ws/" + $(this).val() + "/json/";
                $.getJSON(urlCep).done(function(endereco){
                    $('#logradouro').val(endereco.logradouro);
                    $('#bairro').val(endereco.bairro);
                    $('#cidade').val(endereco.localidade);
                    $('#estado').val(endereco.uf);
                    $('#ibge').val(endereco.ibge);
                    $('#loadCep').remove();
                });
            });
        })();
        $(document).ready(function(){
            $('#tab-noticias a').click(function(e){
                e.preventDefault();
                $(this).tab('show');
            });
            $("#flexiselDemo3").flexisel({
                visibleItems: 3,
                animationSpeed: 1000,
                autoPlay: true,
                autoPlaySpeed: 3000,
                pauseOnHover: true,
                enableResponsiveBreakpoints: true,
                responsiveBreakpoints: {
                    portrait: { 
                        changePoint:480,
                        visibleItems: 1
                    },
                    landscape: { 
                        changePoint:640,
                        visibleItems: 2
                    },
                    tablet: { 
                        changePoint:768,
                        visibleItems: 3
                    }
                }
            });
        });
    </script>
</body>
</html