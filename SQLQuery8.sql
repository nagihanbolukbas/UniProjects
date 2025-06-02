USE PROJE;
CREATE TABLE Ulkeler (
    Ulke_id INTEGER PRIMARY KEY,
    UlkeAdi VARCHAR(100),
    Baskent VARCHAR(100),
    Nufus INTEGER
);
INSERT INTO Ulkeler (Ulke_id, UlkeAdi, Baskent, Nufus) VALUES
(1, 'T�rkiye', 'Ankara', 84000000),
(2, 'Almanya', 'Berlin', 83000000),
(3, 'Fransa', 'Pa 


ris', 67000000),
(4, '�talya', 'Roma', 60000000),
(5, '�spanya', 'Madrid', 47000000),
(6, 'Japonya', 'Tokyo', 126000000),
(7, 'Kanada', 'Ottawa', 38000000),
(8, 'Avustralya', 'Canberra', 25000000),
(9, 'Brezilya', 'Bras�lia', 211000000),
(10, 'Hindistan', 'Yeni Delhi', 1380000000);


CREATE TABLE Hastaliklar (
    Hastalik_id INTEGER PRIMARY KEY,
    Ulke_ID INTEGER,
    HastalikAdi VARCHAR(100),
    HastalikTuru VARCHAR(50),
    OlumSayisi INTEGER,
    FOREIGN KEY (Ulke_ID) REFERENCES Ulkeler(Ulke_id)
);
INSERT INTO Hastaliklar (Hastalik_id, Ulke_ID, HastalikAdi, HastalikTuru, OlumSayisi) VALUES
(1, 1, 'Grip', 'Viral', 500),
(2, 2, 'T�berk�loz', 'Bakteriyel', 300),
(3, 3, 'Covid-19', 'Viral', 1000),
(4, 4, 'S�tma', 'Parazitik', 200),
(5, 5, 'Kolera', 'Bakteriyel', 150),
(6, 6, 'Dengue', 'Viral', 400),
(7, 7, 'Zat�rre', 'Bakteriyel', 350),
(8, 8, 'Hepatit B', 'Viral', 250),
(9, 9, 'Leptospiroz', 'Bakteriyel', 100),
(10, 10, 'Tifo', 'Bakteriyel', 600);


CREATE TABLE Cografya (
    Cografya_id INTEGER PRIMARY KEY,
    Hastalik_id INTEGER,
    YasGruplari VARCHAR(50),
    GorulmeOrani FLOAT,
    BolgeAdi VARCHAR(100),
    FOREIGN KEY (Hastalik_id) REFERENCES Hastaliklar(Hastalik_id)
);
INSERT INTO Cografya (Cografya_id, Hastalik_id, YasGruplari, GorulmeOrani, BolgeAdi) VALUES
(1, 1, '0-5', 3.5, 'Asya'),      
(2, 2, '6-12', 2.8, 'Avrupa'),    
(3, 3, '13-18', 1.2, 'Afrika'),  
(4, 4, '19-25', 4.0, 'Amerika'), 
(5, 5, '26-35', 5.5, 'Avrupa'),
(6, 6, '36-45', 3.1, 'Asya'),     
(7, 7, '46-60', 2.3, 'Afrika'),   
(8, 8, '60+', 6.8, 'Amerika'),    
(9, 9, '0-5', 2.5, 'Avrupa'),     
(10, 10, '19-25', 1.7, 'Asya');

CREATE TABLE Hastaneler (
    Hastane_id INTEGER PRIMARY KEY,
    Isim VARCHAR(100),
    Tur VARCHAR(50),
    Adres VARCHAR(200)
);
INSERT INTO Hastaneler (Hastane_id, Isim, Tur, Adres) VALUES
(1, 'Ankara �ehir Hastanesi', 'Devlet', 'Ankara, T�rkiye'),
(2, 'Berlin Charit�', '�niversite', 'Berlin, Almanya'),
(3, 'H�pital de la Piti�-Salp�tri�re', '�niversite', 'Paris, Fransa'),
(4, 'Ospedale San Raffaele', '�zel', 'Milano, �talya'),
(5, 'Hospital Universitario La Paz', 'Devlet', 'Madrid, �spanya'),
(6, 'Tokyo General Hospital', 'Devlet', 'Tokyo, Japonya'),
(7, 'Toronto General Hospital', '�niversite', 'Toronto, Kanada'),
(8, 'Royal Melbourne Hospital', 'Devlet', 'Melbourne, Avustralya'),
(9, 'Hospital das Cl�nicas', '�niversite', 'S�o Paulo, Brezilya'),
(10, 'All India Institute of Medical Sciences', '�niversite', 'Yeni Delhi, Hindistan');


CREATE TABLE Sigortalar (
    Sigorta_id INTEGER PRIMARY KEY,
    Hasta_id INTEGER,
    SigortaSirketi VARCHAR(100),
    PoliceNo VARCHAR(50),
    Kapsam TEXT,
    BaslangicTarihi DATE,
    BitisTarihi DATE,
    FOREIGN KEY (Hasta_id) REFERENCES Hastalar(Hasta_id)
);
INSERT INTO Sigortalar (Sigorta_id, Hasta_id, SigortaSirketi, PoliceNo, Kapsam, BaslangicTarihi, BitisTarihi) VALUES
(1, 1, 'SGK', 'TR123456', 'Tam', '2020-01-01', '2025-01-01'),
(2, 2, 'AOK', 'DE654321', 'K�smi', '2019-06-15', '2024-06-15'),
(3, 3, 'Assurance Maladie', 'FR789012', 'Tam', '2021-03-20', '2026-03-20'),
(4, 4, 'INPS', 'IT345678', 'K�smi', '2018-11-10', '2023-11-10'),
(5, 5, 'Seguridad Social', 'ES901234', 'Tam', '2022-07-05', '2027-07-05'),
(6, 6, 'NHI', 'JP567890', 'Tam', '2020-09-25', '2025-09-25'),
(7, 7, 'OHIP', 'CA123789', 'K�smi', '2019-02-14', '2024-02-14'),
(8, 8, 'Medicare', 'AU456123', 'Tam', '2021-12-01', '2026-12-01'),
(9, 9, 'SUS', 'BR789456', 'K�smi', '2017-08-30', '2022-08-30'),
(10, 10, 'Ayushman Bharat', 'IN321654', 'Tam', '2023-04-18', '2028-04-18');


CREATE TABLE Hastalar (
    Hasta_id INTEGER PRIMARY KEY,
    Sigorta_id INTEGER,
    Hastalik_id INTEGER,
    Hastane_id INTEGER,
    AdSoyad VARCHAR(100),
    DogumTarihi DATE,
    Cinsiyet VARCHAR(10),
    Adres VARCHAR(200),
    FOREIGN KEY (Hastalik_id) REFERENCES Hastaliklar(Hastalik_id),
    FOREIGN KEY (Hastane_id) REFERENCES Hastaneler(Hastane_id)
    );
INSERT INTO Hastalar (Hasta_id, Sigorta_id, Hastalik_id, Hastane_id, AdSoyad, DogumTarihi, Cinsiyet, Adres) VALUES
(1, NULL, 1, 1, 'Ahmet Y�lmaz', '1980-05-12', 'Erkek', 'Ankara, T�rkiye'),
(2, NULL, 2, 2, 'Anna Schmidt', '1975-09-23', 'Kad�n', 'Berlin, Almanya'),
(3, NULL, 3, 3, 'Jean Dupont', '1990-02-17', 'Erkek', 'Paris, Fransa'),
(4, NULL, 4, 4, 'Giulia Rossi', '1985-07-08', 'Kad�n', 'Roma, �talya'),
(5, NULL, 5, 5, 'Carlos Garc�a', '1992-11-30', 'Erkek', 'Madrid, �spanya'),
(6, NULL, 6, 6, 'Yuki Tanaka', '1988-03-14', 'Kad�n', 'Tokyo, Japonya'),
(7, NULL, 7, 7, 'John Smith', '1979-06-22', 'Erkek', 'Toronto, Kanada'),
(8, NULL, 8, 8, 'Emily Brown', '1995-12-05', 'Kad�n', 'Melbourne, Avustralya'),
(9, NULL, 9, 9, 'Pedro Silva', '1983-08-19', 'Erkek', 'S�o Paulo, Brezilya'),
(10, NULL, 10, 10, 'Anjali Sharma', '1991-04-27', 'Kad�n', 'Yeni Delhi, Hindistan');


CREATE TABLE Epostalar (
    Eposta_id INTEGER PRIMARY KEY,
    Hasta_id INTEGER,
    EpostaAdresi VARCHAR(100),
    FOREIGN KEY (Hasta_id) REFERENCES Hastalar(Hasta_id)
);
INSERT INTO Epostalar (Eposta_id, Hasta_id, EpostaAdresi) VALUES
(1, 1, 'ahmet.yilmaz@example.com'),
(2, 2, 'anna.schmidt@example.de'),
(3, 3, 'jean.dupont@example.fr'),
(4, 4, 'giulia.rossi@example.it'),
(5, 5, 'carlos.garcia@example.es'),
(6, 6, 'yuki.tanaka@example.jp'),
(7, 7, 'john.smith@example.ca'),
(8, 8, 'emily.brown@example.au'),
(9, 9, 'pedro.silva@example.br'),
(10, 10, 'anjali.sharma@example.in');


CREATE TABLE TedaviTurleri (
    TedaviTuru_id INTEGER PRIMARY KEY,
    TedaviAdi VARCHAR(100),
    Aciklama TEXT
);

INSERT INTO TedaviTurleri (TedaviTuru_id, TedaviAdi, Aciklama) VALUES
(1, 'Fizik Tedavi', 'Kas ve iskelet sistemi rahats�zl�klar� i�in'),
(2, 'Kemoterapi', 'Kanser tedavisi i�in'),
(3, 'Radyoterapi', 'T�m�r tedavisi i�in'),
(4, 'Psikoterapi', 'Ruh sa�l��� deste�i i�in'),
(5, 'Antibiyotik Tedavisi', 'Bakteriyel enfeksiyonlar i�in'),
(6, 'A�� Uygulamas�', 'Ba����kl�k kazand�rmak i�in'),
(7, 'Cerrahi M�dahale', 'Ameliyat gerektiren durumlar i�in'),
(8, 'Diyaliz', 'B�brek yetmezli�i tedavisi i�in'),
(9, 'Rehabilitasyon', 'Uzun s�reli tedavi sonras� iyile�me i�in'),
(10, 'Beslenme Dan��manl���', 'Sa�l�kl� beslenme al��kanl�klar� i�in');

CREATE TABLE TedaviSureleri (
    TedaviSuresi_id INTEGER PRIMARY KEY,
    BaslangicTarihi DATE,
    BitisTarihi DATE,
    Durum VARCHAR(50)
);

INSERT INTO TedaviSureleri (TedaviSuresi_id, BaslangicTarihi, BitisTarihi, Durum) VALUES
(1, '2023-01-01', '2023-03-01', 'Tamamland�'),
(2, '2022-05-15', '2022-11-15', 'Tamamland�'),
(3, '2023-02-20', '2025-06-20', 'Devam Ediyor'),
(4, '2026-01-10', '2026-04-10', 'Planland�'),
(5, '2023-03-05', '2023-04-05', 'Tamamland�'),
(6, '2023-07-01', '2023-07-30', 'Tamamland�'),
(7, '2022-09-12', '2022-12-12', 'Tamamland�'),
(8, '2023-11-01', '2026-02-01', 'Devam Ediyor'),
(9, '2021-06-01', '2021-09-01', 'Tamamland�'),
(10, '2027-05-01', '2027-08-01', 'Planland�');

CREATE TABLE Tedaviler (
    Tedavi_id INTEGER PRIMARY KEY,
    Hasta_id INTEGER,
    TedaviTuru_id INTEGER,
    TedaviSuresi_id INTEGER,
    FOREIGN KEY (Hasta_id) REFERENCES Hastalar(Hasta_id),
    FOREIGN KEY (TedaviTuru_id) REFERENCES TedaviTurleri(TedaviTuru_id),
    FOREIGN KEY (TedaviSuresi_id) REFERENCES TedaviSureleri(TedaviSuresi_id)
);

INSERT INTO Tedaviler (Tedavi_id, Hasta_id, TedaviTuru_id, TedaviSuresi_id) VALUES
(1, 1, 1, 1),
(2, 2, 2, 2),
(3, 3, 3, 3),
(4, 4, 4, 4),
(5, 5, 5, 5),
(6, 6, 6, 6),
(7, 7, 7, 7),
(8, 8, 8, 8),
(9, 9, 9, 9),
(10, 10, 10, 10);

CREATE TABLE Turler (
    Tur_id INTEGER PRIMARY KEY,
    TurAdi VARCHAR(50)
);
INSERT INTO Turler (Tur_id, TurAdi) VALUES
(1, '�ocuk'),
(2, 'Ergen'),
(3, 'Yeti�kin'),
(4, 'Ya�l�'),
(5, 'Hamile'),
(6, 'Kronik Hasta'),
(7, 'Engelli'),
(8, 'Ameliyatl� Hasta'),
(9, 'Yo�un Bak�m Hastas�'),
(10, 'Psikiyatri Hastas�');


CREATE TABLE HastaneTelefonlari (
    Telefon_id INTEGER PRIMARY KEY,
    Hastane_id INTEGER,
    TelefonNo VARCHAR(20),
    FOREIGN KEY (Hastane_id) REFERENCES Hastaneler(Hastane_id)
);
INSERT INTO HastaneTelefonlari (Telefon_id, Hastane_id, TelefonNo) VALUES
(1, 1, '+903122223344'),
(2, 2, '+493012345678'),
(3, 3, '+33123456789'),
(4, 4, '+390612345678'),
(5, 5, '+34912345678'),
(6, 6, '+81312345678'),
(7, 7, '+14161234567'),
(8, 8, '+61312345678'),
(9, 9, '+551112345678'),
(10, 10, '+911123456789');


CREATE TABLE Calisanlar (
    Calisan_id INTEGER PRIMARY KEY,
    Hastane_id INTEGER,
    AdSoyad VARCHAR(100),
    CalistigiBolum VARCHAR(100),
    EgitimSeviyesi VARCHAR(50),
    FOREIGN KEY (Hastane_id) REFERENCES Hastaneler(Hastane_id)
);
INSERT INTO Calisanlar (Calisan_id, Hastane_id, AdSoyad, CalistigiBolum, EgitimSeviyesi) VALUES
(1, 1, 'Dr. Ay�e Demir', 'Kardiyoloji', 'Doktora'),
(2, 2, 'Dr. Hans M�ller', 'G���s Hastal�klar�', 'Uzmanl�k'),
(3, 3, 'Dr. Marie Lefevre', 'Enfeksiyon', 'Doktora'),
(4, 4, 'Dr. Luca Bianchi', 'Ortopedi', 'Uzmanl�k'),
(5, 5, 'Dr. Sofia Martinez', 'Pediatri', 'Doktora'),
(6, 6, 'Dr. Kenji Nakamura', 'Dahiliye', 'Uzmanl�k'),
(7, 7, 'Dr. Sarah Thompson', 'Onkoloji', 'Doktora'),
(8, 8, 'Dr. James White', 'N�roloji', 'Uzmanl�k'),
(9, 9, 'Dr. Ana Oliveira', 'Acil Servis', 'Uzmanl�k'),
(10, 10, 'Dr. Raj Patel', 'Dermatoloji', 'Doktora');

CREATE TABLE Ekler (
    Ekler_id INTEGER PRIMARY KEY,
    Aciklama TEXT
);
INSERT INTO Ekler (Ekler_id, Aciklama) VALUES
(1, 'Y�ksek riskli b�lge'),
(2, '��me suyu kalitesi d���k'),
(3, 'Yetersiz hava kalitesi'),
(4, 'G�da eri�imi s�n�rl�'),
(5, 'A��r� s�cakl�k dalgalar�'),
(6, 'Y�ksek nem oran�'),
(7, 'Yetersiz sa�l�k altyap�s�'),
(8, 'Kentsel hava kirlili�i'),
(9, 'Yetersiz e�itim seviyesi'),
(10, 'Sanayi yo�unlu�u y�ksek');

CREATE TABLE CevreselEtkiler (
    CevreEtkisi_id INTEGER PRIMARY KEY,
    Ekler_id INTEGER,
    SuKalitesi VARCHAR(100),
    HavaKalitesi VARCHAR(100),
    IklimDurumu VARCHAR(100),
    GidaGuvenligi VARCHAR(100),
    FOREIGN KEY (Ekler_id) REFERENCES Ekler(Ekler_id)
);
INSERT INTO CevreselEtkiler (CevreEtkisi_id, Ekler_id, SuKalitesi, HavaKalitesi, IklimDurumu, GidaGuvenligi) VALUES
(1, 1, 'Orta', 'K�t�', 'Kurak', 'D���k'),
(2, 2, 'K�t�', 'K�t�', 'Nemli', 'Orta'),
(3, 3, '�yi', 'Orta', 'Il�man', 'Y�ksek'),
(4, 4, 'Orta', '�yi', 'So�uk', 'Orta'),
(5, 5, '�yi', 'K�t�', 'S�cak', 'D���k'),
(6, 6, 'K�t�', 'Orta', 'Ya���l�', 'Orta'),
(7, 7, 'Orta', 'Orta', 'De�i�ken', 'Y�ksek'),
(8, 8, '�yi', 'K�t�', 'Nemli', 'D���k'),
(9, 9, 'K�t�', '�yi', 'Kurak', 'Orta'),
(10, 10, 'Orta', 'K�t�', 'Il�man', 'Y�ksek');


CREATE TABLE BeslenmeDurumu (
    BeslenmeDurumu_ID INTEGER PRIMARY KEY,
    Ekler_id INTEGER,
    ObeziteOrani FLOAT,
    SaglikliBeslenmePolitikasi VARCHAR(200),
    GidaErisimi VARCHAR(200),
    FOREIGN KEY (Ekler_id) REFERENCES Ekler(Ekler_id)
);
INSERT INTO BeslenmeDurumu (BeslenmeDurumu_ID, Ekler_id, ObeziteOrani, SaglikliBeslenmePolitikasi, GidaErisimi) VALUES
(1, 1, 22.5, 'Uygulan�yor', 'D���k'),
(2, 2, 30.1, 'Yetersiz', 'Orta'),
(3, 3, 18.4, 'Geli�tiriliyor', 'Y�ksek'),
(4, 4, 25.7, 'Var', 'Orta'),
(5, 5, 35.2, 'Yok', 'D���k'),
(6, 6, 20.0, 'Uygulan�yor', 'Y�ksek'),
(7, 7, 28.6, 'Yetersiz', 'Orta'),
(8, 8, 19.8, 'Var', 'Y�ksek'),
(9, 9, 24.5, 'Geli�tiriliyor', 'Orta'),
(10, 10, 32.0, 'Yok', 'D���k');


CREATE TABLE Butce (
    Butce_id INTEGER PRIMARY KEY,
    Hastane_id INTEGER,
    Yil INTEGER,
    ToplamTutar DECIMAL(12,2),
    FOREIGN KEY (Hastane_id) REFERENCES Hastaneler(Hastane_id)
);
INSERT INTO Butce (Butce_id, Hastane_id, Yil, ToplamTutar) VALUES
(1, 1, 2020, 1500000.00),
(2, 2, 2021, 1750000.00),
(3, 3, 2022, 2000000.00),
(4, 4, 2023, 1800000.00),
(5, 5, 2020, 1300000.00),
(6, 6, 2021, 1450000.00),
(7, 7, 2022, 2100000.00),
(8, 8, 2023, 1950000.00),
(9, 9, 2024, 1700000.00),
(10, 10, 2024, 2200000.00);


CREATE TABLE Politikalar (
    Politika_ID INTEGER PRIMARY KEY,
    Etken_ID INTEGER,
    PolitikaAdi VARCHAR(100),
    HedeflenenSaglikSorunu VARCHAR(100),
    BasariDurumu VARCHAR(50),
    UygulamaTarihi DATE,
    FOREIGN KEY (Etken_ID) REFERENCES CevreselEtkiler(CevreEtkisi_id)
);
INSERT INTO Politikalar (Politika_ID, Etken_ID, PolitikaAdi, HedeflenenSaglikSorunu, BasariDurumu, UygulamaTarihi) VALUES
(1, 1, 'Temiz Su Projesi', '�shal Vakalar�', 'Ba�ar�l�', '2020-01-01'),
(2, 2, 'Temiz Hava Yasas�', 'Solunum Hastal�klar�', 'Orta', '2021-03-15'),
(3, 3, 'Acil �klim Plan�', 'S�cak �arpmas�', 'Ba�ar�s�z', '2022-06-10'),
(4, 4, 'G�da Takviyesi Program�', 'Yetersiz Beslenme', 'Ba�ar�l�', '2019-09-01'),
(5, 5, 'Tar�m Reformu', 'G�da G�venli�i', 'Orta', '2021-12-20'),
(6, 6, '�klim Fark�ndal�k Kampanyas�', 'Alerjik Reaksiyonlar', 'Orta', '2023-02-05'),
(7, 7, 'K�rsal Sa�l�k Deste�i', 'Obezite', 'Ba�ar�l�', '2020-07-01'),
(8, 8, 'Sanayi Denetimleri', 'Kanser', 'Ba�ar�s�z', '2022-04-01'),
(9, 9, 'E�itimle Sa�l�k', '�ocuk Hastal�klar�', 'Orta', '2023-01-15'),
(10, 10, 'Sanayi At�k D�zenlemesi', 'Solunum Rahats�zl�klar�', 'Ba�ar�l�', '2024-05-01');

