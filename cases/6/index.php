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

			.carousel img {
				min-width: 100%;
				max-width: none;
			}

			/*this is for the nice file input*/
			.btn-file input[type=file] {
			  	position: absolute;
			  	top: 0;
			  	right: 0;
			  	min-width: 100%;
			  	min-height: 100%;
			  	font-size: 100px;
			  	text-align: right;
			  	filter: alpha(opacity=0);
			  	opacity: 0;
			  	background: red;
			  	cursor: inherit;
			  	display: block;
			}

			input[readonly] {
			  	background-color: white !important;
			  	cursor: text !important;
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
						<form method="POST" action="upload_picture.php" enctype="multipart/form-data" target="hiddenFrame">

							<?php
								$dir = "images";
								$files = preg_grep('/^([^.])/', scandir($dir));
							?>

							<div id="myCarousel" class="carousel slide" data-ride="carousel">

								<!-- Wrapper for slides -->
								<div class="carousel-inner" role="listbox" id="carousel">
								</div>

								 <!-- Left and right controls -->
							  	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
							    	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							    	<span class="sr-only">Previous</span>
							  	</a>
							  	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
							    	<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							    	<span class="sr-only">Next</span>
							  	</a>
							</div>

							<script>
								var files = [<?php echo '"'.implode('","', $files).'"' ?>];
								var carousel = document.getElementById("carousel");

								for (file of files)
								{
									var html  = files.indexOf(file) == 0
										 	  ? '<div class="item active">' 
											  : '<div class="item">';
										html +=		'<img src=images/' + file + '>';
								    	html += '</div>';
								
									carousel.innerHTML += html;
								};
							</script>
							
							<div style="margin-top: 20px; margin-left: 10px; margin-right: 10px;">
								<div class="row">  
						            <div class="input-group">
						                <span class="input-group-btn">
						                    <span class="btn btn-primary btn-file">
						                        Обзор&hellip; 
						                        <input type="file" id="file" name="file">
						                    </span>
						                </span>
						                <input type="text" class="form-control" readonly>
						                <span class="input-group-btn">
					                        <button class="btn btn-success">Добавить добра</button>
						                </span>
						            </div>
							    </div>
						    </div>

						    <!-- TEMP -->
							<iframe style="display: none;" name="hiddenFrame"></iframe>
							<!-- TEMP -->

						</form>
					</div>
				</div>
			</div><!-- .row -->
		</div><!-- .container -->

		<script src="<?php echo MEDIA_URL; ?>/js/lib/jquery-1.11.1.min.js"></script>
		<script src="<?php echo MEDIA_URL; ?>/js/lib/bootstrap.min.js"></script>

		<script>
			// this is for the nice file input
			$(document).on('change', '.btn-file :file', function() {
			    var input = $(this),
			    	numFiles = input.get(0).files ? input.get(0).files.length : 1,
			        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			    input.trigger('fileselect', [numFiles, label]);
			});

			$(document).ready( function() {
			    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
			        
			        var input = $(this).parents('.input-group').find(':text'),
			            log = numFiles > 1 ? numFiles + ' files selected' : label;
			        
			        if( input.length ) {
			            input.val(log);
			        } else {
			            if( log ) alert(log);
			        }			        
			    });
			});
		</script>
	</body>
</html>
