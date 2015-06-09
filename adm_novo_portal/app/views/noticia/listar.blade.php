@section('container')
	<br>
	@if(Session::get('tipo_alerta'))
        <div class="alert {{ Session::get('tipo_alerta') }}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('msg_alerta') }}
        </div>
	@endif
	<div class="container">
		{{ Form::open(array('url' => 'noticias', 'class' => 'form-inline')) }}
			<div class="form-group">
                {{ Form::label('filtro', 'Filtar por:', array('for' => 'filtro', 'class' => 'control-label')) }}
                {{ Form::select('filtro', array('autor' => 'Autor', 'publicacao' => 'Publicação', 'etiquetas' => 'Etiquetas', 'titulo' => 'Título'), Input::old('filtro'), array('id' => 'filtro-noticias', 'class' => 'form-control')) }}
            </div>
            <div id="filtro-input" class="form-group">
                {{ Form::text('filtro_valor', Input::old('filtro'), array('class' => 'form-control')) }}
            </div>
            <div id="etiquetas" class="form-group" style="display:none">
                {{ Form::text('etiquetas', Input::old('etiquetas'), array('class' => 'form-control', 'id' => 'tags')) }}
            </div>
            <div id="publicacao-inicio" class="form-group" style="display:none">
                <div class="input-append date" id="data" data-date="{{ is_null(Input::old('publicacao_inicio')) ? date('d-m-Y') : Input::old('publicacao_inicio') }}" data-date-format="dd/mm/yyyy">
                    {{ Form::label('de', 'De:', array('for' => 'de', 'class' => 'control-label')) }}
                	{{ Form::text('publicacao_inicio', is_null(Input::old('publicacao_inicio')) ? date('d/m/Y') : Input::old('publicacao_inicio'), array('class' => 'form-control')) }}
                    <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>
            <div id="publicacao-fim" class="form-group" style="display:none">
            	<div class="input-append date" id="data2" data-date="{{ is_null(Input::old('publicacao_fim')) ? date('d-m-Y') : Input::old('publicacao_fim') }}" data-date-format="dd/mm/yyyy">
                    {{ Form::label('ate', 'Até:', array('for' => 'ate', 'class' => 'control-label')) }}
                	{{ Form::text('publicacao_fim', is_null(Input::old('publicacao_fim')) ? date('d/m/Y') : Input::old('publicacao_fim'), array('class' => 'form-control')) }}
                    <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>
        	<button class="btn btn-success" type="submit">
        		<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
        	</button>
        	<a href="{{ url('incluir-noticia') }}" class="btn btn-primary pull-right">Incluir</a>
		{{ Form::close() }}
	</div>
	<br>
	<table class="table table-striped">
		<tr>
			<th>#</th>
			<th>Título</th>
			<th>Publicacao ^</th>
			<th>Autor</th>
			<th></th>
		</tr>
		@foreach ($noticias as $noticia)
		<tr>
			<td>{{ $noticia->id }}</td>
			<td>{{ $noticia->titulo }}</td>
			<td>{{ preg_replace('/(\d{4})-(\d{2})-(\d{2})\s(.+)/i', '$3/$2/$1 $4', $noticia->data_publicacao) }}</td>
			<td>{{ $noticia->autor }}</td>
			<td>
				<a href="{{ url('excluir-noticia', $noticia->id) }}" title="Excluir"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
				<a href="{{ url('editar-noticia', $noticia->id) }}" title="Editar"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
			</td>
		</tr>
		@endforeach
		@if($noticias->isEmpty())
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr><td colspan="5" style="text-align:center">Não foi encontrada notícias</td></tr>
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr><td colspan="5">&nbsp;</td></tr>
		@endif
	</table>
@stop