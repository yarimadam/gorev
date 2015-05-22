<?php

// ayarlar yükleniyor.
include_once('ayar.php');

// "islem" isimli query string değişkeni $islem değişkenine atanıyor.
$islem = $_GET['islem'];

// işlem değişkeni "kisi_ekle" ise çalışacak bölüm.
if($islem == 'kisi_ekle')
{
	// kişi ismi alınıyor.
	$kisi_isim = $_POST['kisi_isim'];
	
	if(empty($kisi_isim))
	{
		// gönderilen kişi ismi boş ise veritabanına ekleme.
		$bilgi_mesaji = 'kişi ismi boş olmamalı.';
	}
	else
	{
		// veritabanına yeni kişi ekle.
		$kisi = new Kisi();
		$kisi->kisi_isim = $kisi_isim;
		$kisi->yeni();
		$bilgi_mesaji = 'yeni kişi eklendi.';
	}
}

// işlem değişkeni "kisi_sil" ise çalışacak bölüm
if($islem == 'kisi_sil')
{
	$kisi = new Kisi();
	$kisi->kisi_id = $_GET['kisi_id'];
	$kisi->sil();
	$bilgi_mesaji = 'kişi veritabanından silindi.';
}

// işlem değişkeni "kisi_sec" ise çalışacak bölüm
if($islem == 'kisi_sec')
{
	// kişi seç.
	kisi_sec($_GET['kisi_id']);
	
	// görev sayfasına yönlendir.
	header('location: gorev.php');
}

// kişi listesini al.
$kisi = new Kisi();
$kisi_listesi = $kisi->liste();

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Kişi Listesi</title>
</head>

<body>

<?php if($bilgi_mesaji) : ?>
<p><strong>bilgi mesajı:</strong> <?php echo $bilgi_mesaji; ?></p>
<?php endif; ?>

<h1>Kişi Listesi</h1>
<table border="1">
	<tr>
		<th width="35">No</th>
		<th width="175">İsim</th>
		<th width="70">İşlem</th>
	</tr>
	<?php if($kisi_listesi->num_rows) : ?>
		<?php while($kisi = mysqli_fetch_assoc($kisi_listesi)) : ?>
		<tr>
			<td align="center"><?php echo $kisi['id']; ?></td>
			<td><?php echo $kisi['isim']; ?></td>
			<td align="center"><a href="kisi.php?islem=kisi_sil&amp;kisi_id=<?php echo $kisi['id']; ?>">sil</a> | <a href="kisi.php?islem=kisi_sec&amp;kisi_id=<?php echo $kisi['id']; ?>">seç</a></td>
		</tr>
		<?php endwhile; ?>
	<?php else : ?>
	<tr>
		<td colspan="3"><p>veritabanında kayıt bulunamadı.</p></td>
	</tr>
	<?php endif; ?>
</table>

<h2>Kişi Ekle</h2>
<form action="kisi.php?islem=kisi_ekle" method="post">
	<table border="1" cellpadding="5" cellspacing="2">
		<tr>
			<td width="90">Kişi İsmi:</td>
			<td><input type="text" name="kisi_isim"></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" value="Ekle"></td>
		</tr>
	</table>
</form>
</body>
</html>