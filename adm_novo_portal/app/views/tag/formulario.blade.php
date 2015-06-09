@section('container')
	<div class="container col-md-8">
		<h2>Tag</h2>
		<br>
        @if(Session::get('tipo_alerta'))
            <div class="alert {{ Session::get('tipo_alerta') }}" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
				{{ Session::get('msg_alerta') }}
            </div>
    	@endif
		{{ Form::open(array('url' => 'salvar-tag', 'files' => true)) }}
            {{ Form::hidden('id', isset($tag) ? $tag->id : '') }}
			<div class="form-group {{ ($errors->first('tag')) ? 'has-error' : '' }}">
                {{ Form::label('tag', 'Tag*:', array('for' => 'tag', 'class' => 'control-label')) }}
                {{ Form::text('tag', isset($tag) ? $tag->tag : Input::old('tag'), array('class' => 'form-control')) }}
                @if ($errors->first('tag'))
                    <span class="help-block">{{ $errors->first('tag') }}</span>
                @endif
            </div>
            <div class="checkbox">
                <label>
                    {{ Form::checkbox('ativo', 'true', isset($tag) ? $tag->ativo : Input::old('ativo')) }} Ativo
                </label>
            </div>
            <br>
            {{ Form::submit(isset($tag) ? 'Salvar' : 'Inserir', array('class' => 'btn btn-primary pull-right')) }}
		{{ Form::close() }}
	</div>
@stop