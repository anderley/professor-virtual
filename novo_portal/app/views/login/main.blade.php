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
            {{ Form::open(array('url' => 'autenticar')) }}

                <div class="form-group {{ ($errors->first('email-login')) ? 'has-error' : '' }}">
                    {{ Form::label('email-login', 'Digite seu email:', array('for' => 'email-login', 'class' => 'control-label')) }}
                    {{ Form::email('email-login', Input::old('email-login'), array('class' => 'form-control')) }}
                    @if ($errors->first('email-login'))
                        <span class="help-block">{{ $errors->first('email-login') }}</span>
                    @endif
                </div>
                <div class="form-group {{ ($errors->first('senha-login')) ? 'has-error' : '' }}">
                    {{ Form::label('senha-login', 'Digite seu email:', array('for' => 'email-login', 'class' => 'control-label')) }}
                    {{ Form::password('senha-login', array('class' => 'form-control')) }}
                    @if ($errors->first('senha-login'))
                        <span class="help-block">{{ $errors->first('senha-login') }}</span>
                    @endif
                </div>
                <p class="text-right"><a href="{{ url('lembrar-senha') }}">Esqueci minha senha?</a></p>
                {{ Form::submit('Entrar', array('class' => 'btn btn-info')) }}

            {{ Form::close() }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="painel-login">
            <h4>SOU UM NOVO USUÁRIO</h4>
            <hr>
            {{ Form::open(array('url' => 'cadastro')) }}
                
                <div class="form-group {{ ($errors->first('email-usuario')) ? 'has-error' : '' }}">
                    {{ Form::label('email-usuario', 'Digite seu email:', array('for' => 'email-usuario', 'class' => 'control-label')) }}
                    {{ Form::email('email-usuario', Input::old('email-usuario'), array('class' => 'form-control')) }}
                    @if ($errors->first('email-usuario'))
                        <span class="help-block">{{ $errors->first('email-usuario') }}</span>
                    @endif
                </div>
                {{ Form::submit('Continuar', array('class' => 'btn btn-info')) }}

            {{ Form::close() }}
        </div>
    </div>

</div>

@stop