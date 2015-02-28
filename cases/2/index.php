<?php
if (isset($_COOKIE['__uid'])) {
	$uid = intval($_COOKIE['__uid']);
} else {
	$uid = rand();

	setcookie('__uid', $uid);  // save the uid in a cookie
}

$conn = mysqli_connect('localhost', 'xss-lab', 'xss-lab', 'xss-lab');

if (isset($_GET['id'])) {
	$id = intval($_GET['id']);

	$sql = "SELECT title FROM posts" .
		   "  WHERE uid = ${uid} AND id = ${id}";

	$res = mysqli_query($conn, $sql);
	if ($res) {
		$row = mysqli_fetch_assoc($res);
		$title = $row['title'];

		mysqli_free_result($res);
	}

	if (!isset($title) || !$title)
		$title = 'Запись не найдена!';
} else {
	$title = 'Задание №2 / Лабораторная работа №2. XSS';
}
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<title><?= $title; ?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="XSS Lab">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="../../css/bootstrap.min.css" rel="stylesheet">

		<style>
			.nav-inner {
				margin-left: 10px;
			}

			.post {
				margin-bottom: 20px;
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
								<li class="active"><a href=".">Задание №2</a></li>
								<li><a href="../3/">Задание №3</a></li>
								<li><a href="../4/">Задание №4</a></li>
							</ul>
						</li>
						<li><a href="https://github.com/toogle/xss-lab" target="_blank">Исходный код</a></li>
					</ul>
				</div><!-- .col-md-3 -->

				<div class="col-md-9">
					<div class="well well-lg">
						<?php
						// NOTE: The following code intended for demonstration purposes only.
						//       It is EXTREMELY DANGER to use it for real applications.
						if (isset($_POST['text'])) {
							$text = mysqli_real_escape_string($conn, $_POST['text']);

							if (isset($_POST['title']) && $_POST['title'] != '')
								$title = mysqli_real_escape_string($conn, $_POST['title']);
							else if (strlen($text) <= 24)
								$title = $text;
							else
								$title = mb_substr($text, 0, 24, 'UTF-8') . ' ...';

							$sql = "INSERT INTO posts(uid, title, text)" .
							       "  VALUES (${uid}, '${title}', '${text}')";

							$res = mysqli_query($conn, $sql);
							if (!$res) {
								echo '<div class="alert alert-danger">',
								     '  <button type="button" class="close" data-dismiss="alert">&times;</button>',
								     '  Произошла ошибка при добавлении записи!',
								     '</div>';
							}
						} else if (isset($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'delete') {
							$id = intval($_POST['id']);

							$sql = "DELETE FROM posts" .
							       "  WHERE uid = ${uid} AND id = ${id}";

							$res = mysqli_query($conn, $sql);
							if (!$res) {
								echo '<div class="alert alert-danger">',
								     '  <button type="button" class="close" data-dismiss="alert">&times;</button>',
								     '  Произошла ошибка при удалении записи!',
								     '</div>';
							}
						}

						if (isset($_GET['id'])) {
							$id = intval($_GET['id']);

							$sql = "SELECT title, text, time FROM posts" .
							       "  WHERE uid = ${uid} AND id = ${id}";

							$res = mysqli_query($conn, $sql);
							if ($res) {
								$row = mysqli_fetch_assoc($res);

								echo '<div class="post">',
								     '  <h4>' . htmlspecialchars($row['title']) . '</h4>',
								     '  <p>' . htmlspecialchars($row['text']) . '</p>',
								     '  <p><i>' . $row['time'] . '</i></p>',
								     '</div>';

								mysqli_free_result($res);

								echo '<form action="." method="POST" role="form">',
								     '  <input type="hidden" name="id" value="' . $id . '">',
								     '  <input type="hidden" name="action" value="delete">',
								     '  <a href="." class="btn btn-default">Назад</a>',
								     '  <button type="submit" class="btn btn-danger">Удалить</button>',
								     '</form>';
							}
						} else {
							$sql = "SELECT id, title, text, time FROM posts" .
							       "  WHERE uid = ${uid}" .
							       "  ORDER BY time DESC";

							$res = mysqli_query($conn, $sql);
							if ($res) {
								if (mysqli_num_rows($res) > 0) {
									while ($row = mysqli_fetch_assoc($res)) {
										echo '<div class="post">',
										     '  <a href="?id=' . $row['id'] . '"',
											 '    <h4>' . htmlspecialchars($row['title']) . '</h4>',
										     '  </a>',
										     '  <p>' . htmlspecialchars($row['text']) . '</p>',
										     '  <p><i>' . $row['time'] . '</i></p>',
										     '</div>';
									}
								} else {
									echo '<div class="post">Пока здесь нет записей!</div>';
								}

								mysqli_free_result($res);

								echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#create-modal">Создать</button>';
							}
						}

						mysqli_close($conn);
						?>
					</div><!-- .well -->
				</div><!-- .col-md-9 -->
			</div><!-- .row -->

			<div class="modal fade" id="create-modal" tabindex="-1" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Создать запись</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" id="create-form" method="POST" role="form">
								<div class="form-group">
									<label for="title-field" class="control-label col-md-2">Заголовок</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="title-field" name="title" autofocus>
									</div>
								</div>
								<div class="form-group">
									<label for="text-field" class="control-label col-md-2">Текст</label>
									<div class="col-md-6">
										<textarea class="form-control" id="text-field" name="text" rows="3" required></textarea>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
							<button type="submit" class="btn btn-primary" form="create-form">Создать</button>
						</div>
					</div><!-- .modal-content -->
				</div><!-- .modal-dialog -->
			</div><!-- .modal -->
		</div><!-- .container -->

		<script src="../../js/lib/jquery-1.11.1.min.js"></script>
		<script src="../../js/lib/bootstrap.min.js"></script>
	</body>
</html>
