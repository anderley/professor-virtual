@section('container')
	<div class="container"><a href="{{ url('incluir-tag') }}" class="btn btn-primary pull-right">Incluir</a></div>
	<br>
    @if(Session::get('tipo_alerta'))
        <div class="alert {{ Session::get('tipo_alerta') }}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('msg_alerta') }}
        </div>
	@endif
	<table class="table table-striped">
		<tr>
			<th>#</th>
			<th>Tag</th>
			<th>Criação ^</th>
			<th>Ativo</th>
			<th></th>
		</tr>
		@foreach ($tags as $tag)
		<tr>
			<td>{{ $tag->id }}</td>
			<td>{{ $tag->tag }}</td>
			<td>{{ preg_replace('/(\d{4})-(\d{2})-(\d{2})\s(.+)/i', '$3/$2/$1 $4', $tag->criacao) }}</td>
			<td>{{ $tag->ativo ? 'Sim' : 'Não' }}</td>
			<td>
				<a href="{{ url('excluir-tag', $tag->id) }}" title="Excluir"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
				<a href="{{ url('editar-tag', $tag->id) }}" title="Editar"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
			</td>
		</tr>
		@endforeach
		@if($tags->isEmpty())
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr><td colspan="5" style="text-align:center">Não foi encontrada tags</td></tr>
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr><td colspan="5">&nbsp;</td></tr>
		@endif
	</table>
@stop