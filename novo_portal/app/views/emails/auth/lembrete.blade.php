<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Olá {{ $nome }}!</h2>

		<div>
			Recuperamos sua senha!<br>
			Seguem seus dados:<br>
			Usuário: {{ $login }}<br>
			Senha: {{ $senha_tmp }}<br>
			<br>
			Link para reativar conta.<br>
			---<br>
			{{ URL::to('reativar-conta', array('token' => $token)) }}<br>
			---
		</div>
	</body>
</html>
