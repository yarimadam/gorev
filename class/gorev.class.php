<?php

class Gorev
{
	// veritabanı sınıfı.
	private $veritabani;
	
	// görev tablosu alanları
	public $gorev_id;
	public $gorev_tanim;
	public $gorev_onem;
	public $gorev_tarih;
	public $gorev_yapildi;
	public $kisi_id;
	
	function __construct()
	{
		// sınıf içerisinde kullanılmak üzere veritabanı nesnesini getir.
		$this->veritabani = Veritabani::nesne_getir();
	}
	
	// Görev ekler.
	public function yeni()
	{
		$this->veritabani->sorgu("insert into gorev (tanim, onem, tarih, yapildi, kisi_id)
											values ('{$this->gorev_tanim}', '{$this->gorev_onem}', '{$this->gorev_tarih}', '{$this->gorev_yapildi}', '{$this->kisi_id}')");
	}
	
	// Görev siler.
	public function sil()
	{
		$this->veritabani->sorgu("delete from gorev where id = {$this->gorev_id}");
	}
	
	// Görevi yapıldı olarak işaretler.
	public function yapildi()
	{
		$this->veritabani->sorgu("update gorev set yapildi = 1 where id = {$this->gorev_id}");
	}
	
	// Görevi yapılmadı olarak işaretler.
	public function yapilmadi()
	{
		$this->veritabani->sorgu("update gorev set yapildi = 0 where id = {$this->gorev_id}");
	}
	
	// Görev listesini getirir.
	public function liste()
	{
		return $this->veritabani->sorgu("select * from gorev where kisi_id = {$this->kisi_id} order by tarih desc");
	}
}

?>