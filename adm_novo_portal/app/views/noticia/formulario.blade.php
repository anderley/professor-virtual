@section('container')
	<div class="container col-md-8">
        <h2>Notícias</h2>
        <br>
        @if(Session::get('tipo_alerta'))
            <div class="alert {{ Session::get('tipo_alerta') }}" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                {{ Session::get('msg_alerta') }}
            </div>
        @endif
		{{ Form::open(array('url' => 'salvar-noticia', 'files' => true)) }}
            {{ Form::hidden('id', isset($noticia) ? $noticia->id : Input::old('id')) }}
			<div class="form-group {{ ($errors->first('titulo')) ? 'has-error' : '' }}">
                {{ Form::label('titulo', 'Título*:', array('for' => 'titulo', 'class' => 'control-label')) }}
                {{ Form::text('titulo', isset($noticia) ? $noticia->titulo : Input::old('titulo'), array('class' => 'form-control')) }}
                @if ($errors->first('titulo'))
                    <span class="help-block">{{ $errors->first('titulo') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('autor')) ? 'has-error' : '' }}">
                {{ Form::label('autor', 'Autor*:', array('for' => 'autor', 'class' => 'control-label')) }}
                {{ Form::text('autor', isset($noticia) ? $noticia->autor : Input::old('autor'), array('class' => 'form-control')) }}
                @if ($errors->first('autor'))
                    <span class="help-block">{{ $errors->first('autor') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('fonte')) ? 'has-error' : '' }}">
                {{ Form::label('fonte', 'Fonte:', array('for' => 'fonte', 'class' => 'control-label')) }}
                {{ Form::text('fonte', isset($noticia) ? $noticia->fonte : Input::old('fonte'), array('class' => 'form-control')) }}
                @if ($errors->first('fonte'))
                    <span class="help-block">{{ $errors->first('fonte') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('imagem')) ? 'has-error' : '' }}">
                {{ Form::label('imagem', 'Imagem:', array('for' => 'imagem', 'class' => 'control-label')) }}
                {{ Form::file('imagem', '', array('class' => 'form-control')) }}
                @if ($errors->first('imagem'))
                    <span class="help-block">{{ $errors->first('imagem') }}</span>
                @endif
                <br>
                @if (isset($noticia) && !is_null($noticia->imagem))
                    <div class="noticia-imagem">
                        <span id="excluirImagem" title="Excluir" url="{{ url('excluir-noticia-imagem', $noticia->id) }}">x</span>
                        <img class="img-thumbnail" src="{{ '/novo_portal/public'.$noticia->imagem }}"> 
                    </div>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('data_publicacao')) ? 'has-error' : '' }} clearfix">
                {{ Form::label('data_publicacao', 'Publicação (data):', array('for' => 'data_publicacao', 'class' => 'control-label')) }}
                <div class="input-append date" id="data" data-date="{{ isset($noticia) ? preg_replace('/(\d{4})-(\d{2})-(\d{2})\s*(.*)/i', '$3/$2/$1 $4', $noticia->data_publicacao) : (is_null(Input::old('data_publicacao')) ? date('d/m/Y') : Input::old('data_publicacao')) }}" data-date-format="dd/mm/yyyy">
                    {{ Form::text('data_publicacao', isset($noticia) ? preg_replace('/(\d{4})-(\d{2})-(\d{2})\s*(.*)/i', '$3/$2/$1 $4', $noticia->data_publicacao) : (is_null(Input::old('data_publicacao')) ? date('d/m/Y') : Input::old('data_publicacao')), array('class' => 'span2')) }}
                    <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
                @if ($errors->first('data_publicacao'))
                    <span class="help-block">{{ $errors->first('data_publicacao') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('link_referencia')) ? 'has-error' : '' }}">
                {{ Form::label('link_referencia', 'Referência (link):', array('for' => 'link_referencia', 'class' => 'control-label')) }}
                {{ Form::text('link_referencia', isset($noticia) ? $noticia->link_referencia : Input::old('link_referencia'), array('class' => 'form-control')) }}
                @if ($errors->first('link_referencia'))
                    <span class="help-block">{{ $errors->first('link_referencia') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('edital')) ? 'has-error' : '' }}">
                {{ Form::label('edital', 'Edital (pdf):', array('for' => 'edital', 'class' => 'control-label')) }}
                {{ Form::file('edital', '', array('class' => 'form-control')) }}
                @if ($errors->first('edital'))
                    <span class="help-block">{{ $errors->first('edital') }}</span>
                @endif
                <br>
                @if (isset($noticia) && !is_null($noticia->link_edital))
                    <div class="noticia-edital">
                        <span id="excluirEdital" title="Excluir" url="{{ url('excluir-noticia-edital', $noticia->id) }}">x</span>
                        <a href="{{ '/novo_portal/public'.$noticia->link_edital }}" target="blank">Edital de abertura de inscrições</a>
                    </div>
                @endif    
            </div>
            <div class="form-group {{ ($errors->first('tags')) ? 'has-error' : '' }}">
                {{ Form::label('tags', 'Tags:', array('for' => 'tags', 'class' => 'control-label')) }}
                {{ Form::text('tags', isset($tags) ? $tags : Input::old('tags'), array('class' => 'form-control', 'id' => 'tags')) }}
                @if ($errors->first('tags'))
                    <span class="help-block">{{ $errors->first('tags') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('texto')) ? 'has-error' : '' }}">
                {{ Form::label('texto', 'Texto*:', array('for' => 'texto', 'class' => 'control-label')) }}
                {{ Form::textarea('texto',isset($noticia) ? $noticia->texto : Input::old('texto'), array('class' => 'form-control', 'row' => '30')) }}
                @if ($errors->first('texto'))
                    <span class="help-block">{{ $errors->first('texto') }}</span>
                @endif
            </div>
            <br>
            {{ Form::submit(isset($noticia) ? 'Salvar' : 'Inserir', array('class' => 'btn btn-primary pull-right')) }}
		{{ Form::close() }}
	</div>
@stop