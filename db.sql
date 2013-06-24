
CREATE TABLE `settings` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `DEFINE` varchar(100) CHARACTER SET latin5 NOT NULL,
  `Value` text CHARACTER SET latin5 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=31 ;


INSERT INTO `settings` (`Id`, `Define`, `Value) VALUES 
(5, 'LINK_TYPE', 'seo'),
(6, 'SITE_TITLE', 'Site Title'),
(7, 'SITE_URL', 'http://example.com'),
(8, 'GORSEL_DIZIN', '/var/www/vhosts/example.com/httpdocs/userfiles/'),
(9, 'GORSEL_URL', 'http://gardentr.com/images/'),
(10, 'SLOGAN', ''),
(11, 'BIR_SAYFADAKI_ISIM_SAYISI', '25');

-- --------------------------------------------------------


CREATE TABLE `contents` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'listedeyok()|label(İçerik ID)|ilisikalan1(tablename=>icerikler$fieldname=>UST_ELEMAN)|ilisikalan1(tablename=>kategoriler$fieldname=>LINK_ICERIK)',
  `Category` int(11) DEFAULT NULL COMMENT 'frmelmn(select)|iliski(tablename=>kategoriler$key=>ID$value=>KATEGORI)|label(Kategori)|label2(Kategori)|',
  `Title` text COLLATE utf8_turkish_ci COMMENT 'label(Başlık)|label(Başlık)|label2(Başlık)|HTML(onclick=>document.getElementByID(''url_tipi_baslik'').value=this.value)',
  `Url` varchar(250) COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'label(URL)|label2(Adres)|id(url_tipi_baslik)',
  `Content_Type` enum('uygulama','icerik','haber') COLLATE utf8_turkish_ci DEFAULT 'icerik' COMMENT 'label(İçerik Tipi)|label2(İçerikTipi)',
  `Content` text COLLATE utf8_turkish_ci COMMENT 'frmelmn(editor)|label(İçerik)|label2(İçerik)|',
  `Image_Category` varchar(230) COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'frmelmn(resimkategori)|iliski(tablename=>resimler_kategori$key=>ID$value=>ADI)|listedeyok()|label(Resimleri Seçiniz)',
  `Video_Category` varchar(230) COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'frmelmn(videokategori)|iliski(tablename=>video_kategori$key=>ID$value=>ADI)|listedeyok()|label(Videoları Seçiniz)',
  `Tags` text COLLATE utf8_turkish_ci COMMENT 'label(Anahtar Kelimeler /Kelimeleri virgülle ayırınız/)|label2(AnahtarKelimeler)|',
  `Insertion_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'label2(EklenmeTarihi)|label1(Eklenme Tarihi)',
  `OnMenu` enum('0','1') COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'degerler(0=>Hayır$1=>Evet)|label(içerik Menüye Yerleştirilsin mi?)|label2(MenüdeMi?)|listedeyok()',
  `Order_Menu` int(10) DEFAULT NULL COMMENT 'listedeyok()|label(İçeriğin Menüdeki Sırası)|label2(MenüSırası)|',
  `Parent` int(10) DEFAULT NULL COMMENT 'listedeyok()|label(Başka bir içerikle ilişkilendirilsin mi?)|label2(İlişkiliİçerik)|iliski(tablaname=>icerikler$key=>ID$value=>BASLIK)|notedit()',
  `Hit` int(10) DEFAULT NULL COMMENT 'notedit()|label(İçerik hiti)|label2(Hit)|',
  `Online` enum('0','1') COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'degerler(0=>Hayır$1=>Evet)|label(İçerik Yayınlansın mı?)|label2(YayındaMı?)|',
  PRIMARY KEY (`Id`),
  KEY `Url` (`Url`),
  KEY `Category` (`Category`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=2 ;




INSERT INTO `contents` (`ID`, `Category`, `Title`, `Url`, `Content_Type`, `Content`, `Image_Category`, `Video_Category`, `Tags`, 
`Insertion_Date`, `OnMenu`, `Order_Menu`, `Parent`, `Hit`, `Online`) VALUES 
(1, NULL, '', 'anasayfa', 'uygulama', 'content/homepage.php', '', '', 'Example Site', '2009-04-19 19:11:49', '0', NULL, NULL, 0, '1');

-- --------------------------------------------------------


CREATE TABLE `categories` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ilisikalan0(tablename=>icerikler$fieldname=>KATEGORI)|ilisikalan1(tablename=>kategoriler$fieldname=>UST_KATEGORI)|label2(KategoriID)|label(Kategori ID)',
  `Category` varchar(250) COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'label2(KategoriAdı)|label(Kategori Adı)',
  `Url` varchar(250) COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'label2(URlTipi)|label(URL Tipi)|listedeyok()',
  `Parent` int(10) DEFAULT NULL COMMENT 'frmelmn(select)|iliski(tablename=>kategoriler$key=>ID$value=>KATEGORI)|label2(ÜstKategori)|label(Kategori ilişkisi)',
  `OnMenu` enum('0','1') COLLATE utf8_turkish_ci DEFAULT '1' COMMENT 'degerler(1=>Evet$0=>Hayır)|label2(MenudeMi?)|label(Menüde mi?)',
  `LintTo_Content` int(11) NOT NULL DEFAULT '0' COMMENT 'frmelmn(select)|iliski(tablename=>icerikler$key=>ID$value=>BASLIK)|listedeyok()|label(İçerik ilişkisi)',
  `Order` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Url` (`Url`),
  KEY `Parent` (`Parent`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------


CREATE TABLE `images` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'listedeyok()|ilisikalan0(tablename=>resimler_kategori$fieldname=>KAPAK)',
  `Category` int(11) DEFAULT NULL COMMENT 'iliski(tablename=>resimler_kategori$key=>ID$value=>ADI)|frmelmn(select)|label(Kategori Seçiniz)|label2(Kategori)',
  `Source` varchar(230) COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'listedeyok()|frmelmn(resimliste)|iliski(tablename=>rdosya$key=>ID$value=>SOURCE)|label(Resmi Seçiniz)|label2(Kaynak)',
  `Desc` text COLLATE utf8_turkish_ci COMMENT 'listedeyok()|label(Açıklama)',
  `Insertion_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'label2(EklenmeTarihi)|label1(Eklenme Tarihi)',
  `Order` int(11) DEFAULT NULL COMMENT 'label(Sırası)|label2(Sıra)',
  `Hit` int(11) DEFAULT NULL COMMENT 'label(Kaç kez girilmiş)|label2(Hit)|notedit()',
  `Online` enum('0','1') COLLATE utf8_turkish_ci NOT NULL DEFAULT '1' COMMENT 'degerler(0=>Hayır$1=>Evet)|label(Yayında izni verilsin mi?)|label2(YayındaMı?)',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------


CREATE TABLE `images_category` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ilisikalan1(tablename=>icerikler$fieldname=>RESIM_KAT)|ilisikalan0(tablename=>resimler$fieldname=>KATEGORI)|label(Kategorinin ID''si)|label2(KategorininNosu)',
  `Name` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'label(Kategorinin Adını Giriniz)|label2(KategorininAdı)',
  `Title_Image` int(11) DEFAULT NULL COMMENT 'iliski(tablename=>resimler$key=>ID$value=>BASLIK)|frmelmn(select)|label(Kategoriye kapak seçiniz)|label2(Kapak)',
  `Desc` text COLLATE utf8_turkish_ci COMMENT 'label(Kategorinin Açıklamasını Giriniz)|label2(Açıklama)',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=56 ;


-- --------------------------------------------------------


CREATE TABLE `user_session` (
  `UserID` int(11) NOT NULL,
  `session_id` varchar(50) CHARACTER SET latin5 NOT NULL,
  `logins` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



-- --------------------------------------------------------


CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'label(Kullanıcı IDsi)|label2(KullanıcıID)|listedeyok()',
  `name_surname` varchar(255) DEFAULT NULL COMMENT 'label(Ad Soyad)|label2(AdSoyad)',
  `user` varchar(255) DEFAULT NULL COMMENT 'label(Kullannıcı Adı)|label2(KullanıcıAdı)',
  `pass` varchar(255) DEFAULT NULL COMMENT 'frmelmn(password)|fonksiyon(MD5)|label(Kullanıcı Şifresi)|label2(KullanıcıŞifresi)',
  `email` varchar(255) DEFAULT NULL COMMENT 'label(Email)|label2(Email)',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'label2(HesapAçmaTarihi)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


INSERT INTO `users` (`id`, `name_surname`, `user`, `pass`, `email`, `created`) VALUES 
(1, 'Haydar KÜLEKCİ', 'gar', MD5'123456', NULL, '2009-12-25 12:18:20');

-- --------------------------------------------------------


CREATE TABLE `video_category` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ilisikalan0(tablename=>videolar$fieldname=>KATEGORI)|listedeyok()|ilisikalan1(tablename=>icerikler$fieldname=>VIDEO_KAT)',
  `Name` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'label2(Adı)|label(Video Kategori)',
  `Title_Image` int(11) NOT NULL COMMENT 'notedit()|listedeyok()',
  `Desc` text COLLATE utf8_turkish_ci COMMENT 'label2(Açıklama)|label(Açıklama)',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------


CREATE TABLE `videolar` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'listedeyok()|ilisikalan0(tablename=>resimler_kategori$fieldname=>KAPAK)',
  `Category` int(11) DEFAULT NULL COMMENT 'iliski(tablename=>video_kategori$key=>ID$value=>ADI)|frmelmn(select)|label(Kategori Seçiniz)|label2(Kategori)',
  `Source` varchar(230) COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'listedeyok()|frmelmn(videoliste)|iliski(tablename=>vdosya$key=>ID$value=>SOURCE)|label(Videoyu Seçiniz)',
  `Desc` text COLLATE utf8_turkish_ci COMMENT 'listedeyok()|label(Açıklama)',
  `Insertion_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'label2(EklenmeTarihi)|label1(Eklenme Tarihi)',
  `Order` int(11) DEFAULT NULL COMMENT 'label2(Sıra)|label(Sıra)|',
  `Hit` int(11) DEFAULT NULL COMMENT 'notedit()|label2(Hit)',
  `Online` enum('0','1') COLLATE utf8_turkish_ci NOT NULL DEFAULT '1' COMMENT 'degerler(0=>Hayır$1=>Evet)|label2(YayındaMı)|label(Yayında Mı?)',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;


