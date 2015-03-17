<?php
header('X-XSS-Protection: 0');
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Задание №5 / Лабораторная работа №2. XSS</title>
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
								<li><a href="../4/">Задание №4</a></li>
								<li class="active"><a href=".">Задание №5</a></li>
							</ul>
						</li>
						<li><a href="https://github.com/toogle/xss-lab" target="_blank">Исходный код</a></li>
					</ul>
				</div><!-- .col-md-3 -->

				<div class="col-md-9">
					<div class="well well-lg">
						<h4>Страница смены пароля</h4>
						<form>
						  <div class="form-group">
						    <label for="oldPassword">Старый пароль</label>
						    <input type="password" class="form-control" id="oldPassword">
						  </div>
						  <div class="form-group">
						    <label for="newPassword1">Новый пароль</label>
						    <input type="password" class="form-control" id="newPassword1">
						  </div>
						  <div class="form-group">
						    <label for="newPassword2">Новый пароль еще раз</label>
						    <input type="password" class="form-control" id="newPassword2">
						  </div>
						  <button type="submit" class="btn btn-default">Изменить</button>
						</form>
					</div><!-- .well -->
				</div><!-- .col-md-9 -->
			</div><!-- .row -->
		</div><!-- .container -->

		<script src="../../js/lib/jquery-1.11.1.min.js"></script>
		<script src="../../js/lib/bootstrap.min.js"></script>
	</body>
</html>
