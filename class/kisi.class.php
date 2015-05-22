<?php

class Kisi
{
	// veritabanı sınıfı.
	private $veritabani;
	
	// kişi tablosu alanları
	public $kisi_id;
	public $kisi_isim;
	
	function __construct()
	{
		// sınıf içerisinde kullanılmak üzere veritabanı nesnesini getir.
		$this->veritabani = Veritabani::nesne_getir();
	}
	
	// Yeni kişi ekler.
	public function yeni()
	{
		$this->veritabani->sorgu("insert into kisi (isim) values ('{$this->kisi_isim}')");
	}
	
	// Kişi siler.
	public function sil()
	{
		$this->veritabani->sorgu("delete from kisi where id = {$this->kisi_id}");
	}
	
	// Kişi ismini getirir.
	public function isim_getir()
	{
		$isim = $this->veritabani->sorgu("select isim from kisi where id = {$this->kisi_id}");
		$isim = mysqli_fetch_assoc($isim);
		return $isim['isim'];
	}
	
	// Kişi listesini getirir.
	public function liste()
	{
		return $this->veritabani->sorgu('select * from kisi');
	}
}

?>