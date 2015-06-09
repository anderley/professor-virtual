<?php

class UsuarioController extends BaseController {

    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'layouts.main';

    private $mensages = array(
        'required' => 'Este campo é obrigatório.',
        'email' => 'O email informado não é válido.',
        'min' => 'O tamanho mínimo para este campo é de :min.',
        'unique' => 'Este email já está cadastrado.',
        'same' => 'Senha não confere com confirmação.',
        'regex' => 'O campo está fora do padrão aceitável.'
        );

    private $bc = array(
        'breadcrumb' => array(
            array(
                'nome' => 'Home',
                'active' => false,
                'url' => '/',
                ),
            array(
                'nome' => 'Cadastro',
                'active' => true,
                'url' => '#',
                ),
            ),
        );

    public function showCadastro()
    {
        $this->layout->breadcrumb = View::make('layouts.breadcrumb', $this->bc);
        $this->layout->content = View::make('usuario.minhaConta', $data);
    }

    public function cadastro()
    {
        $regras = array('email-usuario' => 'required|email|unique:usuario,email',);
        $validator = Validator::make(Input::all(), $regras, $this->mensages);

        if ($validator->fails())
        {
            return Redirect::to('login')->withErrors($validator)->withInput(Input::all());
        }

        $this->layout->breadcrumb = View::make('layouts.breadcrumb', $this->bc);
        $this->layout->content = View::make('usuario.form', array('email' => Input::get('email-usuario')));
    }

    public function novoCadastro()
    {
        $regras = array(
            'nome' => 'required',
            'email' => 'required|email|unique:usuario,email',
            'senha' => 'required|min:8',
            'confirmacao' => 'required|same:senha',
            );
        $validator = Validator::make(Input::all(), $regras, $this->mensages);

        if ($validator->fails())
        {
            return Redirect::to('showCadastro')->withErrors($validator)->withInput(Input::all());
        }

        $user = new User;
        $user->email = Input::get('email');
        $user->nome = Input::get('nome');
        $user->login = Input::get('login');
        $user->senha = Hash::make(Input::get('senha'));
        $user->ativo = 0;
        $user->criado = time();
        $user->token = str_random(60);

        $data = array(
            'nome' => $user->nome,
            'token' => $user->token,
            );

        Mail::send('emails.auth.ativacao', $data, function($message) use ($user)
        {
            $message->from('anderley.viana@gmail.com', 'Equipe Prof. Virtual')
            ->to($user->email, $user->nome)
            ->cc('manoel@professor.mat.br', 'Manoel Viana')
            ->cc('anderley.viana@gmail.com', 'Anderley Viana')
            ->subject('Professor Virtual - Ative sua conta.');
        }
        );

        $user->save();

        $data = array(
            'tipo_alerta' => "alert-success",
            'msg_alerta' => "Cadrasto realizado com sucesso. Verifique seu email e ative sua conta.",
            );
        return Redirect::to("/")->with($data);
    }

    public function ativarConta($token)
    {
        $user = User::where('token', $token)->first();

        if ($user)
        {
            $user->ativo = 1;

            $user->save();

            $data = array(
                'tipo_alerta' => "alert-success",
                'msg_alerta' => "Conta ativada com sucesso.",
                );

            return Redirect::to("/")->with($data);
        }

        $data = array(
            'tipo_alerta' => "alert-danger",
            'msg_alerta' => "Não foi possível ativar sua conta, tente novamente e caso persista o problema entre em contato com suporte.",
            );

        return Redirect::to("/")->with($data);
    }

    public function minhaConta()
    {
        $bc = array(
            'breadcrumb' => array(
                array(
                    'nome' => 'Home',
                    'active' => false,
                    'url' => '/',
                    ),
                array(
                    'nome' => 'Minha Conta',
                    'active' => true,
                    'url' => '#',
                    ),
                ),
        );

        $data = array('user' => Auth::user());
        $this->layout->breadcrumb = View::make('layouts.breadcrumb', $bc);
        $this->layout->content = View::make('usuario.minhaConta', $data);
    }

    public function atualizarUsuario()
    {
        $bc = array(
            'breadcrumb' => array(
                array(
                    'nome' => 'Home',
                    'active' => false,
                    'url' => '/',
                    ),
                array(
                    'nome' => 'Minha Conta',
                    'active' => true,
                    'url' => '#',
                    ),
                ),
        );
        $regras = array(
            'nome' => 'required',
            'data_nascimento' => 'required|regex:/\d{2}\/\d{2}\/\d{4}/',
            'telefone' => 'regex:/\(\d{2}\)\s\d{4}-\d{4}/',
            'celular' => 'regex:/\(\d{2}\)\s\d{5}-\d{4}/',
        );
        $validator = Validator::make(Input::all(), $regras, $this->mensages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput(Input::all());
        }
        $user = Auth::user();
        if ($user)
        {
            $user->nome = Input::get('nome');
            $user->sexo = Input::get('sexo');
            $user->data_nascimento = preg_replace('/(\d{2})\/(\d{2})\/(\d{4})/i', '$3-$2-$1', Input::get('data_nascimento'));
            $telefone = Input::get('telefone');
            $user->telefone = preg_match('/\(\d{2}\)\s\d{4}-\d{4}/i', $telefone) ? $telefone : null;
            $celular = Input::get('celular');
            $user->celular = preg_match('/\(\d{2}\)\s\d{5}-\d{4}/i', $celular) ? $celular : null;
            $user->save();

            $data = array(
                'tipo_alerta' => "alert-success",
                'msg_alerta' => "Conta atualizada com sucesso.",
            );

            return Redirect::to("/")->with($data);
        }
    }

    public function atualizarEndereco()
    {
        $bc = array(
            'breadcrumb' => array(
                array(
                    'nome' => 'Home',
                    'active' => false,
                    'url' => '/',
                    ),
                array(
                    'nome' => 'Minha Conta',
                    'active' => true,
                    'url' => '#',
                    ),
                ),
        );
        $regras = array(
            'logradouro' => 'required',
            'numero' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'cep' => 'required',
        );
        $validator = Validator::make(Input::all(), $regras, $this->mensages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput(Input::all());
        }
        $user = Auth::user();
        if ($user)
        {
            $endereco = $user->enderecos()->where('principal', true)->whereNull('excluido')->first();
            $endereco = ($endereco) ? $endereco : new Endereco();
            $endereco->logradouro = Input::get('logradouro');
            $endereco->numero = Input::get('numero');
            $endereco->complemento = Input::get('complemento');
            $endereco->bairro = Input::get('bairro');
            $endereco->cidade = Input::get('cidade');
            $endereco->uf = Input::get('estado');
            $endereco->cep = Input::get('cep');
            $endereco->codigo_ibge = Input::get('codigo_ibge');
            $endereco->principal = true;

            $user->enderecos()->save($endereco);

            $data = array(
                'tipo_alerta' => "alert-success",
                'msg_alerta' => "Conta atualizada com sucesso.",
            );

            return Redirect::to("/")->with($data);
        }
    }
}