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
        <link href="../../css/datepicker.css" rel="stylesheet" >

		<style>
			h4 {
				margin-bottom: 30px;
			}

			.nav-inner {
				margin-left: 10px;
            }

            .form-control {
                width:50%;
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
						<h4>Настройки профиля</h4>

						<?php
						function protectString($message) 
						{
							if (strpos($message, "'") !== FALSE)
							{
							    echo 'Found it';
							}
							else
							{
								echo $message;
							}
						}
						?>

						<?php
						// NOTE: The following code intended for demonstration purposes only.
						//       It is EXTREMELY DANGER to use it for real applications.
						$nick = isset($_GET['nick']) ? $_GET['nick'] : 'xss-hacker';
                        $birthday = isset($_GET['birthday']) ? $_GET['birthday'] : '30/10/1988';
                        $sex = isset($_GET['sex']) ? $_GET['sex'] : 'male';
                        $country = isset($_GET['country']) ? $_GET['country'] : 'Россия';
                        $city = isset($_GET['city']) ? $_GET['city'] : 'Москва';
						$about = isset($_GET['about']) ? $_GET['about'] : '';
						?>

						<?php if ($nick || $birthday || $sex || $country || $city || $about): ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert">&times;</button>
								Профиль изменен!
							</div>
						<?php endif; ?>

						<form method="GET">
						  	<div class="form-group">
						    	<label for="nick">Никнейм</label>
						    	<input type="text" name="nick" class="form-control" id="nick" value="<?php protectString($nick) ?>">
                            </div>
                            <div class="form-group">
                                <label for="birthday">День рождения</label>
                                <input type="text" name="birthday" class="form-control" id="birthday" value="<?php protectString($birthday) ?>">
                            </div>
                            <div class="form-group">
                                <label for="sex">Пол</label>
                                <div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" name="sex" value="male" checked>
                                        Мужской
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" name="sex" value="female">
                                        Женский
                                      </label>
                                    </div>    
                                </div>  
                            </div>       
                            <div class="form-group">
                                <label for="country">Страна</label>
                                <input type="text" name="country" class="form-control" id="country" value="<?php protectString($country) ?>">
                            </div>                                                  
                            <div class="form-group">
                                <label for="city">Город</label>
                                <input type="text" name="city" class="form-control" id="city" value="<?php protectString($city) ?>">
						  	</div>     
						  	<div class="form-group">
						    	<label for="about">О себе</label>
						    	<textarea class="form-control" rows="3" name="about" class="form-control" id="about" value="<?php protectString($about) ?>"></textarea>
						  	</div>                         
						  	<button type="submit" class="btn btn-default">Изменить</button>
						</form>

					</div><!-- .well -->
				</div><!-- .col-md-9 -->
			</div><!-- .row -->
		</div><!-- .container -->

		<script src="../../js/lib/jquery-1.11.1.min.js"></script>
		<script src="../../js/lib/bootstrap.min.js"></script>
        <script src="../../js/lib/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#birthday').datepicker({
                    format: "dd/mm/yyyy"
                });  
            
            });
        </script>


	</body>
</html>
