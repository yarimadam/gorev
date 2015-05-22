<?php

// ekrana hata mesajı bastırır.
function hata($mesaj)
{
	$html = "
		<!doctype html>
		<html>
			<head>
				<meta charset='utf-8'>
				<title>Hata!</title>
			</head>
			<body>
				<p>{$mesaj}</p>
			</body>
		</html>
	";
	die($html);
}

// verilen kişi id'sini "kisi" isimli session'a atar.
function kisi_sec($id)
{
	$_SESSION['kisi'] = $id;
}

// görev yapıldı ise üzerine çizgi çeker.
function gorev_yapildi_tanim($tanim,$yapildi)
{
	if($yapildi)
		return sprintf('<span class="yapildi">%s</span>', $tanim);
	else
		return $tanim;
}

// görev yapıldı ise "yapılmadı" linki, yapıldıysa "yapılmadı" linki oluştur.
function gorev_yapildi_link($id,$yapildi)
{
	if($yapildi)
		return sprintf('<a href="gorev.php?islem=yapilmadi&amp;gorev_id=%s">yapılmadı</a>', $id);
	else
		return sprintf('<a href="gorev.php?islem=yapildi&amp;gorev_id=%s">yapıldı</a>', $id);
}

?>