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
		{{ Form::open(array('url' => 'salvar-video', 'files' => true)) }}
            {{ Form::hidden('id', isset($video) ? $video->id : '') }}
			<div class="form-group {{ ($errors->first('tag')) ? 'has-error' : '' }}">
                {{ Form::label('titulo', 'Título*:', array('for' => 'titulo', 'class' => 'control-label')) }}
                {{ Form::text('titulo', isset($video) ? $video->titulo : Input::old('titulo'), array('class' => 'form-control')) }}
                @if ($errors->first('titulo'))
                    <span class="help-block">{{ $errors->first('titulo') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('tags')) ? 'has-error' : '' }}">
                {{ Form::label('tags', 'Tags:', array('for' => 'tags', 'class' => 'control-label')) }}
                {{ Form::text('tags', isset($tags) ? $tags : Input::old('tags'), array('class' => 'form-control', 'id' => 'tags')) }}
                @if ($errors->first('tags'))
                    <span class="help-block">{{ $errors->first('tags') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('tag')) ? 'has-error' : '' }}">
                {{ Form::label('embedded', 'Video (embedded HTML)*:', array('for' => 'embedded', 'class' => 'control-label')) }}
                {{ Form::text('embedded', isset($video) ? $video->embedded : Input::old('embedded'), array('class' => 'form-control')) }}
                @if ($errors->first('embedded'))
                    <span class="help-block">{{ $errors->first('embedded') }}</span>
                @endif
            </div>
            <br>
            {{ Form::submit(isset($video) ? 'Salvar' : 'Inserir', array('class' => 'btn btn-primary pull-right')) }}
		{{ Form::close() }}
	</div>
@stop