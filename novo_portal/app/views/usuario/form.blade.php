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
            <h4>DADOS PARA ACESSO</h4>
            <hr>
            {{ Form::open(array('url' => 'novo-cadastro')) }}
                
                <div class="form-group {{ ($errors->first('nome')) ? 'has-error' : '' }}">
                    {{ Form::label('nome', 'Nome:', array('for' => 'nome', 'class' => 'control-label')) }}
                    {{ Form::text('nome', Input::old('nome'), array('class' => 'form-control')) }}
                    @if ($errors->first('nome'))
                        <span class="help-block">{{ $errors->first('nome') }}</span>
                    @endif
                </div>
                <div class="form-group {{ ($errors->first('email')) ? 'has-error' : '' }}">
                    {{ Form::label('email', 'Email:', array('for' => 'email', 'class' => 'control-label')) }}
                    {{ Form::email('email', (isset($email)) ? $email : ((Input::old('email')) ? Input::old('email') : ''), array('class' => 'form-control')) }}
                    @if ($errors->first('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group {{ ($errors->first('login')) ? 'has-error' : '' }}">
                    {{ Form::label('login', 'Apelido:', array('for' => 'login', 'class' => 'control-label')) }}
                    {{ Form::text('login', Input::old('login'), array('class' => 'form-control')) }}
                    @if ($errors->first('login'))
                        <span class="help-block">{{ $errors->first('login') }}</span>
                    @endif
                </div>
                <div class="form-group {{ ($errors->first('senha')) ? 'has-error' : '' }}">
                    {{ Form::label('senha', 'Senha:', array('for' => 'senha', 'class' => 'control-label')) }}
                    {{ Form::password('senha', array('class' => 'form-control')) }}
                    @if ($errors->first('senha'))
                        <span class="help-block">{{ $errors->first('senha') }}</span>
                    @endif
                </div>
                <div class="form-group {{ ($errors->first('confirmacao')) ? 'has-error' : '' }}">
                    {{ Form::label('confirmacao', 'Confirmação:', array('for' => 'confirmacao', 'class' => 'control-label')) }}
                    {{ Form::password('confirmacao', array('class' => 'form-control')) }}
                    @if ($errors->first('confirmacao'))
                        <span class="help-block">{{ $errors->first('confirmacao') }}</span>
                    @endif
                </div>
                {{ Form::submit('Salvar', array('class' => 'btn btn-info')) }}

            {{ Form::close() }}
            </form>
        </div>
    </div>


</div>

@stop