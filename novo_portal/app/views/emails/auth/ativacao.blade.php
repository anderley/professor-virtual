<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Olá {{ $nome }}!</h2>

		<div>
			Falta muito pouco para acessar nosso conteúdo.<br>
			Click no link abaixo para ativar sua conta e venha estudar conosco!<br>
			<br>
			---<br>
			{{ URL::to('ativar-conta', array('token' => $token)) }}<br>
			---<br>
			<br>
			<br>
			Equipe Professor Virtual.
		</div>
	</body>
</html>
