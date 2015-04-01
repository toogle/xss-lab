<?php require_once('../../config.php'); ?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Задание №6 / Лабораторная работа №2. XSS</title>
		<meta name="description" content="XSS Lab">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="<?php echo MEDIA_URL; ?>/css/bootstrap.min.css" rel="stylesheet">

		<style>
			.nav-inner {
				margin-left: 10px;
			}

			.img-thumbnail {
				display: inline-block;
				width: 128px;
				height: 128px;
				margin-right: 10px;
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
						<li><a href="../../">Главная</a></li>
						<li><a href="../../documentation.php">Методическое пособие</a></li>
						<li>
							<a href="#">Рабочее задание</a>
							<ul class="nav nav-pills nav-stacked nav-inner">
								<li><a href="../1/">Задание №1</a></li>
								<li><a href="../2/">Задание №2</a></li>
								<li><a href="../3/">Задание №3</a></li>								
								<li><a href="../4/">Задание №4</a></li>
								<li class="active"><a href=".">Задание №6</a></li>
							</ul>
						</li>
						<li><a href="https://github.com/toogle/xss-lab" target="_blank">Исходный код</a></li>
					</ul>
				</div><!-- .col-md-3 -->

				<div class="col-md-9">
					<div class="well well-lg">
						<div id="myCarousel" class="carousel slide" data-ride="carousel">
							<!-- Indicators -->
							<ol class="carousel-indicators">
							    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
							    <li data-target="#myCarousel" data-slide-to="1"></li>
							    <li data-target="#myCarousel" data-slide-to="2"></li>
							    <li data-target="#myCarousel" data-slide-to="3"></li>
							</ol>

							<?php echo MEDIA_URL; ?>

							  <!-- Wrapper for slides -->
							<div class="carousel-inner" role="listbox">
							    <div class="item active">
							        <img src="<?php echo MEDIA_URL; ?>/cases/6/cats/1.jpg" alt="Chania">
							    </div>

							    <div class="item">
							      	<img src="<?php echo MEDIA_URL; ?>/cases/6/cats/2.jpg" alt="Chania">
							    </div>

							    <div class="item">
							      	<img src="<?php echo MEDIA_URL; ?>/cases/6/cats/3.jpg" alt="Flower">
							    </div>

							    <div class="item">
							      	<img src="<?php echo MEDIA_URL; ?>/cases/6/cats/4.jpg" alt="Flower">
							    </div>
							</div>
						</div>
					</div><!-- .well -->
				</div><!-- .col-md-9 -->
			</div><!-- .row -->
		</div><!-- .container -->

		<script src="<?php echo MEDIA_URL; ?>/js/lib/jquery-1.11.1.min.js"></script>
		<script src="<?php echo MEDIA_URL; ?>/js/lib/bootstrap.min.js"></script>
	</body>
</html>
