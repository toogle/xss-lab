<?php
header('X-XSS-Protection: 0');
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Задание №4 / Лабораторная работа №2. XSS</title>
		<meta name="description" content="XSS Lab">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="../../css/bootstrap.min.css" rel="stylesheet">

		<style>
			h4 {
				margin-bottom: 30px;
			}

			.nav-inner {
				margin-left: 10px;
			}
		</style>

		<!--[if lt IE 9]>
			<script src="../../js/lib/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<div class="container">
			<div class="page-header">
				<h1 class="text-center">Лабораторная работа №2 <small>&laquo;XSS&raquo;</small></h1>
			</div>

			<div class="row">
				<div class="col-md-3">
					<ul class="nav nav-pills nav-stacked">
						<li><a href="../../">Главная</a></li>
						<li><a href="../../documentation.html">Методическое пособие</a></li>
						<li>
							<a href="#">Рабочее задание</a>
							<ul class="nav nav-pills nav-stacked nav-inner">
								<li><a href="../1/">Задание №1</a></li>
								<li><a href="../2/">Задание №2</a></li>
								<li><a href="../3/">Задание №3</a></li>
								<li class="active"><a href=".">Задание №4</a></li>
							</ul>
						</li>
						<li><a href="https://github.com/toogle/xss-lab" target="_blank">Исходный код</a></li>
					</ul>
				</div><!-- .col-md-3 -->

				<div class="col-md-9">
					<div class="well well-lg">
						<h4>Обратная связь</h4>

						<?php
						// NOTE: The following code intended for demonstration purposes only.
						//       It is EXTREMELY DANGER to use it for real applications.
						$email = isset($_GET['email']) ? $_GET['email'] : '';
						$name = isset($_GET['name']) ? $_GET['name'] : '';
						$message = isset($_GET['message']) ? $_GET['message'] : '';
						?>

						<?php if ($email && $name && $message): ?>
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								Ваше сообщение успешно отправлено!
							</div>
						<?php elseif ($email || $name || $message): ?>
							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								Все поля обязательны для заполнения!
							</div>
						<?php endif; ?>

						<form class="form-horizontal" method="GET">
							<div class="form-group">
								<label for="email-field" class="col-lg-2 control-label">Ваш E-mail</label>
								<div class="col-lg-4">
									<input type="email" name="email" class="form-control" id="email-field" value="<?= $email ?>" autocomplete="off" autofocus required>
								</div>
							</div>
							<div class="form-group">
								<label for="name-field" class="col-lg-2 control-label">Ваше имя</label>
								<div class="col-lg-4">
									<input type="text" name="name" class="form-control" id="name-field" value="<?= $name ?>" autocomplete="off" required>
								</div>
							</div>
							<div class="form-group">
								<label for="message-field" class="col-lg-2 control-label">Сообщение</label>
								<div class="col-lg-4">
									<textarea class="form-control" id="message-field" name="message" rows="3" required><?php echo htmlspecialchars($message); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-4">
									<button type="submit" class="btn btn-primary">Отправить</button>
								</div>
							</div>
						</form>
					</div><!-- .well -->
				</div><!-- .col-md-9 -->
			</div><!-- .row -->
		</div><!-- .container -->

		<script src="../../js/lib/jquery-1.10.2.min.js"></script>
		<script src="../../js/lib/bootstrap.min.js"></script>
	</body>
</html>
