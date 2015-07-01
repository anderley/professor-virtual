@section('container')
	<div class="container col-md-8">
		<h2>Apostila</h2>
		<br>
        @if(Session::get('tipo_alerta'))
            <div class="alert {{ Session::get('tipo_alerta') }}" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
				{{ Session::get('msg_alerta') }}
            </div>
    	@endif
		{{ Form::open(array('url' => 'salvar-apostila', 'files' => true)) }}
            {{ Form::hidden('id', isset($apostila) ? $apostila->id : '') }}
			<div class="form-group {{ ($errors->first('titulo')) ? 'has-error' : '' }}">
                {{ Form::label('titulo', 'Titulo*:', array('for' => 'titulo', 'class' => 'control-label')) }}
                {{ Form::text('titulo', isset($apostila) ? $apostila->titulo : Input::old('titulo'), array('class' => 'form-control')) }}
                @if ($errors->first('titulo'))
                    <span class="help-block">{{ $errors->first('titulo') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('cargo')) ? 'has-error' : '' }}">
                {{ Form::label('cargo', 'Cargo*:', array('for' => 'cargo', 'class' => 'control-label')) }}
                {{ Form::text('cargo', isset($apostila) ? $apostila->cargo : Input::old('cargo'), array('class' => 'form-control')) }}
                @if ($errors->first('cargo'))
                    <span class="help-block">{{ $errors->first('cargo') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('imagem')) ? 'has-error' : '' }}">
                {{ Form::label('imagem', 'Imagem*:', array('for' => 'imagem', 'class' => 'control-label')) }}
                {{ Form::text('imagem', isset($apostila) ? $apostila->imagem : Input::old('imagem'), array('class' => 'form-control')) }}
                @if ($errors->first('imagem'))
                    <span class="help-block">{{ $errors->first('imagem') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('link_parceiro')) ? 'has-error' : '' }}">
                {{ Form::label('link_parceiro', 'Link para compra com parceiro*:', array('for' => 'link_parceiro', 'class' => 'control-label')) }}
                {{ Form::text('link_parceiro', isset($apostila) ? $apostila->link_parceiro : Input::old('link_parceiro'), array('class' => 'form-control')) }}
                @if ($errors->first('link_parceiro'))
                    <span class="help-block">{{ $errors->first('link_parceiro') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('valor_impresso')) ? 'has-error' : '' }}">
                {{ Form::label('valor_impresso', 'Valor impresso*:', array('for' => 'valor_impresso', 'class' => 'control-label')) }}
                {{ Form::text('valor_impresso', isset($apostila) ? str_replace(".", ",", $apostila->valor_impresso) : Input::old('valor_impresso'), array('class' => 'form-control currency')) }}
                @if ($errors->first('valor_impresso'))
                    <span class="help-block">{{ $errors->first('valor_impresso') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('valor_digital')) ? 'has-error' : '' }}">
                {{ Form::label('valor_digital', 'Valor digital:', array('for' => 'valor_digital', 'class' => 'control-label')) }}
                {{ Form::text('valor_digital', isset($apostila) ? str_replace(".", ",", $apostila->valor_digital) : Input::old('valor_digital'), array('class' => 'form-control currency')) }}
                @if ($errors->first('valor_digital'))
                    <span class="help-block">{{ $errors->first('valor_digital') }}</span>
                @endif
            </div>
            <div class="form-group {{ ($errors->first('tags')) ? 'has-error' : '' }}">
                {{ Form::label('tags', 'Tags:', array('for' => 'tags', 'class' => 'control-label')) }}
                {{ Form::text('tags', isset($tags) ? $tags : Input::old('tags'), array('class' => 'form-control', 'id' => 'tags')) }}
                @if ($errors->first('tags'))
                    <span class="help-block">{{ $errors->first('tags') }}</span>
                @endif
            </div>
            <div class="checkbox">
                <label>
                    {{ Form::checkbox('ativo', 'true', isset($apostila) ? $apostila->ativo : Input::old('ativo')) }} Ativo
                </label>
            </div>
            <br>
            {{ Form::submit(isset($apostila) ? 'Salvar' : 'Inserir', array('class' => 'btn btn-primary pull-right')) }}
		{{ Form::close() }}
	</div>
@stop