<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Bem-vindo à Família Aziz</title>

	<style>
		@import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap");

		* {
			margin: 0;
			padding: 0;
		}

		* {
			font-family: "Open Sans", "Helvetica", Helvetica, Arial, sans-serif;
		}

		img {
			max-width: 100%;
		}

		.collapse {
			margin: 0;
			padding: 0;
		}

		body {
			-webkit-font-smoothing: antialiased;
			-webkit-text-size-adjust: none;
			width: 100% !important;
			height: 100%;
		}

		a {
			color: #5b6770;
			text-decoration: none;
		}

		.btn {
			text-decoration: none;
			color: #FFF;
			background-color: #2BA6CB;
			padding: 12px 24px;
			font-weight: bold;
			margin-right: 10px;
			text-align: center;
			cursor: pointer;
			display: inline-block;
			border-radius: 5px;
		}

		.btn:hover {
			background-color: #239ac0;
		}

		table.head-wrap {
			width: 100%;
		}

		.header.container table td.logo {
			padding: 15px;
		}

		table.body-wrap {
			width: 100%;
		}

		table.footer-wrap {
			width: 100%;
			clear: both !important;
		}

		.footer-wrap .container td.content p {
			border-top: 1px solid rgb(215, 215, 215);
			padding-top: 15px;
		}

		.footer-wrap .container td.content p {
			font-size: 10px;
			font-weight: bold;
		}

		.text-white {
			color: #fff;
		}

		.text {
			color: #444;
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-family: "Open Sans", Helvetica, Arial, "Lucida Grande", sans-serif;
			line-height: 1.1;
			margin-bottom: 20px;
			color: #000;
		}

		h1 {
			font-weight: 200;
			font-size: 34px;
		}

		h2 {
			font-weight: 200;
			font-size: 28px;
		}

		h3 {
			font-weight: 500;
			font-size: 24px;
		}

		p,
		ul {
			margin-bottom: 20px;
			font-weight: normal;
			font-size: 15px;
			line-height: 1.6;
			color: #444;
		}

		.center {
			text-align: center;
		}

		.container {
			display: block !important;
			max-width: 600px !important;
			margin: 0 auto !important;
			clear: both !important;
			padding: 0 30px;
		}

		.content {
			padding: 0 0 0;
			max-width: 600px;
			margin: 0 auto;
			display: block;
		}

		body>table.body-wrap>tbody>tr>td.container>.content {
			padding: 40px 50px 0 50px;
		}

		.content table {
			width: 100%;
		}

		.welcome-box {
			background-color: #f4f9ff;
			border-radius: 10px;
			padding: 30px;
			margin: 20px 0;
			border-left: 4px solid #2BA6CB;
		}

		.highlight {
			color: #2BA6CB;
			font-weight: bold;
		}

		.info-list {
			background-color: #fff;
			padding: 20px;
			border-radius: 8px;
			margin: 20px 0;
		}

		.info-list li {
			margin-bottom: 10px;
			list-style-position: inside;
		}
	</style>
</head>

<body bgcolor="#f9f9f9">

	<!-- HEADER -->
	<table class="head-wrap">
		<tr>
			<td></td>
			<td class="header container">
				<div class="content">
					<table>
						<tr>
							<td>
								<img src="https://controle.missiowave.com.br/img/header.jpg" width="100%" border="0" />
							</td>
						</tr>
					</table>
				</div>
			</td>
			<td></td>
		</tr>
	</table>
	<!-- /HEADER -->

	<!-- BODY -->
	<table class="body-wrap">
		<tr>
			<td></td>
			<td class="container">
				<div class="content">
					<table>
						<tr>
							<td>
                                <h2>Olá, {{ $user['nome'] }}!</h2>
                                <p>Que alegria ter você conosco!</p>

                                <p>Seja muito bem-vindo(a) como mantenedor(a) dos projetos da Família Aziz no Oriente Médio!</p>

                                <p>Queremos agradecer, de coração, por você escolher nos apoiar financeiramente. Sua decisão faz parte daquilo que Deus está fazendo por meio da missão, levando o amor de Deus, alcançando vidas e fortalecendo a igreja perseguida.</p>

                                <p>Quando estiver chegando o melhor dia que você escolheu para sua oferta, enviaremos um lembrete para te ajudar a lembrar.</p>
                                <p>(Dica rápida: para garantir que nossas mensagens cheguem direitinho até você, adicione nosso e-mail <a href="mailto:contato@familiaaziz.org">contato@familiaaziz.org</a> à sua lista de contatos e verifique sua caixa de spam.)</p>

                                <p>Fique à vontade para falar conosco sempre que precisar. Estamos à disposição para tirar dúvidas ou ajudar no que for necessário pelo nosso WhatsApp: 21 98208-2879.</p>

                                <p>Mais uma vez, muito obrigada por caminhar conosco. Sua parceria é preciosa!</p>
                                <p>Com gratidão,<br>
                                Família Aziz</p>

                                <p>
                                    <small>
                                        --<br>
                                        Aviso importante:<br>
                                        Você está recebendo este e-mail porque se inscreveu em nosso formulário de mantenedores. Seus dados são tratados com responsabilidade e em conformidade com a Lei Geral de Proteção de Dados (LGPD).
                                    </small>
                                </p>
                            </td>
						</tr>
					</table>
				</div>
			</td>
			<td></td>
		</tr>
	</table>
	<!-- /BODY -->


</body>
</html>
