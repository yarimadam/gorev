<?php

// ayarlar yükleniyor.
include_once('ayar.php');

// "islem" isimli query string değişkeni $islem değişkenine atanıyor.
$islem = $_GET['islem'];

// seçilen kişinin id'sini session'dan alır.
$kisi_id = $_SESSION['kisi'];

// kişi seçimi yapılmamışsa çalışacak bölüm.
if(empty($kisi_id))
{
	hata('henüz kişi seçimi yapılmamış. lütfen bir <a href="kisi.php">kişi seçin.</a>');
}

// işlem değişkeni "gorev_ekle" ise çalışacak bölüm
if($islem == 'gorev_ekle')
{
	if(empty($_POST['gorev_tanim']))
	{
		// gönderilen görev tanımı boş ise veritabanına ekleme.
		$bilgi_mesaji = 'görev tanımı boş olmamalı.';
	}
	else if(empty($_POST['gorev_tarih']))
	{
		// gönderilen görev tarihi boş ise veritabanına ekleme.
		$bilgi_mesaji = 'görev tarihi boş olmamalı.';
	}
	else
	{
		// veritabanına yeni görev ekle.
		$gorev = new Gorev();
		$gorev->gorev_tanim = $_POST['gorev_tanim'];
		$gorev->gorev_onem = $_POST['gorev_onem'];
		$gorev->gorev_tarih = $_POST['gorev_tarih'];
		$gorev->gorev_yapildi = 0;
		$gorev->kisi_id = $kisi_id;
		$gorev->yeni();
		$bilgi_mesaji = 'yeni görev eklendi.';
	}
}

// işlem değişkeni "gorev_sil" ise çalışacak bölüm
if($islem == 'gorev_sil')
{
	$gorev = new Gorev();
	$gorev->gorev_id = $_GET['gorev_id'];
	$gorev->sil();
	$bilgi_mesaji = 'görev veritabanından silindi.';
}

// işlem değişkeni "yapildi" ise çalışacak bölüm
if($islem == 'yapildi')
{
	$gorev = new Gorev();
	$gorev->gorev_id = $_GET['gorev_id'];
	$gorev->yapildi();
	$bilgi_mesaji = 'görev yapıldı olarak işaretlendi.';
}

// işlem değişkeni "yapildi" ise çalışacak bölüm
if($islem == 'yapilmadi')
{
	$gorev = new Gorev();
	$gorev->gorev_id = $_GET['gorev_id'];
	$gorev->yapilmadi();
	$bilgi_mesaji = 'görev yapılmadı olarak işaretlendi.';
}

// seçilen kişinin adını al.
$kisi = new Kisi();
$kisi->kisi_id = $kisi_id;
$kisi_isim = $kisi->isim_getir();

// görev listesini al.
$gorev = new Gorev();
$gorev->kisi_id = $kisi_id;
$gorev_listesi = $gorev->liste();

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Görev Listesi</title>
<style>
.yapildi {
	text-decoration:line-through;
}
</style>
</head>

<body>
<p><small>seçilen kişi: <?php echo $kisi_isim; ?><br><a href="kisi.php">başka kişi seç</a></small></p>

<?php if($bilgi_mesaji) : ?>
<p><strong>bilgi mesajı:</strong> <?php echo $bilgi_mesaji; ?></p>
<?php endif; ?>

<h1>Görev Listesi</h1>
<table border="1">
	<tr>
		<th width="35">No</th>
		<th width="300">Tanım</th>
		<th width="70">Önem</th>
		<th width="150">Tarih</th>
		<th width="100">İşlemler</th>
	</tr>
	<?php if($gorev_listesi->num_rows) : ?>
		<?php while($gorev = mysqli_fetch_assoc($gorev_listesi)) : ?>
		<tr>
			<td align="center"><?php echo $gorev['id']; ?></td>
			<td><?php echo gorev_yapildi_tanim($gorev['tanim'],$gorev['yapildi']); ?></td>
			<td><?php echo $gorev['onem']; ?></td>
			<td><?php echo $gorev['tarih']; ?></td>
			<td align="center"><a href="gorev.php?islem=gorev_sil&amp;gorev_id=<?php echo $gorev['id']; ?>">sil</a> | <?php echo gorev_yapildi_link($gorev['id'],$gorev['yapildi']); ?></td>
		</tr>
		<?php endwhile; ?>
	<?php else : ?>
	<tr>
		<td colspan="5"><p>veritabanında kayıt bulunamadı.</p></td>
	</tr>
	<?php endif; ?>
</table>

<h2>Görev Ekle</h2>
<form action="gorev.php?islem=gorev_ekle" method="post">
	<table border="1" cellpadding="5" cellspacing="2">
		<tr>
			<td width="90">Tanım:</td>
			<td><input type="text" name="gorev_tanim"></td>
		</tr>
		<tr>
			<td>Önem:</td>
			<td>
				<select name="gorev_onem">
					<option value="Az">Az</option>
					<option value="Normal">Normal</option>
					<option value="Çok">Çok</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Tarih:</td>
			<td><input type="datetime-local" name="gorev_tarih"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Ekle"></td>
		</tr>
	</table>	
</form>

</body>
</html>