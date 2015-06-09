<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adm novo portal</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
          {{ HTML::style('css/main-theme.css') }}
          {{ HTML::style('css/jquery-ui.min.css') }}
          {{ HTML::style('css/jquery-ui.structure.min.css') }}
          {{ HTML::style('css/jquery-ui.theme.min.css') }}
          {{ HTML::style('css/jquery.wysiwyg.css') }}
          {{ HTML::style('css/datepicker.css') }}
          {{ HTML::style('css/datepicker3.css') }}
      </head>
      <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Novo portal</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="{{{ $tagAtiva or '' }}}"><a href="{{ url('tags') }}">Tags</a></li>
                        <li class="{{{ $noticiaAtiva or '' }}}"><a href="{{ url('noticias') }}">Notícias</a></li>
                        <li class="{{{ $videoAtiva or '' }}}"><a href="{{ url('videos') }}">Videos</a></li>
                        <li class="{{{ $apostilaAtiva or '' }}}"><a href="{{ url('apostilas') }}">Apostilas</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Importar <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('importar-apostilas-opcao') }}">Apostilas Opção</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container">
            <div class="starter-template">
                @yield('container')
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        {{ HTML::script('js/jquery-ui.min.js') }}
        {{ HTML::script('js/jquery.wysiwyg.js') }}
        {{ HTML::script('js/bootstrap-datepicker.js') }}
        {{ HTML::script('js/locales/bootstrap-datepicker.pt-BR.js') }}
        {{ HTML::script('js/jquery.maskMoney.min.js') }}
        <script type="text/javascript">
            $(document).ready(function(){
                $('textarea').wysiwyg();
                $('#data').datepicker({
                    language: 'pt-BR',
                    autoclose: true,
                    orientation: 'top left'
                }); 
                $('#data2').datepicker({
                    language: 'pt-BR',
                    autoclose: true,
                    orientation: 'top left'
                }); 
                $(".currency").maskMoney({
                    prefix:'R$ ',
                    allowNegative: true,
                    thousands:'.',
                    decimal:',',
                    affixesStay: false});
                $("#proximaPaginaApostila").click(function(e) {
                    e.preventDefault();
                    var numPagina = $(this).attr('href').replace(/\D+/, '');
                    var self = this;
                    var url = "{{ url('pagina-apostila') }}/" + numPagina;
                    var filter = $('#filter').val();
                    if (filter && filter.trim().length > 0) { url +=  "/" + filter; }
                    console.log(filter.trim().length);
                    $.getJSON(url, function (data) {
                        $(self).attr('href', '#' + data.num_pagina);
                        $.each(data.apostilas, function(key, apostila) {
                            var tr = "<tr><td>" + apostila.id + "</td><td>" + apostila.titulo + "</td><td>" + apostila.cargo + "</td>" +
                            "<td>" + apostila.criacao.replace(/(\d{4})-(\d{2})-(\d{2})\s(.+)/g, '$3/$2/$1 $4') + "</td><td>" + (apostila.ativo === 1 ? 'Sim' : 'Não') + "</td>" +
                            "<td><a href='{{ url('excluir-apostila', " + apostila.id + ") }}' title='Excluir'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>" +
                            "<a href='{{ url('editar-apostila', " + apostila.id + ") }}' title='Editar'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td></tr>";
                            $(self).parents('tr').before(tr);  
                        });
                        if (data.num_pagina >= data.total_paginas) {
                            $(self).parents('tr').remove();
                        }
                    });
                });
            });
            $(function () {
                function split(val) {
                    return val.split(/,\s*/);
                }
                function extractLast(term) {
                    return split(term).pop();
                }
                var availableTags = [];
                $.getJSON('{{ url('ajax/tags.json') }}', function (data) {
                    availableTags = [];
                    $.each(data, function (key, item) {
                        availableTags.push(item.tag);
                    });
                });
                $("#tags").bind("keydown", function(event) {
                    if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
                        event.preventDefault();
                    }
                }).autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        response($.ui.autocomplete.filter(availableTags, extractLast(request.term)));
                    },
                    focus: function() {
                        return false;
                    },
                    select: function(event, ui) {
                        var terms = split(this.value);
                        terms.pop();
                        terms.push(ui.item.value);
                        terms.push("");
                        this.value = terms.join(", ");
                        return false;
                    }
                });
                $(':input').on('keydown', function(e){
                    if(e.keyCode==13){
                        e.preventDefault();
                    }
                });
                $('#filtro-noticias').change(function(){
                    $('#etiquetas').hide();
                    $('#publicacao-inicio').hide();
                    $('#publicacao-fim').hide();
                    $('#filtro-input').hide();
                    switch($(this).val()){
                        case "etiquetas":
                            $('#etiquetas').show();
                            break;
                        case "publicacao":
                            $('#publicacao-inicio').show();
                            $('#publicacao-fim').show();
                            break;
                        default:
                            $('#filtro-input').show();
                    }
                });
                $("a[title|='Excluir']").click(function(e){
                    var cofirmacao = confirm("Deseja realmente excluir este registro?");
                    if(!cofirmacao){
                        e.preventDefault();
                    }
                });
                $('#excluirImagem').click(function(e){
                    var excluir = confirm("Deseja realmente excluir esta imagem.");
                    if(excluir){
                        $.get($(this).attr('url'), function(data){
                            $('.noticia-imagem').remove();
                        });
                    } 
                });
                $('#excluirEdital').click(function(e){
                    var excluir = confirm("Deseja realmente excluir este edital.");
                    if(excluir){
                        $.get($(this).attr('url'), function(data){
                            $('.noticia-edital').remove();
                        });
                    } 
                });
            });
        </script>
    </body>
</html>
