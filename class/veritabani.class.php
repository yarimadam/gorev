<?php

class Veritabani
{
	// veritabanı sınıfı.
	private static $veritabani;
	// veri tabanı bağlantısı.
	private $baglanti;
	
	
	// veri tabanına bağlanır.
	public function baglan()
	{
		// mysql sunucusuna bağlan.
		$baglanti = new mysqli(VT_SUNUCU, VT_KULLANICI, VT_PAROLA, VT_AD);
		
		if ($baglanti->connect_errno)
		{
			// eğer bağlanırken hata oluştuysa ekrana hata mesajı bastır.
			hata( sprintf('MySQL sunucusuna bağlanılamadı. Hata: (#%s) %s', $baglanti->connect_errno, $baglanti->connect_error) );
		}
		else
		{
			// bağlantı başarılıysa, sınıf değişkenine ata.
			$this->baglanti = $baglanti;
		}
	}
	
	// veritabanını sorgular.
	public function sorgu($sorgu)
	{
		// veritabanına sorgu gönder.
		$sonuc = $this->baglanti->query($sorgu);
		
		if($this->baglanti->errno)
		{
			// eğer hata oluştuysa ekrana hata mesajı bastır.
			hata( sprintf('MySQL sorgusu başarısız oldu. Hata: (#%s) %s', $this->baglanti->errno, $this->baglanti->error) );
		}
		else
		{
			// eğer hata oluşmadıysa sonucu döndür
			return $sonuc;
		}
		
	}
	
	// veri tabani nesnesini döndürür.
	public static function nesne_getir()
	{
		// eğer veritabanına bağlanılmamışsa, veri tabanına bağlan.
		if(self::$veritabani == null)
		{
			$veritabani = new Veritabani();
			$veritabani->baglan();
			$veritabani->baglanti->set_charset("utf8");
			self::$veritabani = $veritabani;
		}
		
		// veri tabanı nesnesini döndür.
		return self::$veritabani;
	}

}


?>