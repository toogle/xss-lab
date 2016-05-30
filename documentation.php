<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Методическое пособие / Лабораторная работа №2. XSS</title>
		<meta name="description" content="XSS Lab">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="<?php echo MEDIA_URL; ?>/css/bootstrap.min.css" rel="stylesheet">

		<style>
			h4 {
				margin-top: 25px;
			}

			img {
				margin-top: 10px;
			}

			.nav-inner {
				margin-left: 10px;
			}

			.callout { 
				border-left: 5px solid #EEEEEE;
				margin: 20px 0px;
				padding: 15px 30px 15px 15px;
			}
			.callout-info { 
				background-color: #F0F7FD;
				border-color: #D0E3F0;
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
						<li><a href=".">Главная</a></li>
						<li class="active">
							<a href="#">Методическое пособие</a>
							<ul class="nav nav-pills nav-stacked nav-inner">
								<li><a href="#classification">Классификация XSS</a></li>
								<li><a href="#mitigation">Предотвращение XSS</a></li>
								<li><a href="#utf-7">Кодировка UTF-7</a></li>
								<li><a href="#materials">Дополнительные материалы</a></li>
							</ul>
						</li>
						<li>
							<a class="accordion-toggle" href="#cases" data-toggle="collapse">Рабочее задание</a>
							<ul id="cases" class="nav nav-pills nav-stacked nav-inner collapse">
								<li><a href="cases/1/">Задание №1</a></li>
								<li><a href="cases/2/">Задание №2</a></li>
								<li><a href="cases/3/">Задание №3</a></li>
								<li><a href="cases/4/">Задание №4</a></li>
								<li><a href="cases/5/">Задание №5</a></li>
							</ul>
						</li>
						<li><a href="https://github.com/toogle/xss-lab" target="_blank">Исходный код</a></li>
					</ul>
				</div><!-- .col-md-3 -->

				<div class="col-md-9">
					<div class="well well-lg">
						<p>
							Межсайтовое выполнение сценариев (англ. <i>Сross Site Sсriрting</i> или <i>XSS</i>) &mdash; атака
							на веб-сайты, заключаюшаяся во внедрении в документ вредоносного кода, который будет выполнен в
							браузере жертвы. Специфика подобных атак заключается в том, что вредоносный код может использовать
							авторизацию пользователя в веб-системе для получения к ней расширенного доступа или для получения
							авторизационных данных пользователя. Это может быть достигнуто путём взаимодействия внедрённого
							кода с веб-сервером злоумышленника.
						</p>

						<h4 id="classification">Классификация XSS</h4>
						<p>
							Межсайтовое выполнение сценариев принято классифицировать по двум критериям: вектору и способу
							воздействия. По вектору воздействия XSS делится на:
							<ul>
								<li>
									<b>отражённую</b> (англ. <i>reflected</i>) &mdash; возвращаемую сервером в ответ на тот же
									запрос, в котором был передан вредоносный код;
								</li>
								<li>
									<b>устойчивую</b> (англ. <i>stored</i>) &mdash; сохраняемую на сервере и доступную во всех
									ответах на один и тот же запрос, не содержащий вредоносного кода;
								</li>
								<li>
									<b>основанную на объектной модели документа</b> (англ. <i>DOM-based</i>) &mdash; проведение
									которой возможно без отправки каких-либо запросов на сервер.
								</li>
							</ul>

							По способу воздействия XSS может быть:
							<ul>
								<li>
									<b>активная</b> &mdash; не требующая каких-либо лишних действий со стороны пользователя с
									точки зрения функционала веб-приложения;
								</li>
								<li>
									<b>пассивная</b> &mdash; срабатывающая при выполнении пользователем определённого действия
									(клик или наведение указателя мыши и т.п.)
								</li>
							</ul>
						</p>

						<p>
							<i>Отражённая</i> XSS возникает в случае, когда переданные в запросе данные используются сервером
							для генерации страницы без надлежащей обработки. Это позволяет злоумышленнику передать вредоносный
							код, который будет внедрён в документ, например в одном из параметров запроса GET. При переходе по
							такой ссылке, вредоносный код будет выполнен в контексте текущего пользователя веб-системы, т.е. он
							может получить доступ к авторизационным данным пользователя в идентификаторах <i>Cookie</i> или
							совершать запросы от лица авторизованного пользователя.
						</p>

						<p>
							К примеру, приведённый ниже код на языке PHP пытается получить страницу с информацией о пользователе,
							имя которого передано в параметре <tt>username</tt>:
<pre><code><font color="#009900">$username</font> <font color="#990000">=</font> <font color="#009900">$_GET</font><font color="#990000">[</font><font color="#FF0000">'username'</font><font color="#990000">];</font>
<font color="#009900">$result</font> <font color="#990000">=</font> <b><font color="#000000">mysql_query</font></b><font color="#990000">(</font><font color="#FF0000">"SELECT * FROM users WHERE username = '$username'"</font><font color="#990000">);</font>
<b><font color="#0000FF">if</font></b> <font color="#990000">(</font><b><font color="#000000">mysql_num_rows</font></b><font color="#990000">(</font><font color="#009900">$result</font><font color="#990000">)</font> <font color="#990000">==</font> <font color="#993399">0</font><font color="#990000">)</font> <font color="#FF0000">{</font>
	<b><font color="#0000FF">print</font></b> <font color="#FF0000">"Пользователь '$username' не найден!"</font><font color="#990000">;</font>
<font color="#FF0000">}</font> <b><font color="#0000FF">else</font></b> <font color="#FF0000">{</font>
	<i><font color="#9A1900">// Вывод информации о пользователе…</font></i>
<font color="#FF0000">}</font></code></pre>
						</p>

						<p>
							Поскольку значение параметра <tt>username</tt> никак не обрабатывается перед выводом, существует
							возможность передать в нём HTML-код, например <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code>.
							Этот код будет внедрён в ответ сервера и вредоносный сценарий на языке JavaScript будет выполнен
							браузером в контексте уязвимого веб-приложения.
						</p>

						<p>
							Важно отметить, что вредоносный код для внедрения в документ необходимо передавать при каждом
							запросе к серверу. Это позволяет обнаружить атаку такого типа как на стороне клиента (путём
							тщательного рассмотрения адресной строки браузера), так и на стороне сервера при помощи
							межсетевых экранов уровня приложения (<abbr title="Web Application Firewall">WAF</abbr>).
						</p>

						<p>
							Типовой сценарий реализации отражённой XSS представлен на рисунке.

							<img src="<?php echo MEDIA_URL; ?>/img/reflected-xss.png" class="img-responsive">

							<ol>
								<li>
									Злоумышленник подготавливает <abbr title="Unified Resource Link">URL</abbr>, содержащий
									вредоносный код, и передаёт его жертве.
								</li>
								<li>
									Жертва переходит по полученному URL.
								</li>
								<li>
									Уязвимый веб-сайт включает вредоносный код из URL в документ и выдаёт его пользователю.
								</li>
								<li>
									Браузер жертвы выполняет вредоносный сценарий и передаёт авторизационные данные на
									сервер злоумышленника.
								</li>
							</ol>
						</p>

						<p>
							Другой по вектору воздействия тип XSS &mdash; <i>устойчивая</i>. При таких атаках вредоносный код
							сохраняется на сервере (в базе данных, файловой системе или другом месте) и выдаётся пользователю
							без надлежащей обработки. Этот тип XSS актуален для динамических веб-приложений, которые позволяют
							сохранять пользовательские данные на сервере: социальных сетей, форумов, блогов и т.д.
						</p>

						<p>
							Для реализации устойчивой XSS нет необходимости передавать вредоносный код с каждым запросом
							к серверу. Таким образом, обнаружение атаки такого типа невозможно на стороне клиента и
							затруднительно на стороне сервера, поскольку отследить передачу вредоносного кода можно только
							в момент его сохранения на сервере.
						</p>

						<p>
							Типовой сценарий реализации устойчивой XSS представлен на рисунке.

							<img src="<?php echo MEDIA_URL; ?>/img/persistent-xss.png" class="img-responsive">

							<ol>
								<li>
									Злоумышленник использует одну из форм веб-сайта для сохранения вредоносного кода на
									сервере.
								</li>
								<li>
									Жертва производит запрос к веб-странице.
								</li>
								<li>
									Уязвимый веб-сайт включает вредоносный код из хранилища в документ и выдаёт его
									пользователю.
								</li>
								<li>
									Браузер жертвы выполняет вредоносный сценарий и передаёт авторизационные данные на
									сервер злоумышленника.
								</li>
							</ol>
						</p>

						<p>
							XSS, <i>основанная на объектной модели документа</i>, использует уязвимости клиентской части
							веб-приложения. К примеру, если сценарий JavaScript имеет доступ к параметру URL и формирует
							HTML-код на странице, используя эту информацию, при этом не обрабатывая её надлежащим
							образом, то возможно внедрить в документ вредоносный код, изменив соответствующий параметр
							URL.
						</p>

						<p>
							Типовой сценарий реализации XSS, основанной на объектной модели документа, представлен на
							рисунке.

							<img src="<?php echo MEDIA_URL; ?>/img/dom-based-xss.png" class="img-responsive">

							<ol>
								<li>
									Злоумышленник подготавливает URL, содержащий вредоносный код, и передаёт его
									жертве.
								</li>
								<li>
									Жертва переходит по полученному URL.
								</li>
								<li>
									Уязвимый веб-сайт обрабатывает запрос, но не включает вредоносный код в документ.
								</li>
								<li>
									Браузер жертвы выполняет сценарии клиентской части веб-сайта, которые модифицируют
									документ, включая в него вредоносный код из URL.
								</li>
								<li>
									Браузер жертвы выполняет вредоносный сценарий и передаёт авторизационные данные на
									сервер злоумышленника.
								</li>
							</ol>
						</p>

						<h4 id="mitigation">Предотвращение XSS</h4>
						<p>
							Для предотвращения внедрения вредоносных сценариев необходимо во всех местах, где данные
							покидают пределы приложения, обеспечить их приведение к виду, безопасному для принимающей
							стороны. Как правило, это достигается путем удаления из них небезопасных элементов
							(фильтрации) или же их преобразования к безопасным эквивалентам (экранировании).
						</p>

						<p>
							Для экранирования данных в языке PHP применяет функция
							<a href="http://www.php.net/manual/en/function.htmlspecialchars.php"><tt>htmlspecialchars()</tt></a>.
							Она приводит все небезопасные элементы к безопасным HTML-эквивалентам. Например, символ
							<tt>&lt;</tt> заменяется на <tt>&amp;lt;</tt>, а уже браузер преобразует эту последовательность
							обратно к символу угловой скобки.
						</p>

						<h4 id="utf-7">Кодировка UTF-7</h4>
						<p>
							UTF-7 допускает несколько представлений для одной и той же строки. В частности, альтернативные
							представления допускаются для символов ASCII. В результате, если процедуры экранирования и проверки
							проводятся над строкой, которая впоследствии может быть интерпретирована как строка в кодировке
							UTF-7, альтернативные варианты кодирования могут быть использованы для обхода этих процедур.
						</p>

						<p>
							В случае, если тег <tt>&lt;title&gt;</tt> расположен до тега <tt>&lt;meta&gt;</tt>, устанавливающего
							кодировку страницы, и заполняется пользовательскими данными, злоумышленник может вставить вредоносный
							код в кодировке UTF-7, обойдя таким образом фильтрацию таких символов, как <tt>&lt;</tt>, <tt>&gt;</tt>
							и <tt>"</tt>.
						</p>

						<p>
							Для предотвращения подобных проблем приложения должны проводить проверки после декодирования строк и не
							пытаться автоматически использовать кодировку UTF-7.
						</p>

						<div class="callout callout-info">
							HTML5 запрещает поддержку браузерами кодировки UTF-7 как потенциально опасной. Из современных браузеров
							эта уязвимость актуальна только для Internet Explorer.
						</div>

						<h4 id="materials">Дополнительные материалы</h4>
						<ol>
							<li><a href="https://code.google.com/p/domxsswiki/w/list">DOM XSS Wiki</a></li>
							<li><a href="http://openmya.hacker.jp/hasegawa/security/utf7cs.html">UTF-7 XSS Cheat Sheet</a></li>
							<li><a href="http://ha.ckers.org/xsscalc.html">XSS Cheat Sheet Calculator</a></li>
						</ol>
					</div><!-- .well -->
				</div><!-- .col-md-9 -->
			</div><!-- .row -->
		</div><!-- .container -->

		<script src="<?php echo MEDIA_URL; ?>/js/lib/jquery-1.11.1.min.js"></script>
		<script src="<?php echo MEDIA_URL; ?>/js/lib/bootstrap.min.js"></script>
	</body>
</html>
