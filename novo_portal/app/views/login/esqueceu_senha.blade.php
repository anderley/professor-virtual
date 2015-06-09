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
            <h4>Esqueceu sua senha?</h4>
            <h5>Não tem problema nós recuperamos ela para você.</h5>
            <hr>
            {{ Form::open(array('url' => 'enviar-senha')) }}
                <div class="form-group">
                    {{ Form::label('email', 'Digite seu email de cadastro:', array('for' => 'email')) }}
                    {{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'id' => 'email')) }}
                    @if ($errors->first('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                {{ Form::submit('Enviar', array('class' => 'btn btn-info')) }}
            {{ Form::close() }}
            </form>
        </div>
    </div>

</div>

@stop