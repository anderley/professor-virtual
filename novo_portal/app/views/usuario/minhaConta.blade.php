@section('content')

{{ HTML::style('css/nav-pill-tab.css') }}

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

    <div class="col-md-2" style="padding-right: 0px;">
        <!-- Nav tabs -->
        <ul class="nav nav-pills nav-stacked" role="tablist">
            <li class="{{ (Input::old('form') != '') ? (Input::old('form') == 'dados-pessoais') ? 'active' : '' : 'active' }}"><a href="#dados-pessoais" role="tab" data-toggle="tab">Dados pessoais</a></li>
            <li class="{{ (Input::old('form') != '') ? (Input::old('form') == 'endereco') ? 'active' : '' : '' }}"><a href="#endereco" role="tab" data-toggle="tab">Endereço</a></li>
            <li class="{{ (Input::old('form') != '') ? (Input::old('form') == 'interesse') ? 'active' : '' : '' }}"><a href="#interesse" role="tab" data-toggle="tab">Áreas de interesse</a></li>
        </ul>
    </div>
    <div class="col-md-offset-2"  style="padding-left: 0px;">
        <!-- Tab panes -->
        <div class="row">
            <div class="tab-content col-md-7">
                <div class="tab-pane {{ (Input::old('form') != '') ? (Input::old('form') == 'dados-pessoais') ? 'active' : '' : 'active' }}" id="dados-pessoais">
                    {{ Form::open(array('url' => 'atualizar-usuario')) }}
                        {{ Form::hidden('form', 'dados-pessoais') }}
                        <div class="form-group {{ ($errors->first('nome')) ? 'has-error' : '' }}">
                            {{ Form::label('nome', '*Nome', array('for' => 'nome', 'class' => 'control-label')) }}
                            {{ Form::text('nome', (Input::old('nome') != '') ? Input::old('nome') : $user->nome, array('class' => 'form-control')) }}
                            @if ($errors->first('nome'))
                                <span class="help-block">{{ $errors->first('nome') }}</span>
                            @endif
                        </div>                    
                        <div class="form-group {{ ($errors->first('email')) ? 'has-error' : '' }}">
                            {{ Form::label('email', '*Email', array('for' => 'email', 'class' => 'control-label')) }}
                            {{ Form::email('email', (Input::old('email') != '') ? Input::old('email') : $user->email, array('class' => 'form-control', 'disabled' => 'true')) }}
                            @if ($errors->first('email'))
                                <span class="help-block">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ ($errors->first('sexo')) ? 'has-error' : '' }}">
                            {{ Form::label('sexo', '*Sexo', array('for' => 'sexo', 'class' => 'control-label')) }}
                            {{ Form::select('sexo', array('MASCULINO' => 'Masculino', 'FEMININO' => 'Feminino'), (Input::old('sexo') != '') ? Input::old('sexo') : $user->sexo, array('class' => 'form-control')) }}
                            @if ($errors->first('sexo'))
                                <span class="help-block">{{ $errors->first('sexo') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ ($errors->first('data_nascimento')) ? 'has-error' : '' }}">
                            {{ Form::label('data-nascimento', '*Data de nascimento', array('for' => 'data-nascimento', 'class' => 'control-label')) }}
                            {{ Form::text('data_nascimento', (Input::old('data_nascimento') != '') ? Input::old('data_nascimento') : preg_replace('/(\d{4})-(\d{2})-(\d{2})/i', '$3/$2/$1', $user->data_nascimento), array('class' => 'form-control', 'id' => 'data')) }}
                            @if ($errors->first('data_nascimento'))
                                <span class="help-block">{{ $errors->first('data_nascimento') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ ($errors->first('telefone')) ? 'has-error' : '' }}">
                            {{ Form::label('telefone', 'Telefone', array('for' => 'telefone', 'class' => 'control-label')) }}
                            {{ Form::text('telefone', (Input::old('telefone') != '') ? Input::old('telefone') : $user->telefone, array('class' => 'form-control', 'id' => 'tel')) }}
                            @if ($errors->first('telefone'))
                                <span class="help-block">{{ $errors->first('telefone') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ ($errors->first('celular')) ? 'has-error' : '' }}">
                            {{ Form::label('celular', 'Celular', array('for' => 'data-nascimento', 'class' => 'control-label')) }}
                            {{ Form::text('celular', (Input::old('celular') != '') ? Input::old('celular') : $user->celular, array('class' => 'form-control', 'id' => 'cel')) }}
                            @if ($errors->first('celular'))
                                <span class="help-block">{{ $errors->first('celular') }}</span>
                            @endif
                        </div>
                        <br>
                        {{ Form::submit('Salvar', array('class' => 'btn btn-info')) }}
                    {{ Form::close() }}
                </div>
                <div class="tab-pane {{ (Input::old('form') != '') ? (Input::old('form') == 'endereco') ? 'active' : '' : '' }}" id="endereco">
                    {{ Form::open(array('url' => 'atualizar-endereco')) }}
                        {{ Form::hidden('form', 'endereco') }}
                        {{ Form::hidden('codigo_ibge', (Input::old('codigo_ibge') != '') ? Input::old('codigo_ibge') : ($user->enderecoPrincipal() != '') ? $user->enderecoPrincipal()->codigo_ibge : '', array('id' => 'ibge')) }}
                        <div class="form-group {{ ($errors->first('cep')) ? 'has-error' : '' }}">
                            {{ Form::label('cep', 'CEP', array('for' => 'cep', 'class' => 'control-label')) }}
                            {{ Form::text('cep', (Input::old('cep') != '') ? Input::old('cep') : ($user->enderecoPrincipal() != '') ? $user->enderecoPrincipal()->cep : '', array('class' => 'form-control', 'id' => 'cep')) }}
                            @if ($errors->first('cep'))
                                <span class="help-block">{{ $errors->first('cep') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ ($errors->first('logradouro')) ? 'has-error' : '' }}">
                            {{ Form::label('logradouro', 'Logradouro', array('for' => 'logradouro', 'class' => 'control-label')) }}
                            {{ Form::text('logradouro', (Input::old('logradouro') != '') ? Input::old('logradouro') : ($user->enderecoPrincipal() != '') ? $user->enderecoPrincipal()->logradouro : '', array('class' => 'form-control', 'id' => 'logradouro')) }}
                            @if ($errors->first('logradouro'))
                                <span class="help-block">{{ $errors->first('logradouro') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ ($errors->first('numero')) ? 'has-error' : '' }}">
                            {{ Form::label('numero', 'Número', array('for' => 'numero', 'class' => 'control-label')) }}
                            {{ Form::text('numero', (Input::old('numero') != '') ? Input::old('numero') : ($user->enderecoPrincipal() != '') ? $user->enderecoPrincipal()->numero : '', array('class' => 'form-control')) }}
                            @if ($errors->first('numero'))
                                <span class="help-block">{{ $errors->first('numero') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ ($errors->first('complemento')) ? 'has-error' : '' }}">
                            {{ Form::label('complemento', 'Complemento', array('for' => 'complemento', 'class' => 'control-label')) }}
                            {{ Form::text('complemento', (Input::old('complemento') != '') ? Input::old('complemento') : ($user->enderecoPrincipal() != '') ? $user->enderecoPrincipal()->complemento : '', array('class' => 'form-control')) }}
                            @if ($errors->first('complemento'))
                                <span class="help-block">{{ $errors->first('complemento') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ ($errors->first('bairro')) ? 'has-error' : '' }}">
                            {{ Form::label('bairro', 'Bairro', array('for' => 'bairro', 'class' => 'control-label')) }}
                            {{ Form::text('bairro', (Input::old('bairro') != '') ? Input::old('bairro') : ($user->enderecoPrincipal() != '') ? $user->enderecoPrincipal()->bairro : '', array('class' => 'form-control', 'id' => 'bairro')) }}
                            @if ($errors->first('bairro'))
                                <span class="help-block">{{ $errors->first('bairro') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ ($errors->first('cidade')) ? 'has-error' : '' }}">
                            {{ Form::label('cidade', 'Cidade', array('for' => 'cidade', 'class' => 'control-label')) }}
                            {{ Form::text('cidade', (Input::old('cidade') != '') ? Input::old('cidade') : ($user->enderecoPrincipal() != '') ? $user->enderecoPrincipal()->cidade : '', array('class' => 'form-control', 'id' => 'cidade')) }}
                            @if ($errors->first('cidade'))
                                <span class="help-block">{{ $errors->first('cidade') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ ($errors->first('estado')) ? 'has-error' : '' }}">
                            {{ Form::label('estado', 'Estado', array('for' => 'estado', 'class' => 'control-label')) }}
                            {{ Form::select('estado',  
                                array('' => 'Escolha o estado',
                                            'AC' => 'Acre', 
                                            'AL' => 'Alagoas', 
                                            'AP' => 'Amapá', 
                                            'AM' => 'Amazonas', 
                                            'BA' => 'Bahia', 
                                            'CE' => 'Ceará', 
                                            'DF' => 'Distrito Federal', 
                                            'ES' => 'Espirito Santo', 
                                            'GO' => 'Goiás', 
                                            'MA' => 'Maranhão', 
                                            'MT' => 'Mato Grosso', 
                                            'MS' => 'Mato Grosso do Sul', 
                                            'MG' => 'Minas Gerais', 
                                            'PA' => 'Pará', 
                                            'PB' => 'Paraiba', 
                                            'PR' => 'Paraná', 
                                            'PE' => 'Pernambuco', 
                                            'PI' => 'Piauí', 
                                            'RJ' => 'Rio de Janeiro', 
                                            'RN' => 'Rio Grande do Norte', 
                                            'RS' => 'Rio Grande do Sul', 
                                            'RO' => 'Rondônia', 
                                            'RR' => 'Roraima', 
                                            'SC' => 'Santa Catarina', 
                                            'SP' => 'São Paulo', 
                                            'SE' => 'Sergipe', 
                                            'TO' => 'Tocantis',),
                                    (Input::old('estado') != '') ? Input::old('estado') : ($user->enderecoPrincipal() != '') ? $user->enderecoPrincipal()->uf : '', array('class' => 'form-control', 'id' => 'estado')) }}
                            @if ($errors->first('estado'))
                                <span class="help-block">{{ $errors->first('estado') }}</span>
                            @endif
                        </div>
                        <br>
                        {{ Form::submit('Salvar', array('class' => 'btn btn-info')) }}
                    {{ Form::close() }}
                </div>
                <div class="tab-pane {{ (Input::old('form') != '') ? (Input::old('form') == 'interesse') ? 'active' : '' : '' }}" id="interesse">interesse</div>
            </div>
        </div>
        <div class="row col-md-7">
        </div>
    </div>

</div>

@stop