@section('container')
	<br>
	@if(Session::get('tipo_alerta'))
        <div class="alert {{ Session::get('tipo_alerta') }}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('msg_alerta') }}
        </div>
	@endif
	<div class="container">
		{{ Form::open(array('url' => 'videos', 'class' => 'form-inline')) }}
			<div class="form-group">
                {{ Form::label('filtro', 'Filtar por:', array('for' => 'filtro', 'class' => 'control-label')) }}
                {{ Form::select('filtro', array('etiquetas' => 'Etiquetas', 'titulo' => 'Título'), Input::old('filtro'), array('id' => 'filtro-noticias', 'class' => 'form-control')) }}
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
        	<a href="{{ url('incluir-video') }}" class="btn btn-primary pull-right">Incluir</a>
		{{ Form::close() }}
	</div>
	<br>
	<table class="table table-striped">
		<tr>
			<th>#</th>
			<th>Título</th>
			<th>Criação ^</th>
			<th>Ativo</th>
			<th></th>
		</tr>
        @foreach ($videos as $video)
        <tr>
            <td>{{ $video->id }}</td>
            <td>{{ $video->titulo }}</td>
            <td>{{ preg_replace('/(\d{4})-(\d{2})-(\d{2})\s(.+)/i', '$3/$2/$1 $4', $video->criacao) }}</td>
            <td>{{ $video->ativo ? 'Sim' : 'Não' }}</td>
            <td>
                <a href="{{ url('excluir-video', $video->id) }}" title="Excluir"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                <a href="{{ url('editar-video', $video->id) }}" title="Editar"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
            </td>
        </tr>
        @endforeach
        @if($videos->isEmpty())
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5" style="text-align:center">Não foi encontrado videos</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
        @endif
    </table>
@stop