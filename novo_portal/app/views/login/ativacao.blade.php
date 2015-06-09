@section('content')

<div class="container">
    
    @if(isset($tipo_alerta))
        <div class="row">
            <div class="alert {{ $tipo_alerta }}" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <p>{{ $msg_alerta }}</p>
            </div>
        </div>
    @endif

    <div class="col-md-6">
        <div class="painel-login">
            <h4>JÁ SOU CADASTRADO</h4>
            <hr>
            {{ Form::open(array('url' => 'autenticar-ativacao')) }}

                {{ Form::hidden('token', $token) }}

                <div class="form-group {{ ($errors->first('email')) ? 'has-error' : '' }}">
                    {{ Form::label('email', 'Digite seu email:', array('for' => 'email', 'class' => 'control-label')) }}
                    {{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
                    @if ($errors->first('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group {{ ($errors->first('senha')) ? 'has-error' : '' }}">
                    {{ Form::label('senha', 'Digite sua senha:', array('for' => 'senha', 'class' => 'control-label')) }}
                    {{ Form::password('senha', array('class' => 'form-control')) }}
                    @if ($errors->first('senha'))
                        <span class="help-block">{{ $errors->first('senha') }}</span>
                    @endif
                </div>
                <p class="text-right"><a href="{{ url('lembrar-senha') }}">Esqueci minha senha?</a></p>
                {{ Form::submit('Entrar', array('class' => 'btn btn-info')) }}

            {{ Form::close() }}
        </div>
    </div>

</div>

@stop