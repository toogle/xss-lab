<?php
require_once('../../config.php');

header('X-XSS-Protection: 0');
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Задание №1 / Лабораторная работа №2. XSS</title>
		<meta name="description" content="XSS Lab">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="<?php echo MEDIA_URL; ?>/css/bootstrap.min.css" rel="stylesheet">

		<style>
			.nav-inner {
				margin-left: 10px;
			}

			.review {
				margin-top: 40px;
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
								<li class="active"><a href=".">Задание №1</a></li>
								<li><a href="../2/">Задание №2</a></li>
								<li><a href="../3/">Задание №3</a></li>
								<li><a href="../4/">Задание №4</a></li>
							</ul>
						</li>
						<li><a href="https://github.com/toogle/sql-lab" target="_blank">Исходный код</a></li>
					</ul>
				</div><!-- .col-md-3 -->

				<div class="col-md-9">
					<div class="well well-lg">
						<div class="row">
							<div class="col-md-4 pull-right">
								<form class="form-inline" method="GET" role="form">
									<div class="input-group">
										<input type="text" class="form-control" name="q" required>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-default">Поиск</button>
										</span>
									</div><!-- .input-group -->
								</form>
							</div><!-- .col-md-4 -->
						</div><!-- .row -->

						<?php
						define('ITEMS_PER_PAGE', 5);

						// NOTE: The following code intended for demonstration purposes only.
						//       It is EXTREMELY DANGER to use it for real applications.
						$conn = @mysqli_connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

						$query = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
						if (isset($_GET['q']))
							echo "<h4>Результаты поиска по запросу «${_GET['q']}»:</h4>";
						else
							echo '<h4>Список книг</h4>';

						$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
						if ($page < 1)
							$page = 1;

						$sql = "SELECT title, author, review FROM books";
						if ($query) {
							$sql .= "  WHERE title LIKE '%${query}%'" .
							        "    OR author LIKE '%${query}%'" .
							        "    OR review LIKE '%${query}%'";
						}
						$sql .= "  LIMIT " . ITEMS_PER_PAGE .
						        "  OFFSET " . ($page - 1) * ITEMS_PER_PAGE;

						$res = mysqli_query($conn, $sql);
						if ($res) {
							while ($row = mysqli_fetch_assoc($res)) {
								echo '<div class="review">',
								     "  <h5>${row['title']} <small>(${row['author']})</small></h5>",
								     "  <p><i>${row['review']}</i></p>",
								     '</div>';
							}

							mysqli_free_result($res);

							// Pagination.
							$sql = "SELECT COUNT(1) AS count FROM books";
							if ($query) {
								$sql .= "  WHERE title LIKE '%${query}%'" .
								        "    OR author LIKE '%${query}%'" .
								        "    OR review LIKE '%${query}%'";
							}

							$res = mysqli_query($conn, $sql);
							if ($res) {
								$row = mysqli_fetch_assoc($res);
								$count = $row['count'];

								if ($count > 0) {
									echo '<ul class="pagination">';

									// Previous page.
									if ($page > 1)
										echo '<li><a href="?page=' . ($page - 1) . (isset($_GET['q']) ? "&q=${_GET['q']}" : '') . '">&laquo;</a></li>';
									else
										echo '<li class="disabled"><a href="#">&laquo;</a></li>';

									for ($i = 1; $i <= ceil($count / ITEMS_PER_PAGE); $i++) {
										echo ($i == $page) ? '<li class="active">' : '<li>';
										echo '  <a href="?page=' . $i . (isset($_GET['q']) ? "&q=${_GET['q']}" : '') . '">' . $i . '</a>';
										echo '</li>';
									}

									// Next page.
									if ($page < ceil($count / ITEMS_PER_PAGE))
										echo '<li><a href="?page=' . ($page + 1) . (isset($_GET['q']) ? "&q=${_GET['q']}" : '') . '">&raquo;</a></li>';
									else
										echo '<li class="disabled"><a href="#">&raquo;</a></li>';

									echo '</ul>';
								}

								mysqli_free_result($res);
							}
						}

						mysqli_close($conn);
						?>
					</div><!-- .well -->
				</div><!-- .col-md-9 -->
			</div><!-- .row -->
		</div><!-- .container -->
	</body>
</html>
