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

                <?php
                    // NOTE: The following code intended for demonstration purposes only.
                    //       It is EXTREMELY DANGER to use it for real applications.
                    function validate($input)
                    {
                        $output = $input;

                        if (strpos($output, "//") !== FALSE)
                        {
                            $output = str_replace("//", "", $output); 
                            $output = str_replace("http:", "", $output);
                        }

                        return $output;
                    }

                    $randomSite = $_COOKIE['randomSite'];
                	if (empty($randomSite))
                	{
                		$sites = file("sites-list.txt");
                    	$randomSite = $sites[array_rand($sites)];
                    	setcookie('randomSite', $randomSite);	
                	}        

                    $nick = isset($_GET['nick']) ? $_GET['nick'] : 'xss-hacker';
                    $birthday = isset($_GET['birthday']) ? $_GET['birthday'] : '30/11/1988';
                    $country = isset($_GET['country']) ? $_GET['country'] : 'Россия';
                    $city = isset($_GET['city']) ? $_GET['city'] : 'Москва';
                    $about = isset($_GET['about']) ? $_GET['about'] : '';
                ?>

                <div class="col-md-9">
                    <div class="well well-lg">
                        <h4>Настройки профиля</h4>

                        <form id="profile" method="GET" onsubmit="prepare()">
                            <div class="form-group">
                                <label for="nick">Никнейм</label>
                                <input type="text" name="nick" class="form-control" id="nick" value="<?= validate($nick) ?>" onchange="add('nick')">
                            </div>
                            <div class="form-group">
                                <label for="birthday">День рождения</label>
                                <input type="text" name="birthday" class="form-control" id="birthday" value="<?= validate($birthday) ?>" onchange="add('birthday')">
                            </div>
                            <div class="form-group">
                                <label for="sex">Пол</label>
                                <div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" name="sex" id="male" checked>
                                        Мужской
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" name="sex" id="female">
                                        Женский
                                      </label>
                                    </div>    
                                </div>  
                            </div>       
                            <div class="form-group">
                                <label for="country">Страна</label>
                                <input type="text" name="country" class="form-control" id="country" value="<?= validate($country) ?>" onchange="add('country')">
                            </div>                                                  
                            <div class="form-group">
                                <label for="city">Город</label>
                                <input type="text" name="city" class="form-control" id="city" value="<?= validate($city) ?>" onchange="add('city')">
                            </div>     
                            <div class="form-group">
                                <label for="about">О себе</label>
                                <textarea class="form-control" rows="3" name="about" class="form-control" id="about" value="<?= validate($about) ?>" onchange="add('about')"></textarea>
                            </div>                         
                            <button type="submit" class="btn btn-default">Изменить</button>
                        </form>
                    </div><!-- .well -->

                    <div class="panel panel-default">
						<div class="panel-heading">
							Подсказка
							<a href="#" class="pull-right" data-toggle="collapse" data-target="#hint">показать</a>
						</div>
						<div id="hint" class="panel-body collapse">
							<p>
								XSS зачастую используется для атак типа <font color="gray">URL Redirection</font>. 
								Цель злоумышленника - сформировать и отправить пользователю ссылку, 
								в начале которой будет адрес подлинного веб-ресурса, 
								а дальше - код, перенаправляющий на страницу злоумышленника.

								Например: 
								<pre>http://www.well-known-site.com/?q=&lt;script&gt;document.location='http://very-bad-site.com'&lt;/script&gt;</pre>
								
								На месте <font color="blue">"http://very-bad-site"</font> 
								может быть некий рекламный ресурс или 
								phishing-сайт (<font color="blue">"http://well-kn0wn-site.com"</font>) 
								для кражи пользовательских данных. 
								
								Если в ссылку добавить "мусора", даже грамотный пользователь, 
								взглянув на нее, может не увидеть подвох. 
							</p>

							<p>
								Разработчик данного сайта был в курсе таких атак, однако вместо готовых 
								и проверенных решений реализовал свою собственную защиту, вырезающую из 
								пользовательского ввода символы, символизирующие URL-адрес. 
								Для обхода таких ограничений можно использовать методы объекта String, 
								например <a href="http://www.w3schools.com/jsref/jsref_fromcharcode.asp">String.fromCharCode()</a>.
							</p>

							<p>
								Попробуйте сформировать ссылку, перенаправляющую пользователя на
								<font color='blue'><?= $randomSite ?></font>.
							</p>
						</div>
					</div>
                </div><!-- .col-md-9 -->
            </div><!-- .row -->
        </div><!-- .container -->

        <script src="../../js/lib/jquery-1.11.1.min.js"></script>
        <script src="../../js/lib/bootstrap.min.js"></script>
        <script src="../../js/lib/bootstrap-datepicker.js"></script>
        
        <script type="text/javascript">

        tosubmit = []

        function add(name) 
        {
            if(tosubmit.indexOf(name) == -1)
            {
                tosubmit.push(name);
            }
        }

        function is_changed(name) 
        {
            for(var k = 0; k < tosubmit.length; k++)
              if(name == tosubmit[k])
                return name && true;
            return false;
        }

        function prepare()
        {
            var allElements = document.getElementById("profile").elements;
            
            for(var k = 0; k < allElements.length; k++) 
            {
              var name = allElements[k].name;
              if(!is_changed(name))
                allElements[k].disabled = true;
            }
        }

        // When the document is ready
        $(document).ready(function () {
            
            $('#birthday').datepicker({
                format: "dd/mm/yyyy"
            });  
        
        });
        </script>


    </body>
</html>
