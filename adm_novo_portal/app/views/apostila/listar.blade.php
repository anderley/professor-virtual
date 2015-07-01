@section('container')
	<br>
    @if(Session::get('tipo_alerta'))
        <div class="alert {{ Session::get('tipo_alerta') }}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('msg_alerta') }}
        </div>
	@endif
	<div class="container">
		{{ Form::open(array('url' => 'apostilas', 'class' => 'form-inline')) }}
			<div class="form-group">
                {{ Form::label('filtro', 'Filtar por:', array('for' => 'filtro', 'class' => 'control-label')) }}
                {{ Form::select('filtro', array('cargo' => 'Cargo', 'etiquetas' => 'Etiquetas', 'titulo' => 'Título'), Input::old('filtro'), array('id' => 'filtro-noticias', 'class' => 'form-control')) }}
            </div>
            <div id="etiquetas" class="form-group">
                {{ Form::text('etiquetas', Input::old('etiquetas'), array('class' => 'form-control', 'id' => 'tags')) }}
            </div>
            <div id="filtro-input" class="form-group" style="display:none">
                {{ Form::text('filtro_valor', Input::old('filtro'), array('class' => 'form-control')) }}
            </div>
        	<button class="btn btn-success" type="submit">
        		<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
        	</button>
        	<a href="{{ url('incluir-apostila') }}" class="btn btn-primary pull-right">Incluir</a>
		{{ Form::close() }}
		<br>
		<table class="table table-striped">
			<tr>
				<th>#</th>
				<th>Título</th>
				<th>Cargo</th>
				<th width="15%">Criação ^</th>
				<th>Ativo</th>
				<th width="10%"></th>
			</tr>
			@foreach ($apostilas as $apostila)
			<tr>
				<td>{{ $apostila->id }}</td>
				<td>{{ $apostila->titulo }}</td>
				<td>{{ $apostila->cargo }}</td>
				<td>{{ preg_replace('/(\d{4})-(\d{2})-(\d{2})\s(.+)/i', '$3/$2/$1 $4', $apostila->criacao) }}</td>
				<td>{{ $apostila->ativo ? 'Sim' : 'Não' }}</td>
				<td>
					<a href="{{ url('excluir-apostila', $apostila->id) }}" title="Excluir"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					<a href="{{ url('editar-apostila', $apostila->id) }}" title="Editar"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
				</td>
			</tr>
			@endforeach
			@if($num_pagina < $total_paginas)
				<tr><td class="text-center" colspan="6"><a id="proximaPaginaApostila" href="#{{ $num_pagina }}">Exibir mais...</a></td></tr>
			@endif	
			@if($apostilas->isEmpty())
				<tr><td colspan="6">&nbsp;</td></tr>
				<tr><td colspan="6" style="text-align:center">Não foi encontrada apostilas</td></tr>
				<tr><td colspan="6">&nbsp;</td></tr>
				<tr><td colspan="6">&nbsp;</td></tr>
			@endif
			<input id="filter" type="hidden" name="filter" value="{{ $filter }}">
		</table>
		</div>
@stop