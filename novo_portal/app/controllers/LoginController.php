<?php

class LoginController extends BaseController {

    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'layouts.main';

    private $mensages = array(
            'required' => 'Este campo é obrigatório.',
            'email' => 'O email informado não é válido.',
            'min' => 'O tamanho mínimo para este campo é de :min.',
    );


    public function show()
    {
        $bc = array(
            'breadcrumb' => array(
                array(
                    'nome' => 'Home',
                    'active' => false,
                    'url' => '/',
                ),
                array(
                    'nome' => 'Acesso',
                    'active' => true,
                    'url' => '#',
                ),
            ),
        );
        $this->layout->breadcrumb = View::make('layouts.breadcrumb', $bc);

        $this->layout->content = View::make('login.main');
    }

    public function autenticar()
    {
        $regras = array(
            'email-login' => 'required|email',
            'senha-login' => 'required|min:6',
        );
        $validator = Validator::make(Input::all(), $regras, $this->mensages);

        if ($validator->fails())
        {
            return Redirect::to('login')->withErrors($validator)->withInput(Input::all());
        }

        $user = User::where('email', Input::get('email-login'))->first();

        if ($user && Hash::check(Input::get('senha-login'), $user->senha))
        {
            if ($user->ativo == 1)
            {
                Auth::login($user);

                return Redirect::to('/');
            }
            $data = array(
                'tipo_alerta' => "alert-danger",
                'msg_alerta' => "Não foi logar seu usário!<br>Por favor verifique se recebeu nosso email com a ativação da sua conta.",
            );

            $this->layout->content = View::make('login.main', $data);

            return ;
        }

        $data = array(
            'tipo_alerta' => "alert-danger",
            'msg_alerta' => "Email / Senha incorretos.",
        );

        $this->layout->content = View::make('login.main', $data);
    }

    public function autenticarAtivacao()
    {
        $regras = array(
            'email' => 'required|email',
            'senha' => 'required|min:6',
            );
        $validator = Validator::make(Input::all(), $regras, $this->mensages);

        if ($validator->fails())
        {
            return Redirect::route('reativar-conta', array('token' => Input::get('token')))->withErrors($validator)->withInput(Input::all());
        }

        $user = User::where('token', Input::get('token'))->where('email', Input::get('email'))->first();

        if ($user && Hash::check(Input::get('senha'), $user->senha_tmp))
        {
            Auth::login($user);

            $user->ativo = 1;

            $user->save();

            return Redirect::to('/');
        }

        $data = array(
            'tipo_alerta' => "alert-danger",
            'msg_alerta' => "Não foi ativar seu usário, tente novamente. ",
            'token' => Input::get('token'),
            );

        $this->layout->content = View::make('login.ativacao', $data);
    }

    public function lembrarSenha($data = null)
    {
        $bc = array(
            'breadcrumb' => array(
                array(
                    'nome' => 'Home',
                    'active' => false,
                    'url' => '/',
                ),
                array(
                    'nome' => 'Lembrar senha',
                    'active' => true,
                    'url' => '#',
                ),
            ),
        );
        $this->layout->breadcrumb = View::make('layouts.breadcrumb', $bc);

        if ($data != null)
        {
            $this->layout->content = View::make('login.esqueceu_senha', $data);
        }
        else
        {
            $this->layout->content = View::make('login.esqueceu_senha');   
        }
    }

    public function enviarSenha()
    {
        $regras = array(
            'email' => 'required|email',
            );
        $validator = Validator::make(Input::all(), $regras, $this->mensages);

        if ($validator->fails())
        {
            return Redirect::to('lembrar-senha')->withErrors($validator)->withInput(Input::all());
        }
        $user = User::where('email', Input::get("email"))->first();

        if ($user) 
        {
            $senha_tmp = str_random(8);
            $user->senha_tmp = Hash::make($senha_tmp);
            $user->token = str_random(60);

            $user->save();

            $data = array(
                'nome' => $user->nome,
                'login' => $user->login,
                'senha_tmp' => $senha_tmp,
                'token' => $user->token,
                );

            Mail::send('emails.auth.lembrete', $data, function($message)
            {
                $message->from('anderley.viana@gmail.com', 'Equipe Prof. Virtual')
                ->to('anderley.viana@gmail.com', 'Anderley Viana')
                ->cc('manoel@professor.mat.br', 'Manoel Viana')
                ->subject('Lembrete de senha!');
            });
        }
        else
        {
            $data = array(
                'tipo_alerta' => "alert-danger",
                'msg_alerta' => "Usuário não encontrado.",
                );

            $this->lembrarSenha($data);

            return ;
        }
        $data = array(
            'tipo_alerta' => "alert-success",
            'msg_alerta' => "Senha enviado com sucesso. Verifique seu email."
            );

        return Redirect::to('/')->with($data);
    }

    public function reativarConta($token) 
    {
        $this->layout->content = View::make('login.ativacao', array('token' => $token));
    }
}
