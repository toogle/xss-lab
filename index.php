<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Лабораторная работа №2. XSS</title>
		<meta name="description" content="XSS Lab">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="<?php echo MEDIA_URL; ?>/css/bootstrap.min.css" rel="stylesheet">

		<style>
			.nav-inner {
				margin-left: 10px;
			}
		</style>

		<!--[if lt IE 9]>
			<script src="<?php echo MEDIA_URL; ?>/js/lib/respond.min.js"></script>
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
						<li class="active"><a href="#">Главная</a></li>
						<li><a href="documentation.php">Методическое пособие</a></li>
						<li>
							<a class="accordion-toggle" href="#cases" data-toggle="collapse">Рабочее задание</a>
							<ul id="cases" class="nav nav-pills nav-stacked nav-inner collapse">
								<li><a href="cases/1/">Задание №1</a></li>
								<li><a href="cases/2/">Задание №2</a></li>
								<li><a href="cases/3/">Задание №3</a></li>
								<li><a href="cases/4/">Задание №4</a></li>
							</ul>
						</li>
						<li><a href="https://github.com/toogle/xss-lab" target="_blank">Исходный код</a></li>
					</ul>
				</div><!-- .col-md-3 -->

				<div class="col-md-9">
					<div class="well well-lg">
						<p>
							Цель работы: получить практические навыки реализации межсайтового выполнения сценариев.
						</p>

						<p>
							Для успешного выполнения лабораторной работы необходимо:
							<ul>
								<li>иметь представления об HTML и JavaScript;</li>
								<li>понимать принципы взаимодействия веб-браузеров и серверов;</li>
								<li>ознакомиться с методическим пособием.</li>
							</ul>
						</p>
					</div><!-- .well -->
				</div><!-- .col-md-9 -->
			</div><!-- .row -->
		</div><!-- .container -->

		<script src="<?php echo MEDIA_URL; ?>/js/lib/jquery-1.11.1.min.js"></script>
		<script src="<?php echo MEDIA_URL; ?>/js/lib/bootstrap.min.js"></script>
	</body>
</html>
