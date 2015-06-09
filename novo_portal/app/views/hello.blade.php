@section('content')

<div class="container">
    
    @if(Session::get('tipo_alerta'))
        <div class="row">
            <div class="alert {{ Session::get('tipo_alerta') }}" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <p>{{ Session::get('msg_alerta') }}</p>
            </div>
        </div>
    @endif

    <div class="col-md-8">
        @foreach($noticias as $noticia)
            <div class="row">
                <div class="card-noticia">
                    <a href="{{ url('noticia', array('titulo' => str_replace(' ', '-', $noticia->titulo), 'id' => $noticia->id)) }}">
                        @if(!is_null($noticia->imagem)) <img src="{{ asset($noticia->imagem) }}"> @endif
                        <h3>{{ $noticia->titulo }}</h3>
                        <small>{{ preg_replace('/(\d{4})-(\d{2})-(\d{2})\s(.+)/i', '$3/$2/$1 $4', $noticia->data_publicacao) }}</small>
                        <p>{{ str_limit(preg_replace('/(<[^>]+>)/', '', $noticia->texto), 450) }} <span>continuar lendo</span></p>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="col-md-4 text-right">
        <div class="row">
            <img src="http://pagead2.googlesyndication.com/simgad/17890647429832031889" width="300"/>
        </div>
        <br>
        <div class="row">
            <div class="col-md-10 col-md-offset-2" style="padding-right: 0">
                <h4>Receba novas vagas por email</h4>
                <form>
                    <div class="form-group"><input class="form-control" type="text" name="nome" placeholder="Nome completo"></div>
                    <div class="form-group"><input class="form-control" type="email" name="email" placeholder="seu.email@email.com"></div>
                    <button class="btn btn-sm btn-primary" type="button">Receber</button>
                </form>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-10 col-md-offset-2" style="padding-right: 0">
                <h4>Vagas mais acessadas</h4>
                <div id="tab-noticias" role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#dia" aria-controls="dia" role="tab" data-toggle="tab">Dia</a></li>
                        <li role="presentation"><a href="#semana" aria-controls="semana" role="tab" data-toggle="tab">Semana</a></li>
                        <li role="presentation"><a href="#mes" aria-controls="mes" role="tab" data-toggle="tab">Mês</a></li>
                    </ul>
                    <div class="tab-content" style="padding-top: 20px">
                        <div role="tabpanel" class="tab-pane active" id="dia">
                            @foreach($noticias as $noticia)
                                <div class="row">
                                    <div class="card-noticia-mais-acessadas">
                                        <a href="{{ url('noticia', array('titulo' => str_replace(' ', '-', $noticia->titulo), 'id' => $noticia->id)) }}">
                                            @if(!is_null($noticia->imagem)) <img src="{{ asset($noticia->imagem) }}" height="36"> @endif
                                            <p class="clearfix text-left">{{ $noticia->titulo }}</p>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div role="tabpanel" class="tab-pane" id="semana">
                        </div>
                        <div role="tabpanel" class="tab-pane" id="mes"></div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <h4>Apostilas</h4>
            <div class="col-md-offset-2" style="padding-right: 0">
                <ul id="flexiselDemo3">
                    @foreach($apostilas as $apostila)
                        <li><img src="{{ asset($apostila->imagem) }}" ></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="fb-like-box" data-href="https://www.facebook.com/pages/Professor-Virtual/133121016759573" data-width="300" data-height="400" data-show-faces="true" data-colorscheme="dark" data-stream="false" data-header="false" data-border-color="#292526"></div>
        </div>
    </div>

</div>

@stop