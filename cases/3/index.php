<?php require_once('../../config.php'); ?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Задание №3 / Лабораторная работа №2. XSS</title>
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
								<li class="active"><a href=".">Задание №3</a></li>
								<li><a href="../4/">Задание №4</a></li>
							</ul>
						</li>
						<li><a href="https://github.com/toogle/xss-lab" target="_blank">Исходный код</a></li>
					</ul>
				</div><!-- .col-md-3 -->

				<div class="col-md-9">
					<div class="well well-lg">
						<img src="<?php echo MEDIA_URL; ?>/cases/3/img/google.jpg" class="img-responsive" id="main-image">
						<h4 id="main-name">google</h4>
						<hr>

						<a href="#google"><img src="<?php echo MEDIA_URL; ?>/cases/3/img/google.jpg" class="img-thumbnail"></a>
						<a href="#ibm"><img src="<?php echo MEDIA_URL; ?>/cases/3/img/ibm.jpg" class="img-thumbnail"></a>
						<a href="#paypal"><img src="<?php echo MEDIA_URL; ?>/cases/3/img/paypal.jpg" class="img-thumbnail"></a>
						<a href="#pingfm"><img src="<?php echo MEDIA_URL; ?>/cases/3/img/pingfm.jpg" class="img-thumbnail"></a>
						<a href="#yahoo"><img src="<?php echo MEDIA_URL; ?>/cases/3/img/yahoo.jpg" class="img-thumbnail"></a>
					</div><!-- .well -->
					
					<div class="panel panel-default">
						<div class="panel-heading">
							Подсказка
							<a href="#" class="pull-right" data-toggle="collapse" data-target="#hint">показать</a>
						</div>
						<div id="hint" class="panel-body collapse">
							<p>
								Это задание имитирует простейшее средство онлайн-просмотра фотоальбомов. Результатом 
								реализации XSS-инъекции будет URL с этого сайта, при переходе по которому в браузере
								выполняется некоторый вредоносный скрипт.
							</p>

							<p>
								На некоторых страницах сайта может вообще не быть взаимодействия с сервером, однако
								это не гарантирует защиты от XSS. Для XSS, основанной на объектной модели документа
								(<i>DOM-based</i>), достаточно того, чтобы какой-нибудь сценарий JavaScript на странице 
								имел <u>доступ</u> к параметру URL и формировал страницу, задействуя его (без необходимых 
								проверок). Такое может быть, например, при использовании <i>локальных ссылок</i> для навигации 
								по текущей странице.
							</p>
						</div>
					</div>
				</div><!-- .col-md-9 -->
			</div><!-- .row -->
		</div><!-- .container -->

		<script src="<?php echo MEDIA_URL; ?>/js/lib/jquery-1.11.1.min.js"></script>
		<script src="<?php echo MEDIA_URL; ?>/js/lib/bootstrap.min.js"></script>
		<script>
			$(function() {
				$(window).bind('hashchange', function() {
					// NOTE: The following code intended for demonstration purposes only.
					//       It is EXTREMELY DANGER to use it for real applications.
					var name = location.hash.slice(1);

					$('#main-name').html(name);
					$('#main-image').attr('src', '<?php echo MEDIA_URL; ?>/cases/3/img/' + name + '.jpg');
				});
			});
		</script>
		<script>
			$('#hint').on('show.bs.collapse', function() {
				$('a[data-target="#hint"]').html('скрыть');
			});

			$('#hint').on('hide.bs.collapse', function() {
				$('a[data-target="#hint"]').html('показать');
			});
		</script>
	</body>
</html>
