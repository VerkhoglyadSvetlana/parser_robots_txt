<?php


$checkId = 'xBB_check_1d6ba126-325b-11df-85d2-001bfc5a1282';
if (is_null($_SESSION)) {
    session_start();
}
if (empty($_SESSION[$checkId])) {
    $_SESSION[$checkId] = rand();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Проверка файла robots.txt</title>
</head>
<body>

<h1>Проверка robots.txt</h1>

<form enctype="multipart/form-data" method="post">
<input type="hidden" name="check" value="<?php echo $_SESSION[$checkId]; ?>" />
<table border="0" align="center">
<tr>
<td align="right">Проверяемая страница:</td>
<td align="left">
<input name="page" value="<?php echo htmlspecialchars($page); ?>" size="60" />
</td>
</tr>

<tr>
<td></td>
<td><input type="submit" value="Проверить"/></td>

</tr>
</table>
</form>


<?php

 // $exist_rorots=file_get_contents($page."/robots.txt");


 //&& ! empty($_POST['check']) && $_POST['check'] == $_SESSION[$checkId]) 

if ($_POST['page'])
{
    $page = (string) $_POST['page'];
    $bot = (string) $_POST['bot'];
    include_once './parser_robots_txt/RobotsTxt.php';

    try {
        $robotsTxt = new Xbb_RobotsTxt($page);
        echo '<p>Проверяется robots.txt на сайте <strong>'
           . htmlspecialchars($robotsTxt->getSite()) . '</strong></p>'
           . '<p>Проверяется страница <strong>' . htmlspecialchars($page)
           . '</strong></p>';
        $allow = $robotsTxt->allow($page, $bot);
        echo '<p>Результат проверки: страница <strong>'
           . ($allow ? 'разрешена' : 'запрещена')
           . '</strong> в robots.txt для индексации  <strong>'
           . htmlspecialchars($bot) . '</strong>.</p>';
        $directives = $robotsTxt->getDirectives();
        if (! count($directives)) {
            echo '<p>Файл robots.txt не содержит правильных директив.</p>';
        } else {
            echo '<h2>Разбор файла robots.txt:</h2>';
            foreach ($directives as $k => $v) {
                echo '<p>Директивы для робота <strong>' . htmlspecialchars($k)
                   . '</strong>:</p>'
                   . '<ol>';
	
		
                foreach ($v as $d) {
                    echo '<li>Поле "<strong>' . htmlspecialchars($d[0])
                       . '</strong>" имеет значение "<strong>'
                       . htmlspecialchars($d[1]) . '</strong>".</li>';

                }
                echo '</ol>';

            }


echo "<br/>";

echo "<br/>";

echo "<br/>";

$file_robots = file_get_contents($page.'/robots.txt');// получаем файл robots.txt в переменную $file_robots для дальнейшего анализа
//echo $file_robots; этой строкой можно включить вывод тестируемого файла robots.txt на экран при необходимости

?>

<table border="5" align="center">
<tr>
<td  bgcolor="grey" align="left">№</td>
<td  bgcolor="grey" align="left">Название проверки</td>
<td  bgcolor="grey"align="left">Статус</td>
<td  bgcolor="grey" align="left"> </td>
<td  bgcolor="grey" align="left">Текущее состояние</td>
</td>
</tr>

<?php 
if(true)
//ставим всегда true,нам надо чтобы всегда if выполнялся, т. к. мы находимся в блоке try-он выполнится только если файл robots.txt на хосте есть (создался объект RobotsTxt)
{ ?>
<tr>
<td align="left" rowspan="2">1</td>
<td align="left"rowspan="2">Проверка наличия файла robots.txt</td>
<td bgcolor="green" align="center" rowspan="2">Ок</td>
<td align="left">Состояние </td>
<td align="left">Файл robots.txt присутствует</td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Доработки не требуются</td>
</tr>
<?php
}


if( false){
//ставим false -чтоб никогда невыполнился, т.к.нам пока не нужно выполнение этого if -это просто заглушка для возможного будущего использования
?>

<tr>
<td align="left" rowspan="2">1</td>
<td align="left"rowspan="2">Проверка наличия файла robots.txt</td>
<td bgcolor="red" align="center" rowspan="2">Ошибка</td>
<td align="left">Состояние </td>
<td align="left">Файл robots.txt отсутствует</td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Программист: Создать файл robots.txt и разместить его на сайте</td>
</tr>
<?php
}
?>

<?php
if( stripos($file_robots, "host"))   {
?>

<tr>
<td align="left" rowspan="2">6</td>
<td align="left"rowspan="2">Проверка указания директивы Host</td>
<td bgcolor="green" align="center" rowspan="2">Ок</td>
<td align="left">Состояние </td>
<td align="left">Директива Host указана</td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Доработки не требуются</td>
</tr>

<?php
} else {
?>

<tr>
<td align="left" rowspan="2">6</td>
<td align="left"rowspan="2">Проверка указания директивы Host</td>
<td bgcolor="red" align="center" rowspan="2">Ошибка</td>
<td align="left">Состояние </td>
<td align="left">В файле robots.txt не указана директива Host</td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Программист: Для того, чтобы поисковые системы знали, какая версия сайта является основных зеркалом, необходимо прописать адрес основного зеркала в директиве Host. В данный момент это не прописано. Необходимо добавить в файл robots.txt директиву Host. Директива Host задётся в файле 1 раз, после всех правил.</td>
</tr>

<?php
}
$w=substr_count($file_robots, 'host');

$e=substr_count($file_robots, 'Host');

if ($w==1 || $e==1)
{

?>

<tr>
<td align="left" rowspan="2">8</td>
<td align="left"rowspan="2">Проверка количества директив Host, прописанных в файле</td>
<td bgcolor="green" align="center" rowspan="2">Ок</td>
<td align="left">Состояние </td>
<td align="left">В файле прописана 1 директива Host</td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Доработки не требуются</td>
</tr>
<?php
}
if ($w>1 || $e>1)
{
?>

<tr>
<td align="left" rowspan="2">8</td>
<td align="left"rowspan="2">Проверка количества директив Host, прописанных в файле</td>
<td bgcolor="red" align="center" rowspan="2">Ошибка</td>
<td align="left">Состояние </td>
<td align="left">В файле прописано несколько директив Host</td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Программист: Директива Host должна быть указана в файле толоко 1 раз. Необходимо удалить все дополнительные директивы Host и оставить только 1, корректную и соответствующую основному зеркалу сайта</td>
</tr>


<?php
}
$file_size=0;

for ($i=0; $i<count($http_response_header); $i++)
{
	if(preg_match("/Content-Length/", $http_response_header[$i]))
	{
	$file_size=substr_replace($http_response_header[$i], "", 0, 16);
	}
}

//echo 'Размер файла ' . $filename . ': ' . $file_size. ' байт';


if($file_size && (int)$file_size<32768){
?>
<tr>
<td align="left" rowspan="2">10</td>
<td align="left"rowspan="2">Проверка размера файла robots.txt</td>
<td bgcolor="green" align="center" rowspan="2">Ок</td>
<td align="left">Состояние </td>
<td align="left">Размер файла robots.txt составляет <?php echo $file_size.' байт'?>, что находится в пределах допустимой нормы</td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Доработки не требуются</td>
<?php
}else{
?>
</tr>
<tr>
<td align="left" rowspan="2">10</td>
<td align="left"rowspan="2">Проверка размера файла robots.txt</td>
<td bgcolor="red" align="center" rowspan="2">Ошибка</td>
<td align="left">Состояние </td>
<td align="left">Размера файла robots.txt составляет <?php echo $file_size.' байт'?>, что превышает допустимую норму</td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Программист: Максимально допустимый размер файла robots.txt составляем 32 кб. Необходимо отредактировть файл robots.txt таким образом, чтобы его размер не превышал 32 Кб</td>
</tr>
<?php
}
?>
<?php
if( stripos($file_robots, "sitemap"))   {
?>
<tr>
<td align="left" rowspan="2">11</td>
<td align="left"rowspan="2">Проверка указания директивы Sitemap</td>
<td bgcolor="green" align="center" rowspan="2">Ок</td>
<td align="left">Состояние </td>
<td align="left">Директива Sitemap указана</td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Доработки не требуются</td>
</tr>
<?php
}else{
?>

<tr>
<td align="left" rowspan="2">11</td>
<td align="left"rowspan="2">Проверка указания директивы Sitemap</td>
<td bgcolor="red" align="center" rowspan="2">Ошибка</td>
<td align="left">Состояние </td>
<td align="left">В файле robots.txt не указана директива Sitemap</td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Программист: Добавить в файл robots.txt директиву Sitemap</td>
</tr>
<?php
}





for ($i=0; $i<count($http_response_header); $i++)
{
	if(preg_match("/200 OK/", $http_response_header[$i]))
	{
		//$file_size=substr_replace($http_response_header[$i], "", 0, 16);
			$answer_ok=1;
	}
}

//if(in_array('HTTP/1.1 200 OK', $http_response_header)){
if($answer_ok){

?>

<tr>
<td align="left" rowspan="2">12</td>
<td align="left"rowspan="2">Проверка кода ответа сервера для файла robots.txt</td>
<td bgcolor="green" align="center" rowspan="2">Ок</td>
<td align="left">Состояние </td>
<td align="left">Файл robots.txt отдаёт код ответа сервера 200</td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Доработки не требуются</td>

<?php
}else{
?>
</tr>
<tr>
<td align="left" rowspan="2">12</td>
<td align="left"rowspan="2">Проверка кода ответа сервера для файла robots.txt</td>
<td bgcolor="red" align="center" rowspan="2">Ошибка</td>
<td align="left">Состояние </td>
<td align="left">При обращении к файлу robots.txt сервер возвращает код ответа - <?php echo $http_response_header[0]; ?></td>
</tr>
<tr>
<td align="left">Рекомендации</td>
<td align="left">Программист: Файл robots.txt должны отдавать код ответа 200, иначе файл не будет обрабатываться. Необходимо настроить сайт таким образом, чтобы при обращении к файлу sitemap.xml сервер возвращает код ответа 200</td>
</tr>
<?php
}
?>
</table>



<?php

}
    } catch (Exception $e) {
        echo '<p>Не удалось обработать введенные данные по следющей причине: '
           . '<strong>' . htmlspecialchars($e->getMessage()) . '</strong></p>';

    }
} else {
    $page = $_POST['page'];
    $bot =  $_POST['bot'];
}






?>






</body>
</html>
