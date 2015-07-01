@section('content')

<div class="container">
    <div class="col-md-8">
        <div class="row">
            <div class="panel-noticia">
                <img src="http://pagead2.googlesyndication.com/simgad/1875247006244268172" width="300">
                <h3>{{ $noticia->titulo }}</h3>
                <small>{{ preg_replace('/(\d{4})-(\d{2})-(\d{2})\s(.+)/i', '$3/$2/$1 $4', $noticia->criacao) }}</small>
                <p>{{ $noticia->texto }}</p>
                <p class="pull-right">
                    @if(!is_null($noticia->autor)) autor: {{ $noticia->autor }}<br> @endif
                    @if(!is_null($noticia->fonte)) fonte: {{ $noticia->fonte }}<br> @endif
                    @if(!is_null($noticia->link_referencia)) referência: {{ $noticia->link_referencia }}<br> @endif
                </p>
            </div>
        </div>
        @if(!$apostilas->isEmpty())
            <div class="row">
                <h4>Apostilas</h4>
                <ul class="list-inline">
                    @foreach($apostilas as $apostila)
                        <li>
                            <a href="{{ $apostila->link_parceiro }}">
                                <h5>{{ $apostila->titulo }}</h5>
                                <h5>{{ $apostila->cargo }}</h5>
                                <img src="{{ $apostila->imagem }}"><br>
                                <br>
                                <label>Valor apostila impressa R$ {{ number_format($apostila->valor_impresso, 2, ',', '.') }}</label>
                                @if(!is_null($apostila->valor_digital))
                                    <br>
                                    <label>Valor apostila impressa R$ {{ number_format($apostila->valor_digital, 2, ',', '.') }}</label>
                                @endif
                                <br>
                                <a class="btn btn-success" href="{{ $apostila->link_parceiro }}" target="blank">Comprar</a>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(!is_null($noticia->link_edital))
            <div class="row">
                <h4>Edital</h4>
                <a href="{{ url($noticia->link_edital) }}" target="blank"><img src="{{ asset('img/_pdf.gif') }}"/> Edital de abertura de inscrições</a>
            </div>
        @endif
        <br>
        <div class="row">
            <h4>Provas anteriores</h4>
            <ul class="list-unstyled">
                <li><a href="#"><img src="{{ asset('img/_pdf.gif') }}"/> 06/2014</a></li>
                <li><a href="#"><img src="{{ asset('img/_pdf.gif') }}"/> 01/2014</a></li>
                <li><a href="#"><img src="{{ asset('img/_pdf.gif') }}"/> 08/2013</a></li>
                <li><a href="#"><img src="{{ asset('img/_pdf.gif') }}"/> 01/2012</a></li>
                <li><a href="#"><img src="{{ asset('img/_pdf.gif') }}"/> 10/2011</a></li>
            </ul>
        </div>
        <br>
        @if(!$videos->isEmpty())
            <div class="row">
                <h4>Videos relacionados</h4>
                <ul class="list-unstyled">
                @foreach($videos as $video)
                    <li>
                        <h5>{{ $video->titulo }}</h5>
                        {{ $video->embedded }}
                    </li>
                @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="col-md-4 text-right">
        <div class="row">
            <img src="http://pagead2.googlesyndication.com/simgad/17890647429832031889" width="300"/>
        </div>
        <br>
        <div class="row">
            <div class="fb-like-box" data-href="https://www.facebook.com/pages/Professor-Virtual/133121016759573" data-width="300" data-height="400" data-show-faces="true" data-colorscheme="dark" data-stream="false" data-header="false" data-border-color="#292526"></div>
        </div>
    </div>
</div>

@stop