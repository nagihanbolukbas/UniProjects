import tkinter as tk
from tkinter import messagebox
from PIL import Image, ImageTk

# Tarifler listesi (Önceden eklenmiş tarifler)
tarifler = {
    "Tatlılar": [
        {
            "isim": "Waffle",
            "malzemeler": """
2 adet yumurta
2 yemek kaşığı toz şeker
1 paket vanilin
1,5 su bardağı süt
1/4 su bardağı sıvı yağ
2 su bardağı un
1 paket kabartma tozu
Bir tutam tuz
            """,
 "adimlar": """
1. Yumurtaların beyazını ve sarısını ayırın. Yumurta beyazlarını bir tutam tuzla köpük haline gelene kadar çırpın.
2. Yumurta sarılarını şekerle çırpın, ardından süt ve sıvı yağı ekleyerek karıştırın.
3. Un ve kabartma tozunu eleyerek karışıma ekleyin, homojen bir karışım elde edin.
4. Yumurta beyazlarını nazikçe karışıma ekleyin.
5. Waffle makinesini ısıtın, hafifçe yağlayın ve hamuru dökerek pişirin.
6. Üzerine çikolata, meyve ya da dondurma ile süsleyerek servis edin.
Afiyet olsun!
            """
        },
        {
"isim":"Cheescake",
"malzemeler":"""
 Tabanı için:
 200 g burçak bisküvi
 100 g eritilmiş tereyağı

 
 Dolgusu için:
 600 g krem peynir
 200 g toz şeker
 3 yumurta
 1 paket vanilin
 200 ml sıvı krema
 1 yemek kaşığı un
 1 tatlı kaşığı limon suyu

 Üzeri için:
 1 su bardağı vişne
 1  çay bardağı toz şeker
 1 tatlı kaşığı mısır nişastası""",
 "adimlar":"""
 Tabanı: Bisküvileri ufalayıp tereyağıyla karıştırın. Kalıba yayıp buzdolabında dinlendirin.
 Dolgusu: Krem peyniri, şeker, yumurta, krema, vanilin, un ve limon suyunu çırpın. Tabanın üzerine dökün.
 Pişirme: 160°C’de su banyosu yaparak 45-60 dakika pişirin. Soğutun.
 Sos: Meyve, şeker ve nişastayı pişirip soğutun. Cheesecake’in üzerine dökün.
 Dinlendirme: Buzdolabında en az 4 saat bekletip servis edin."""
 },
        {
        "isim":"Profiterol",
"malzemeler":"""
1 su bardağı su
1 su bardağı un
125 gr tereyağı veya margarin
3 adet yumurta (yumurtalar küçük ise 4 adet)

Profiterol Kreması için;
2,5 su bardağı süt
3 yemek kaşığı un
1,5 çay bardağı şeker
1 adet yumurta
1 paket vanilya


Üzeri İçin
1 paket hazır çikolata sosu ya da benmari usulü eritilmiş 80 gr bitter çikolata""",
 "adimlar":""" 
1.İlk olarak profiterolün hamurunu hazırlayalım. Küçük bir tencereye 1 su bardağı suyu ve margarini koyarak kaynatın.
2.Daha sonra 1 su bardağı unu ekleyerek iyice karıştırın. 2-3 dakika karışımı sürekli karıştırarak pişirin.
3.Ocağı kapatarak 10-15 dakika hamurun soğumasını bekleyin. Hamur biraz dinlendikten sonra 3 adet yumurtayı hamura yedirmemiz gerekiyor ancak bu noktada önemli bir ayrıntı var. 
Yumurtaları teker teker hamura kırın ve birini iyice yedirmeden diğer yumurtayı kırmayın. Yumurtaları hamura iyice yedirdikten sonra yapışkan bir hamur elde etmiş olduk. 
Bu kısım biraz yorucu oluyor ama hamurun kabarması için iyice karıştırmış olmanız gerekiyor. Yumurtaları yedirdikten sonra hamuru 10 dakika dinlendirin.
4.Hamurlarımızı pişirelim. Yağlanmış tepsiye, kaşık yardımı ile hamurdan ceviz büyüklüğünde parçalar alarak aralarında 2-3 cm boşluk bulunmasına dikkat ederek resimdeki gibi dökün. 
Elinizle şekillendirmeye çalışmayın.
5.Daha önceden 180 derecede ısıttığımız fırına hamuru sürün. üzeri kızarana kadar yaklaşık 40 dakika pişiriyorsunuz.
6.Profiterol Kremasını hazırlayalım. Hamurlar piştikten sonra kremasını hazırlayın. Vanilya hariç diğer malzemeleri bir tencereye koyarak kremayı pişirin.
7.Kremayı ocaktan aldıktan sonra vanilyasını ekleyerek karıştırın.
8.Kremayı profiterol hamurlarına dolduralım. Profiterolün  pişen hamurlarını ikiye bölerek ya da varsa krema sıkma torbası ile içlerini krema ile doldurun ve tepsiye dizin.
9.Tatlımızın üzerine çikolata sosu gezdirelim. Tüm profiterolleri doldurduktan sonra üzerine çikolata sosunu ya da benmari usulü erittiğiniz çikolatayı gezdirin."""
    },
{
    "isim":"Fırında Sütlaç",
    "malzemeler":"""
1 litre süt
1 su bardağı şeker
Yarım su bardağı pirinç
3 yemek kaşığı buğday nişastası
1 paket vanilya
2 su bardağı su
Yarım su bardağı süt (nişastayı açmak için)""",
"adimlar":"""
1.Fırında sütlaç için öncelikle pirinci haşlayalım. Pirinçleri güzelce yıkadıktan sonra 2 su bardağı su ile pirinçler yumuşayıp pişene kadar haşlayın. Çok az sulu kalacaktır.
2.Diğer malzemeleri ekleyelim ve sütlacı pişirelim. Haşlanan pirinçlerin üzerine sütü, vanilyayı ilave edip kaynatın.
3.Bu arada bir kap içerisinde nişasta ve sütü (suyu) pürüzsüz kıvam alıncaya kadar karıştırın.
4.Karışım kaynamaya başlayınca şekeri ve yarım su bardağı sütle karıştırdığınız 3 yemek kaşığı buğday nişastasını ilave ediniz. 10-15 dk. daha kaynatıp ocağın altını kapatın.
5.Sütlaçları fırına sürelim. Fırın için uygun ısıya dayanıklı sütlaç kaselerine sütlaçlarınızı paylaştırın.
6.Tepsinize soğuk su doldurun ve sütlaç kaplarını fırın tepsinize dizin (Tepsideki su sütlaç kaplarının yarısına kadar gelecek)
7.Tepsiyi fırınınızın en üst rafına yerleştirin.
8.180 derecede, sütlaçlarınız kızarana kadar fırınlayın. 
Afiyet olsun."""
},
        {
         "isim":"Magnolia",
         "malzemeler": """
1 paket burçak bisküvi
3 su bardağı süt
1 su bardağı toz şeker
3 yemek kaşığı un
1 yemek kaşığı nişasta
1 paket vanilin
1 paket labne peyniri
1 su bardağı çilek (isteğe bağlı)""",
        "adimlar": """
1. Bisküvileri rondoda un haline getirin.
2. Süt, şeker, un ve nişastayı bir tencereye alın, sürekli karıştırarak muhallebi kıvamına getirin.
3. Muhallebi ocaktan aldıktan sonra vanilin ve labneyi ekleyip çırpın.
4. Kupların tabanına bisküvi kırıntıları serpin, üzerine muhallebi ekleyin.
5. İsteğe göre çilek veya muz dilimleriyle süsleyerek servis edin.s
Afiyet olsun!"""
        },
    ],
    "Çorbalar": [
        {
            "isim": "Mercimek Çorbası",
            "malzemeler": """
2 su bardağı kırmızı mercimek
1 adet soğan
2 yemek kaşığı un
1 adet havuç
Yarım yemek kaşığı biber ya da  domates salçası (rengi kırmızı olsun isterseniz artırabilir ya da hiç kullanmayabilirsiniz)
1 tatlı kaşığı tuz
Yarım çay kaşığı karabiber
1 çay kaşığı kimyon (isteğe bağlı)
2 litre sıcak su
5 yemek kaşığı sıvı yağ

Sosu için:
2 yemek kaşığı tereyağı
1 tatlı kaşığı kırmızı toz biber""",
            "adimlar": """
1.Kırmızı mercimek çorbası için sıvı yağı tencereye alınarak yemeklik doğranan soğanlar hafif pembeleşinceye kadar kavrulur.
2.Daha sonra un ilave edilerek kısık ateşte kavurmaya devam edilir.
3.Salça kullanılacak ise salça ilave edilir, kavrulduktan sonra küp küp doğranmış havuç ve iyice yıkanıp suyu süzülen mercimekler ilave edilir.
4.Üzerine su eklenerek karıştırılır ve tencerenin kapağı kapatılır. Çorbamız kaynayana kadar orta ateşte, kaynadıktan sonra mercimekler ve havuçlar yumuşayana kadar ara ara karıştırılarak kısık ateşte pişirilir.
5.Çorba piştikten sonra el blenderı ile güzelce ezilir. Eğer blenderiniz yoksa süzgeçten de geçirebilirsiniz.
6.Karabiber, tuz ve isteğe bağlı olarak kimyon eklenir ve karıştırılır. 5 dakika daha pişirilerek ocaktan alınır.
7.Kıvamı koyu gelirse size, bir miktar su ilave edilerek bir taşım kaynatılır.
8.Bu arada küçük bir tavaya iki yemek kaşığı tereyağı alınır, kızdırılır ve bir tatlı kaşığı kırmızı toz biber eklenerek ocaktan alınır.
9.Mercimek çorbası servis kasesine alındıktan sonra üzerine kırmızı biberli sos gezdirilir ve bir dilim limon ile servis edilir.
            """
        },
    
        {
     "isim": "Tavuk Çorbası",
      "malzemeler": """
2 adet haşlanmış tavuk budu
3 yemek kaşığı şehriye
2 yemek kaşığı zeytinyağ
2 yemek kaşığı yoğurt
1.5 yemek kaşığı un
1 adet yumurtanın sarısı
2 diş rendelenmiş sarımsak
1/2 (yarım) adet limon (yarım)
1 çay kaşığı karabiber
1 tatlı kaşığı tuz
8-9 su bardağı su (tavuğun kendi suyunu da kullanıyoruz)""",
    "adimlar": """
1.Önce tavukları haşlıyoruz.
2.Terbiyesini hazırlıyoruz un,yoğurt,yumurtayı bir kapta çırpıyoruz.
3.İçine yarım su bardağı su ilave edip iyice pütürsüz olacak şekilde çırpıyoruz.
4.Haşlanmış tavuğun suyundan sıcak olarak içine üç kepçe kadar alıp terbiyeyisine ilave edip iyice çırpıyoruz.
5.Çorbayı hazırlayacağım tencereye sıvı yağ ilave ediyoruz şehriyeyi hafif rengi dönmeden kavuruyoruz.
6.Parçalanmış tavukları ilave ediyoruz bir taşım hepsini kaynatıyoruz.
7.Çorbanın içine terbiyesini ilave ediyoruz bir taşım kaynatıyoruz.
8.İçine yarım sıkılmış limon suyunu ve tuzunu ilave ederek çorbamızı bir taşım daha kaynatıyoruz. Kıvam alınca ocağı kapatıyoruz.
9.Üzerine tereyağ ve kırmızı biber kavurup servise sunuyoruz.
Afiyet olsun!"""
      },
         {
     "isim": "Domates Çorbası",
      "malzemeler": """
3 adet domates
2 yemek kaşığı sıvı yağ
1 yemek kaşığı tereyağ
2 yemek kaşığı un(tepeleme)
1 yemek kaşığı salça
1 tatlı kaşığı tatlı kırmızı toz biber
1 çay bardağı süt
5 su bardağı su
1 çay kaşığı karabiber
Tuz

Üzeri için:
Kurutulmuş ekmek
Rendelenmiş kaşar peyniri""",
    "adimlar": """ 
1. İlk önce sıvı yağ ve tereyağı eritin unu koyup kokusu çıkana kadar kavurun.
2. Kabukları soyulmuş domatesi rondoda çekin ve kavrulmuş unun içine atın.
3. Salçayı, tatlı kırmızı toz biberi de ekleyip bir dakika kadar daha kavurun.
4. Üzerine yavaş yavaş suyu ekleyip topaklanmaması için karıştırın. Sonra isterseniz süzgeçten geçirin.
5. İçine karabiber ve tuz ekleyip karıştırarak pişirin.
6. Kaynamaya başlayınca altını kısıp 2 dakika kadar daha kaynatın.
7. İçine sütü ekleyip bir taşım kaynatıp altını kapatın.
8. Servis yaparken üzerine ekmekleri ve kaşar peynirini ekleyerek servis yapın.
Afiyet olsun!"""
      },
      {
            "isim": "Yoğurt Çorbası",
            "malzemeler": """
1 çay bardağı pirinç
6 su bardağı sıcak su
2 su bardağı yoğurt
1 adet yumurta sarısı
1 tepeleme yemek kaşığı un
2 çay kaşığı kuru nane
2 çay kaşığı tuz

             Üzeri İçin:
1/2 yemek kaşığı tereyağı
1 yemek kaşığı zeytinyağı
1 tatlı kaşığı kuru nane""",
            "adimlar": """
1. Yoğurt çorbası yapımı için yıkanmış pirinçleri tencereye ekleyin ve üzerine sıcak suyu ekleyip pirinçler yumuşayana kadar 10 dakika pişirin.
2. Bir kasede yumurta sarısı, yoğurt ve unu karıştırın.
3. Pirinçlerle birlikte kaynayan sudan birkaç kepçe alarak yumurtalı karışıma ekleyin.
4. Kesilmemesi için hızlıca karıştırın.
5. Ardından kasedeki karışımı tencereye yavaş yavaş aktarın ve bu sırada sürekli olarak karıştırın.
6. Son olarak kuru nane ve tuzu ekleyip pişirmeye bırakın.
7. Servis öncesi tereyağı, zeytinyağı ve kuru naneyi bir sos tavasında kızdırıp üzerine gezdirin. 
Afiyet olsun!
            """
        },
{
            "isim": "Ezogelin Çorbası",
            "malzemeler": """
1 yemek kaşığı sıvı yağ
1 yemek kaşığı tereyağı
1 adet kuru soğan
2 diş sarımsak
1 su bardağı kırmızı mercimek
1 kahve fincanı bulgur (4 yemek kaşığı)
Yarım kahve fincanı pirinç (2 yemek kaşığı)
8.5 su bardağı sıcak su 
                   """,
            "adimlar": """
1.Tencereye tereyağı ve 1 yemek kaşığı sıvı yağ tencereye alınarak ısıtılır.
2.Soğan ve sarımsak küçük küçük doğranır ve tencerede orta ateşte, soğanlar diriliğini kaybedinceye kadar kavrulur. Dilerseniz sarımsakları rendeleyerek de kullanabilirsiniz.
3.Üzerine yıkanmış ve suyu süzülmüş olan kırmızı mercimek, pirinç ve bulgur eklenerek karıştırılır ve kavrulur.
4.Üzerine sıcak su ilave edilerek tencerenin kapağı kapatılır ve pişmeye bırakılır. Çorba kaynayana kadar yüksek ateşte kaynadıktan sonra kısık ateşte ara ara karıştırılır.
5.Bakliyatlar yumuşayınca kadar yaklaşık 35 dakika pişirilir ve ocak kapatılır.
6.Ayrı bir yerde 2 yemek kaşığı sıvı yağ ısıtılır.
7.1 yemek kaşığı un eklenir ve unun kokusu çıkana kadar karıştırılarak kavrulur.
8.Üzerine 2 yemek kaşığı domates salçası eklenir, 1-2 dakika daha kavrulur.
9.Salça da kavrulduktan sonra 2 su bardağı kadar su ilave edilerek kaynatılır.
10.Nane, kırmızı biber, karabiber ilave edilerek hazırlanan sos ocaktan alınır ve çorbaya ilave edilir.
11.Tuzu da eklenerek 1-2 dakika kaynatılır. Bu aşamada gerek duyarsanız sıcak su ekleyebilirsiniz. Ben 2,5 su bardağı kadar sıcak su ekledim ancak siz çorbanızın kıvamına göre ayarlayabilirsiniz.
12.Yaklaşık 5 dakika daha kaynattıktan sonra Ezogelin Çorbamız servise hazır.
Afiyet olsun!
            """
        },
        
    ],
    "Ana Yemekler": [
        {
            "isim":"Fırında Tavuk Şiş",
            "malzemeler":"""
-1 kg kadar kemiksiz göğüs eti ya da pirzola
-Yeşil biber
-Çeri domates

Marine için:
-3 yemek kaşığı yoğurt
-Yarım su bardağı sıvı yağ
-3 diş sarımsak
-1 tatlı kaşığı Tuz
-1 çay kaşığı Kekik
-1 çay kaşığı Pul biber
-1 yemek kaşığı salça
-Yarım çay kaşığı Kimyon""",
"adimlar":"""
1-Marine için gerekli malzemeleri karıştırma kabına alalım ve güzelce çırparak hazırlayalım.
2-Tavuk etlerini küp küp doğrayıp hazırladığımız sosun içine boşaltalım ve güzelce karıştıralım.
3-Üzerini streç film ile kapatalım ve en az iki saat kadar karışımı buzdolabında bekletelim.
4-Zamanınız yoksa bekletmeden de hazırlayabilirsiniz ancak etlerinizi ne kadar çok marine ederseniz o kadar lezzetli ve yumuşak olacaktır.
5-Daha sonra streci çıkartalım ve tavukları çok sıkıştırmadan çöp şiş çubuklarına dizelim.
6-Yıkayıp saplarını kopardığımız çeri domatesleri ve doğradığımız yeşil biberleri de çöp şişlere dizdikten sonra pişirme kağıdı serdiğimiz fırın tepsisine hepsini aralıklı olarak yerleştirelim.
7-Önceden ısıttığımız 200°C fırında 30 dakika boyunca etlerimizi ve sebzelerimizi pişmeye bırakalım.
8-Sürenin sonunda nar gibi kızaran tavuk şişlerimiz servise hazır. 
Afiyet olsun."""
        },
        {
            "isim":"Kadınbudu Köfte",
            "malzemeler":"""
Köfte harcı için:
-500 gr yağsız dana kıyması
-1 çay bardağı pirinç
-1 adet yumurta
-1 adet soğan
-1 tatlı kaşığı tuz
-1 çay kaşığı karabiber
-2 yemek kaşığı zeytinyağı

Kızartmak için;
-Un
-3 adet yumurta
-Sıvı yağ""",
"adimlar":"""
1-Uygun bir tencereye pirinçleri alalım. Üzerini geçecek kadar suyu ilave ederek yumuşayıncaya kadar yaklaşık 10 dakika haşlayalım.
2-Ocağa aldığımız tavaya zeytinyağını alarak  yemeklik doğradığımız soğanı ekleyelim ve rengi dönene kadar birkaç dakika kavuralım.
3-Üzerine kıymanın yarısını ilave ederek orta ateşte rengi değişene kadar kavuralım.
4-Kavurduğumuz kıymayı geniş bir karıştırma kabına alalım.
5-Üzerine haşladığımız pirinci, kalan kıymayı, yumurtayı, karabiber ve tuzu da ekleyerek elimizle yoğuralım. Önemli olan malzemenin birbiriyle iyice özdeşmesidir.
6-Hazır olan köfte harcının üzerini streçleyelim. Buzdolabında dinlenmeye bırakalım.
7-En az yarım saat kadar dinlendirdikten sonra hazırladığımız harçtan büyük parçalar kopartalım ve elimizle yuvarlayarak köfte şeklini verelim.
8-Şekillendirdiğimiz köftelerin her iki tarafını una bulayalım.  Daha sonra bir kase içerisine kırıp çırptığınız yumurtaya batıralım.
9-Tavada iyice kızdırılan sıvı yağda köftelerin her iki yönünü güzelce kızartalım.
Kızaran köfteleri kağıt havlu üzerine alarak fazla yağı alalım ve ardından servise hazır.
 Afiyet olsun…"""
        },
    {
        "isim":"Soğan Dolması",
        "malzemeler":"""
-5 adet soğan (dolmalık)
-300 gram kıyma (göz kararı artırabilirsiniz)
-5 diş sarımsak
-1 su bardağı pirinç
-1-2 adet soğan (iç harcı için, ince kıyılmış)
-Zeytinyağı
-1 yemek kaşığı salça
-İsot
-Tuz
-Pul biber
-Bir tutam maydanoz (ince doğranmış)
-Limon tuzu (damak zevkinize göre)
-Yarım bardak su (iç harcı için)

Üzerine:
-1 su bardağı su
-Pul biber""",
"adimlar":"""
1-Soğanların kabuklarını soyun ve her birine uzunlamasına bir çizik atın.
2-Ardından sıcak su dolu bir tencereye koyarak yumuşayana kadar bekletin.
3-Yumuşayan soğanları sudan çıkarıp soğumaya bırakın.
4-Kıyma, ince doğranmış soğan, pirinç, rendelenmiş  sarımsak, zeytinyağı,  salça,  isot,  pul biber, tuz,  maydanoz,  limon tuzu ve yarım bardak suyu geniş bir kaseye alın.
5-Tüm malzemeleri iyice karıştırarak iç harcınızı hazırlayın.
6-Yumuşayan soğanları dikkatlice açın ve iç harcı doldurun. Çok fazla doldurmamaya özen gösterin; pişerken iç harç şişecektir. Doldurduğunuz soğanları fırın kabına yerleştirin.
7-1 su bardağı suyu bir kaseye alın. İçine biraz  pul biber ekleyerek karıştırın. Bu sosu dolmaların üzerine gezdirin.
8-Fırın kabının üzerini kapatın (alüminyum folyo veya kapağıyla) ve önceden ısıtılmış 180°c fırında yaklaşık 40-45 dakika pişirin. Ardından üzerini açıp birkaç dakika daha kızarmasını sağlayabilirsiniz.
9-Sunum önerisi:Soğan dolmalarını fırından çıkarır çıkarmaz sıcak olarak servis edin. Yanına yoğurt ekleyerek bu nefis lezzeti tamamlayabilirsiniz.
Afiyet olsun.."""
    },
    {
"isim":"Karnıyarık",
"malzemeler":"""
-6 adet küçük boy patlıcan (büyük ise ikiye bölebilirsiniz)
-3 adet sivri biber

Kıymalı Harç İçin;
-2 adet orta boy soğan
-2 adet domates
-2 adet sivri biber
-2 diş sarımsak
-Sıvı yağ, tuz, karabiber, kırmızıbiber
-200 gr kıyma
-1 çay bardağı sıcak su

Sosu İçin;
-1 yemek kaşığı salça
-1 su bardağı sıcak su""",
"adimlar":"""
1-Patlıcanları çizgili soyup, yarım saat yağ çekmemesi için tuzlu suda bekletin.
2-İyice yıkadıktan sonra suyunu havlu ile çektirin ve az yağda kızartın. 3 adet biberi de yağda kızartın.
3-Daha sonra aynı tavada doğranmış soğanları kavurun, kıymayı ekleyerek bir müddet daha kavurun ve biberleri, sarımsağı ekleyerek 2 dakika daha kavurun.
4-Küp küp doğramış olduğunuz 2 adet domatesi, tuzu, baharatları ekleyerek karıştırın.
5-Üzerine bir çay bardağı su ekleyerek 5 dk kaynatın.
6-Tepsiye patlıcanların ortalarını keserek yerleştirin ve bu kesiklerden patlıcanın içine bastırarak iç malzemesine yer açın ve malzeme ile patlıcanları doldurun.
7-Doldurduğunuz patlıcanların üzerine ortadan ikiye kestiğiniz çeri domatesi ya da 1 adet domatesi eşit büyüklükte olacak şekilde paylaştırın ve kızarttığımız biberlerden birer tane koyun.
8-Ayrı bir yerde 1 kaşık salçayı, 1 su bardağı sıcak suda ezerek patlıcanların aralarına dökün. Kıymalar çıkmasın diye üzerine dökmeyin.
9-Daha sonra 170 derece de ısıttığınız fırına sürerek 20-25 dk pişirin. Dilerseniz bu işlemi pilav tenceresi gibi bir tencerede ocakta yapabilirsiniz. Aynı sürede tencerede de  pişecektir.
Afiyet olsun.."""
    },
    {
        "isim":"Çökertme Kebabı",
        "malzemeler":"""
-800 gr dana eti (jülyen doğranmış)
-1 adet kuru soğan
-1 tatlı kaşığı biber salçası
-1 tatlı kaşığı tuz
-1 tatlı kaşığı kekik
-1 çay kaşığı pul biber
-1 çay kaşığı toz kırmızı biber
-4 yemek kaşığı sıvı yağ
-2 su bardağı sıcak su (400 ml)
-500 gr dondurulmuş patates

-Servis için;
-1,5 su bardağı yoğurt
-Yarım çay kaşığı tuz
-50 gr tereyağı
-1 çay kaşığı pul biber""",
"adimlar":"""
1-Çökertme kebabı için öncelikle etlerimizi jülyen doğrayalım.
2-Ardından döküm bir tencereye alarak etler suyunu salıp çekene kadar, ara ara karıştırarak yaklaşık 30 dakika pişirelim. 
Bu aşamada en iyi sonucu ben döküm tencere ile aldım, sizin de varsa kullanmanızı tavsiye ederim.
3-Et suyunu çektikten sonra yaklaşık sıvı yağ ve yemeklik doğranmış soğanı ilave edelim.
4-Birkaç dakika soğanları da etle birlikte kavuralım.
5-Biber salçası, toz biber, pul biber, kekik ve tuz ekleyerek 1-2 tur karıştıralım. Ardından suyu ekleyelim.
6-Tencerenin kapağını kapatalım ve orta ateşte suyunu çekip yumuşayıncaya kadar pişmeye bırakalım.
7-Etler pişerken diğer taraftan airfryer’e dondurulmuş patates alalım.
8-Patates kızartma programında yaklaşık 20 dakika kadar pişmeye bırakalım. Eğer hazır dondurulmuş patates kullanmayı tercih etmezseniz 4 tane orta boy patates bu tarif için yeterli olacaktır. 
İnce kibrit çöpü şeklinde doğradığınız patatesleri kızgın yağda da kızartabilirsiniz.
9-Etlerimiz suyunu çekip lokum gibi piştikten sonra sunum kısmına geçebiliriz. Eğer etleriniz tam pişmediyse 1 su bardağı su ekleyerek pişirmeye devam edebilirsiniz.
10-Servis için öncelikle tabağa kızarmış patateslerimizi alalım.
Üzerine biraz tuzla çırptığımız yoğurdu gezdirelim. Yoğurdun üzerine daha sonra etlerimizi yerleştirelim.
11-Son olarak tereyağında kızdırdığımız pul biberi de yemeğin üzerine gezdirelim.
Biraz maydanoz serpiştirerek renklendirdiğimiz çökertme kebabımız artık servise hazır.
Afiyet olsun!"""
    }
    ],
    "Smoothie":[
    {
      "isim": "Yeşil Smoothie", 
"malzemeler":"""
-1 adet muz (dondurulmuş muz da kullanabilirsiniz)
-1 su bardağı ıspanak
-1 adet kabuğu soyulmuş portakal
-1 adet salatalık
-1,5 su bardağı su""",


"adimlar":"""
1-Bütün malzemelerimizi blendera koyup pürüzsüz olana kadar karıştırıyoruz. 
Afiyet olsun"""
    },
    {
"isim":"Ahududu-Çilek Smoothie",
"malzemeler":"""
-1 çay bardağından 1 parmak az süt
-1 çay bardağından 1 parmak az su
-1 kase dondurulmuş ahududu
-5 adet orta boy çilek
-1 yemek kaşığı limon suyu
-1 yemek kaşığı hindistan cevizi (opsiyonel)""",
"adimlar":"""
1-Çilekleri yıkayıp baş kısımlarını alıp ortadan ikiye bölüyoruz ve diğer tüm malzemelerle birlikte rondodan çekiyoruz.
Smoothiemiz hazır.
Deneyenlere afiyet olsun."""
    },
    {
"isim":"Muzlu Oreo Bisküvili Smoothie",
"malzemeler":"""
-1 doldurulmuş muz
-4 adet Oreo bisküvi
-125 ml süt
-125 ml yoğurt""",
"adimlar":"""
Tüm malzemeleri blendera koyup iyice karıştırınız. 
Eğer dondurulmuş muzunuz yoksa bir kaç buz kübü ekleyebilirsiniz. 
Buz gibi olmasıyla beraber tadı çok güzel olan bir smoothie. 
Afiyet olsun."""
    },

    {
"isim":"Armutlu Smoothie",
"malzemeler":"""
-1 adet küçük boy armut
-1 su bardağı yarım yağlı süt
-2 yemek kaşığı yarım yağlı yoğurt
-1 dilim zencefil
-1 tatlı kaşığı hindistan cevizi tozu
-1 çay kaşığı tarçın""",
"adimlar":"""
Malzemeleri blenderdan geçirin ve hazır.
Afiyet olsun."""
    }
    ]
}


# Kullanıcı bilgileri (Kayıtlı kullanıcılar ve şifreleri)
kullanici_bilgileri = {}
kullanici_tarifleri = {}

# Ekranı temizlemek için bir fonksiyon
def temizle_ekran(frame):
    for widget in frame.winfo_children():
        widget.destroy()

# Ana Menü
def ana_menu(frame):
    temizle_ekran(frame)

    frame.configure(bg="#EDE7F6")  # Arka plan rengi (pastel tonlar)

    # Ana menü çerçevesi
    menu_frame = tk.Frame(frame, bg="#D1C4E9", bd=2, relief="ridge")
    menu_frame.place(relx=0.5, rely=0.5, anchor="center", width=600, height=400)

    # Başlık
    tk.Label(
        menu_frame,
        text="🍴 YEMEK TARİFİ UYGULAMASI 🍲",
        font=("Arial", 18, "bold"),
        bg="#D1C4E9",
        fg="#6A4E77",
    ).pack(pady=20)

    # Bilgilendirme metni
    tk.Label(
        menu_frame,
        text="En lezzetli tarifler için doğru yerdesiniz!",
        font=("Arial", 14), fg="#6A4E77",).pack(pady=10)

    # Giriş yap butonu
    tk.Button(
        menu_frame, text="👤 Giriş Yap", command=lambda: giris_ekrani(frame), width=20, height=2, bg="#D89EC7", fg="#6A4E77", font=("Arial", 12, "bold"), relief="groove",).pack(pady=10)

    # Kayıt ol butonu
    tk.Button(
        menu_frame, text="✍️ Kayıt Ol", command=lambda: kayit_ekrani(frame), width=20, height=2, bg="#D89EC7", fg="#6A4E77", font=("Arial", 12, "bold"), relief="groove",).pack(pady=10)

    # Çıkış butonu
    tk.Button(
        menu_frame, text="🚪 Çıkış", command=root.quit, width=20, height=2, bg="#D89EC7", fg="#6A4E77", font=("Arial", 12, "bold"), relief="groove",).pack(pady=10)

    # Alt bilgi
    tk.Label(
        menu_frame, text="Afiyetle pişir, afiyetle ye! 🍽️", font=("Arial", 12, "italic"), bg="#D1C4E9", fg="#6A4E77",
    ).pack(pady=20)

# Kullanıcı kaydı ekranı
def kayit_ekrani(frame):
    temizle_ekran(frame)
    frame.configure(bg="#EDE7F6")

    tk.Label(frame, text="=== Kullanıcı Kayıt ===", font=("Arial", 18, "bold"), fg="white", bg="#6A4E77").pack(pady=20)

    # Kullanıcı adı girişi
    tk.Label(frame, text="Kullanıcı Adı:", font=("Arial", 14), fg="white", bg="#6A4E77").pack(pady=5)
    kullanici_adi_entry = tk.Entry(frame, width=25, font=("Arial", 12))
    kullanici_adi_entry.pack(pady=5)

    # Şifre girişi
    tk.Label(frame, text="Şifre:", font=("Arial", 14), fg="white", bg="#6A4E77").pack(pady=5)
    sifre_entry = tk.Entry(frame, show="*", width=25, font=("Arial", 12))
    sifre_entry.pack(pady=5)

    # Kayıt yapma fonksiyonu
    def kayit_yap():
        kullanici_adi = kullanici_adi_entry.get().strip()
        sifre = sifre_entry.get().strip()

        if kullanici_adi and sifre:
            if kullanici_adi in kullanici_bilgileri:
                messagebox.showerror("Hata", "Bu kullanıcı adı zaten mevcut!")
            else:
                kullanici_bilgileri[kullanici_adi] = sifre
                messagebox.showinfo("Başarılı", "Kayıt başarılı! Şimdi giriş yapabilirsiniz.")
                giris_ekrani(frame)
        else:
            messagebox.showerror("Hata", "Kullanıcı adı ve şifre boş bırakılamaz!")

    # Kayıt ol butonu
    tk.Button(frame, text="Kayıt Ol", command=kayit_yap, width=20, height=2, font=("Arial", 14), bg="#6A4E77", fg="white").pack(pady=20)
    tk.Button(frame, text="Ana Menüye Dön", command=lambda: ana_menu(frame), width=20, height=2, font=("Arial", 12), bg="#6A4E77", fg="white").pack(pady=10)

# Kullanıcı girişi ekranı
def giris_ekrani(frame):
    temizle_ekran(frame)
    frame.configure(bg="#EDE7F6")

    tk.Label(frame, text="=== Kullanıcı Girişi ===", font=("Arial", 18, "bold"), fg="white", bg="#6A4E77").pack(pady=20)

    # Kullanıcı adı girişi
    tk.Label(frame, text="Kullanıcı Adı:", font=("Arial", 14), fg="white", bg="#6A4E77").pack(pady=5)
    kullanici_adi_entry = tk.Entry(frame, width=25, font=("Arial", 12))
    kullanici_adi_entry.pack(pady=5)

    # Şifre girişi
    tk.Label(frame, text="Şifre:", font=("Arial", 14), fg="white", bg="#6A4E77").pack(pady=5)
    sifre_entry = tk.Entry(frame, show="*", width=25, font=("Arial", 12))
    sifre_entry.pack(pady=5)

    # Giriş yapma fonksiyonu
    def giris_yap():
        kullanici_adi = kullanici_adi_entry.get().strip()
        sifre = sifre_entry.get().strip()

        if kullanici_adi in kullanici_bilgileri and kullanici_bilgileri[kullanici_adi] == sifre:
            messagebox.showinfo("Başarılı", f"Giriş başarılı! Hoş geldiniz, {kullanici_adi}!")
            profil_ekrani(frame, kullanici_adi)  # Profil ekranına yönlendir
        else:
            messagebox.showerror("Hata", "Kullanıcı adı veya şifre yanlış!")

    # Giriş yap butonu
    tk.Button(frame, text="Giriş Yap", command=giris_yap, width=20, height=2, font=("Arial", 14), bg="#6A4E77", fg="white").pack(pady=20)
    tk.Button(frame, text="Ana Menüye Dön", command=lambda: ana_menu(frame), width=20, height=2, font=("Arial", 12), bg="#6A4E77", fg="white").pack(pady=20)
    tk.Label(frame, text="Hesabınız yok mu? ", font=("Arial", 12), fg="black", bg="#D1C4E9").pack(pady=8)
    tk.Button(frame, text="Kayıt Ol", command=lambda: kayit_ekrani(frame), width=10, height=2, font=("Arial", 10), bg="#6A4E77", fg="white").pack(pady=10)

# Ekranı temizlemek için bir fonksiyon
def temizle_ekran(frame):
    for widget in frame.winfo_children():
        widget.destroy()

def profil_foto_ekle(frame, resim_adı):
    try:
        # Resmi yükle
        image = Image.open(resim_adı)
        image = image.resize((300, 200), Image.Resampling.LANCZOS)  # Boyutlandırma (isteğe bağlı)

        # Resmi Tkinter ile uyumlu hale getir
        photo = ImageTk.PhotoImage(image)

        # Resmi göster
        resim_label = tk.Label(frame, image=photo, justify="right", bg="#6A4E77")
        resim_label.pack(pady=15)

        # Resim referansını sakla, aksi takdirde resim kaybolabilir
        resim_label.image = photo  # image özelliğine resim referansını sakla
    except Exception as e:
        print(f"Resim yüklenemedi: {e}")
def profil_ekrani(frame, kullanici_adi):
    temizle_ekran(frame)
    frame.configure(bg="#EDE7F6")

    tk.Label(frame, text="=== Profilim ===", font=("Arial", 18, "bold"), fg="white", bg="#6A4E77").pack(pady=20)

    # Profil fotoğrafı ekleniyor
    profil_foto_ekle(frame, "profil.png")

    # Kullanıcı adı
    tk.Label(frame, text=f"Kullanıcı Adı: {kullanici_adi}", font=("Arial", 14), fg="white", bg="#6A4E77").pack(pady=5)

    # Şifre girişi (isteğe bağlı, şifreyi değiştirme seçeneği eklenebilir)
    tk.Label(frame, text="Şifre: ********", font=("Arial", 14), fg="white", bg="#6A4E77").pack(pady=5)

    # Kullanıcı tariflerini gösterme
    if kullanici_adi in kullanici_tarifleri and kullanici_tarifleri[kullanici_adi]:
        tk.Label(frame, text="Eklediğiniz Tarifler:", font=("Arial", 14), fg="white", bg="#6A4E77").pack(pady=10)
        for tarif in kullanici_tarifleri[kullanici_adi]:
            tk.Label(frame, text=f"- {tarif}", font=("Arial", 12), fg="white", bg="#6A4E77").pack(pady=5)
    else:
        tk.Label(frame, text="Henüz tarif eklemediniz.", font=("Arial", 12), fg="white", bg="#6A4E77").pack(pady=10)

    # Haftalık menü oluşturma butonu
    tk.Button(frame, text="Haftalık Menü Oluştur", command=lambda: haftalik_menu_olustur(frame, kullanici_adi), width=20, height=2, font=("Arial", 12), bg="#6A4E77", fg="white").pack(pady=10)

    # Şifreyi değiştirme butonu
    def sifre_degistir():
        sifre_guncelleme_ekrani(frame, kullanici_adi)
        frame.configure(bg="#EDE7F6")

    # Şifre değiştirme butonu ekleniyor
    tk.Button(frame, text="Şifreyi Değiştir", command=sifre_degistir, width=20, height=2, font=("Arial", 12), bg="#6A4E77", fg="white").pack(pady=10)
    
    # Tarif ekleme butonu
    tk.Button(frame, text="Tarif Ekle", command=lambda: tarif_ekle(frame, kullanici_adi), width=20, height=2, font=("Arial", 12), bg="#6A4E77", fg="white").pack(pady=10)
    
    # Ana menüye dönme butonu
    tk.Button(frame, text="Menüye Git", command=lambda: kategori_secimi(frame), width=20, height=2, bg="#6A4E77", fg="#FFFFFF", font=("Arial", 12)).pack(pady=10) 
    
    tk.Button(frame, text="Ana Menüye Dön", command=lambda: ana_menu(frame), width=20, height=2, font=("Arial", 12), bg="#6A4E77", fg="white").pack(pady=10)
    

# Temizleme fonksiyonu
def temizle_ekran(frame):
    for widget in frame.winfo_children():
        widget.destroy()

def haftalik_menu_olustur(frame, kullanici_adi):
    temizle_ekran(frame)
    frame.configure(bg="#EDE7F6")
    
    # Frame'i genişletilebilir hale getirme
    for i in range(8):  # Günler + Başlık + Butonlar
        frame.grid_rowconfigure(i, weight=1)
    for j in range(4):  # 4 sütun (Gün, Sabah, Öğle, Akşam)
        frame.grid_columnconfigure(j, weight=1)

    # Başlık
    tk.Label(frame, text="=== Haftalık Menü Oluştur ===", font=("Arial", 18, "bold"), fg="white", bg="#6A4E77").grid(row=0, column=0, columnspan=4, pady=20, sticky="nsew")

    # Başlıklar (Günler ve Öğünler)
    basliklar = ["Gün", "Sabah", "Öğle", "Akşam"]
    for col, baslik in enumerate(basliklar):
        tk.Label(frame, text=baslik, font=("Arial", 14, "bold"), fg="white", bg="#6A4E77", padx=10, pady=5, borderwidth=1, relief="solid").grid(row=1, column=col, sticky="nsew", padx=2)

    # Giriş kutularını tutmak için bir sözlük
    gun_tarif_vars = {}
    gunler = ["Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi", "Pazar"]

    for row, gun in enumerate(gunler, start=2):
        tk.Label(frame, text=gun, font=("Arial", 12), fg="black", bg="#EDE7F6", padx=10, pady=5, borderwidth=1, relief="solid").grid(row=row, column=0, sticky="nsew", padx=2)
        
        gun_tarif_vars[gun] = {
            "sabah": tk.StringVar(),
            "ogle": tk.StringVar(),
            "aksam": tk.StringVar()
        }

        tk.Entry(frame, textvariable=gun_tarif_vars[gun]["sabah"], font=("Arial", 12), width=15).grid(row=row, column=1, pady=2, padx=2, sticky="nsew")
        tk.Entry(frame, textvariable=gun_tarif_vars[gun]["ogle"], font=("Arial", 12), width=15).grid(row=row, column=2, pady=2, padx=2, sticky="nsew")
        tk.Entry(frame, textvariable=gun_tarif_vars[gun]["aksam"], font=("Arial", 12), width=15).grid(row=row, column=3, pady=2, padx=2, sticky="nsew")

    def kaydet_menu():
        """
        Haftalık menüyü kaydeder.
        """
        global haftalik_menu
        haftalik_menu = {
            gun: {
                "sabah": gun_tarif_vars[gun]["sabah"].get(),
                "ogle": gun_tarif_vars[gun]["ogle"].get(),
                "aksam": gun_tarif_vars[gun]["aksam"].get()
            }
            for gun in gunler
        }
        messagebox.showinfo("Bilgi", "Menü başarıyla kaydedildi!")

    def goster_menu():
        """
        Haftalık menüyü gösterir.
        """
        haftalik_menu_goster(frame, kullanici_adi) # Eğer haftalik_menu_goster bir parametre alıyorsa, doğru şekilde çağrılır.

    # Butonlar
    tk.Button(frame, text="Kaydet", command=kaydet_menu, width=15, height=2, font=("Arial", 12), bg="#6A4E77", fg="white").grid(row=len(gunler)+2, column=1, pady=20, sticky="nsew")
    tk.Button(frame, text="Göster", command=goster_menu, width=15, height=2, font=("Arial", 12), bg="#6A4E77", fg="white").grid(row=len(gunler)+2, column=2, pady=20, sticky="nsew")
    tk.Button(frame, text="Profil Ekranına Dön", command=lambda: profil_ekrani(frame, kullanici_adi), width=20, height=2, font=("Arial", 12), bg="#6A4E77", fg="white").grid(row=len(gunler)+3, column=0, columnspan=4, pady=20, sticky="nsew")



def haftalik_menu_goster(frame, kullanici_adi):
    temizle_ekran(frame)
    frame.configure(bg="#D1C4E9")

    # Frame'i genişletilebilir hale getirme
    for i in range(10):  # Satırlar (Günler + Başlık + Butonlar)
        frame.grid_rowconfigure(i, weight=1)
    for j in range(4):  # 4 sütun
        frame.grid_columnconfigure(j, weight=1)

    # Başlık
    tk.Label(frame, text="=== Haftalık Menü ===", font=("Arial", 18, "bold"), fg="white", bg="#6A4E77").grid(row=0, column=0, columnspan=4, pady=20, sticky="nsew")

    # Başlıklar
    basliklar = ["Gün", "Sabah", "Öğle", "Akşam"]
    for col, baslik in enumerate(basliklar):
        tk.Label(frame, text=baslik, font=("Arial", 14, "bold"), bg="#EDE7F6", width=20).grid(row=1, column=col, padx=5, pady=5, sticky="nsew")

    # Menü Verileri
    row = 2
    for gun, yemekler in haftalik_menu.items():
        tk.Label(frame, text=gun, font=("Arial", 12), bg="#EDE7F6").grid(row=row, column=0, padx=5, pady=5, sticky="nsew")
        tk.Label(frame, text=yemekler['sabah'], font=("Arial", 12), bg="#F3E5F5").grid(row=row, column=1, padx=5, pady=5, sticky="nsew")
        tk.Label(frame, text=yemekler['ogle'], font=("Arial", 12), bg="#F3E5F5").grid(row=row, column=2, padx=5, pady=5, sticky="nsew")
        tk.Label(frame, text=yemekler['aksam'], font=("Arial", 12), bg="#F3E5F5").grid(row=row, column=3, padx=5, pady=5, sticky="nsew")
        row += 1

    # Ana Menüye Dön Butonu
    tk.Button(
        frame, 
        text="Profil Ekranına Dön", 
        command=lambda: profil_ekrani(frame, kullanici_adi), 
        width=20, 
        height=2, 
        font=("Arial", 12), 
        bg="#6A4E77", 
        fg="white"
    ).grid(row=row, column=0, columnspan=4, pady=20, sticky="nsew")

def temizle_ekran(frame):
    for widget in frame.winfo_children():
        widget.destroy()

# Şifre güncelleme ekranı
def sifre_guncelleme_ekrani(frame, kullanici_adi):
    global kullanici_bilgileri
    temizle_ekran(frame)
    frame.configure(bg="#D1C4E9")

    tk.Label(frame, text="=== Şifreyi Güncelle ===", font=("Arial", 18, "bold"), fg="white", bg="#6A4E77").pack(pady=20)

    # Yeni şifre girişi
    tk.Label(frame, text="Yeni Şifre:", font=("Arial", 14), fg="white", bg="#6A4E77").pack(pady=5)
    yeni_sifre_entry = tk.Entry(frame, show="*", width=25, font=("Arial", 12))
    yeni_sifre_entry.pack(pady=5)

    # Yeni şifreyi onaylama
    tk.Label(frame, text="Yeni Şifreyi Onaylayın:", font=("Arial", 14), fg="white", bg="#6A4E77").pack(pady=5)
    yeni_sifre_onay_entry = tk.Entry(frame, show="*", width=25, font=("Arial", 12))
    yeni_sifre_onay_entry.pack(pady=5)

    # Şifreyi güncelleme fonksiyonu
    def sifreyi_guncelle():
        yeni_sifre = yeni_sifre_entry.get().strip()
        yeni_sifre_onay = yeni_sifre_onay_entry.get().strip()

        if yeni_sifre == yeni_sifre_onay:
            kullanici_bilgileri[kullanici_adi] = yeni_sifre  # Şifre kaydediliyor
            messagebox.showinfo("Başarılı", "Şifreniz başarıyla güncellendi!")
            ana_menu(frame)  # Şifre güncellendikten sonra ana menüye yönlendirme
        else:
            messagebox.showerror("Hata", "Şifreler uyuşmuyor!")

    # Şifreyi güncelleme butonu
    tk.Button(
        frame, 
        text="Şifreyi Güncelle", 
        command=sifreyi_guncelle,  # Güncelleme ve ana menüye geçiş
        width=20, 
        height=2, 
        font=("Arial", 14), 
        bg="#6A4E77", 
        fg="white"
    ).pack(pady=20)

    # Profil ekranına dönme butonu
    tk.Button(
        frame, 
        text="Profil Ekranına Dön", 
        command=lambda: profil_ekrani(frame, kullanici_adi), 
        width=20, 
        height=2, 
        font=("Arial", 12), 
        bg="#6A4E77", 
        fg="white"
    ).pack(pady=20)
def kategori_secimi(frame):
    temizle_ekran(frame)

    # Arka plan rengi
    frame.configure(bg="#f4f4f9")

    # Başlık
    tk.Label(frame, text="Yemek Tarifleri", font=("Helvetica", 24, "bold"), fg="#ffffff", bg="#6A4E77", pady=25).pack(fill="x")

    # Kategori butonları
    tk.Button(frame, text="🍰 Tatlılar", command=lambda: tarif_detayi_goster_v2(frame, "Tatlılar"), width=20, height=3, 
              bg="#E0BBE4", font=("Arial", 13, "bold"), relief="flat", bd=0, padx=4, pady=4, highlightthickness=0, fg="#6A4E77", 
              activebackground="#D89EC7", borderwidth=1).pack(pady=18)

    tk.Button(frame, text="🍲 Çorbalar", command=lambda: tarif_detayi_goster_v2(frame, "Çorbalar"), width=20, height=3, 
              bg="#E0BBE4", font=("Arial", 13, "bold"), relief="flat", bd=0, padx=4, pady=4, highlightthickness=0, fg="#6A4E77", 
              activebackground="#D89EC7", borderwidth=1).pack(pady=18)

    tk.Button(frame, text="🍽️ Ana Yemekler", command=lambda: tarif_detayi_goster_v2(frame, "Ana Yemekler"), width=20, height=3, 
              bg="#E0BBE4", font=("Arial", 13, "bold"), relief="flat", bd=0, padx=4, pady=4, highlightthickness=0, fg="#6A4E77", 
              activebackground="#90CAF9", borderwidth=1).pack(pady=18)

    tk.Button(frame, text="🍹 Smoothie", command=lambda: tarif_detayi_goster_v2(frame, "Smoothie"), width=20, height=3, 
              bg="#E0BBE4", font=("Arial", 13, "bold"), relief="flat", bd=0, padx=4, pady=4, highlightthickness=0, fg="#6A4E77", 
              activebackground="#D89EC7", borderwidth=1).pack(pady=18)

    tk.Button(frame, text="📝 Tarif Ekle", command=lambda: tarif_ekle(frame, "kullanici_adi"), width=20, height=3, bg="#E0BBE4", 
              font=("Arial", 13, "bold"), relief="flat", bd=0, padx=4, pady=4, highlightthickness=0, fg="#6A4E77", 
              activebackground="#C47C8A", borderwidth=1).pack(pady=18)

    tk.Button(frame, text="🏠 Profil Ekranına Dön", command=lambda: profil_ekrani(frame, "kullanici_adi"), width=20, height=3, bg="#E0BBE4", 
          font=("Arial", 13, "bold"), relief="flat", bd=0, padx=4, pady=4, highlightthickness=0, fg="#6A4E77", 
          activebackground="#C47C8A", borderwidth=1).pack(pady=18)

    # Sosyal medya bağlantıları
    sosyal_medya_frame = tk.Frame(frame, bg="#f4f4f9")
    sosyal_medya_frame.pack(pady=15)

    tk.Label(sosyal_medya_frame, text="Bizi Takip Edin:", font=("Arial", 11, "bold"), fg="#6A4E77", bg="#f4f4f9").pack(side="left", padx=7)

    # Logoları yükle
    instagram_logo = ImageTk.PhotoImage(Image.open("instagram.png").resize((24, 24)))
    youtube_logo = ImageTk.PhotoImage(Image.open("youtube.png").resize((24, 24)))
    facebook_logo = ImageTk.PhotoImage(Image.open("facebook.png").resize((24, 24)))

    # Instagram bağlantısı
    instagram_label = tk.Label(sosyal_medya_frame, image=instagram_logo, text=" Instagram", compound="left", font=("Arial", 12, "bold"), 
                                fg="#6A4E77", cursor="hand2", bg="#f4f4f9")
    instagram_label.image = instagram_logo  # Referansı sakla
    instagram_label.pack(side="left", padx=10)
    instagram_label.bind("<Button-1>", lambda e: open_link("https://www.instagram.com"))

    # YouTube bağlantısı
    youtube_label = tk.Label(sosyal_medya_frame, image=youtube_logo, text=" YouTube", compound="left", font=("Arial", 12, "bold"), 
                              fg="#6A4E77", cursor="hand2", bg="#f4f4f9")
    youtube_label.image = youtube_logo  # Referansı sakla
    youtube_label.pack(side="left", padx=10)
    youtube_label.bind("<Button-1>", lambda e: open_link("https://www.youtube.com"))

    # Facebook bağlantısı
    facebook_label = tk.Label(sosyal_medya_frame, image=facebook_logo, text=" Facebook", compound="left", font=("Arial", 12, "bold"), 
                               fg="#6A4E77", cursor="hand2", bg="#f4f4f9")
    facebook_label.image = facebook_logo  # Referansı sakla
    facebook_label.pack(side="left", padx=10)
    facebook_label.bind("<Button-1>", lambda e: open_link("https://www.facebook.com"))

    def open_link(url):
        import webbrowser
        webbrowser.open(url)
# Tarif ekleme ekranı
def tarif_ekle(frame, kullanici_adi):
    temizle_ekran(frame)

    tk.Label(frame, text="=== Tarif Ekle ===", font=("Arial", 16)).pack(pady=10)

    # Kategori seçimi
    tk.Label(frame, text="Kategori Seçin:").pack(pady=5)
    kategori_entry = tk.Entry(frame, width=20)
    kategori_entry.pack(pady=5)

    # Tarif adı girişi
    tk.Label(frame, text="Tarif Adı:").pack(pady=5)
    tarif_adi_entry = tk.Entry(frame, width=20)
    tarif_adi_entry.pack(pady=5)

    # Malzemeler girişi
    tk.Label(frame, text="Malzemeler:").pack(pady=5)
    malzemeler_entry = tk.Text(frame, height=5, width=30)
    malzemeler_entry.pack(pady=5)

    # Adımlar girişi
    tk.Label(frame, text="Adımlar:").pack(pady=5)
    adimlar_entry = tk.Text(frame, height=5, width=30)
    adimlar_entry.pack(pady=5)

    # Tarifin kaydedilmesi işlemi
    def tarif_kaydet():
        kategori = kategori_entry.get().strip()
        tarif_adi = tarif_adi_entry.get().strip()
        malzemeler = malzemeler_entry.get("1.0", "end-1c").strip()  # Text widget'tan veri alıyoruz
        adimlar = adimlar_entry.get("1.0", "end-1c").strip()

        if kategori and tarif_adi and malzemeler and adimlar:
            # Kullanıcı tarifleri veritabanına ekleniyor
            if kullanici_adi not in kullanici_tarifleri:
                kullanici_tarifleri[kullanici_adi] = []
            kullanici_tarifleri[kullanici_adi].append({
                "kategori": kategori,
                "tarif_adi": tarif_adi,
                "malzemeler": malzemeler,
                "adimlar": adimlar
            })
            messagebox.showinfo("Başarılı", "Tarif başarıyla eklendi.")
            profil_ekrani(frame, kullanici_adi)
        else:
            messagebox.showerror("Hata", "Lütfen tüm alanları doldurun!") 

    # Tarif ekle butonu
    tk.Button(frame, text="Tarifi Kaydet", command=tarif_kaydet).pack(pady=10)
    
    # Menüye dönme butonu
    tk.Button(frame, text="Menüye Dön", command=lambda: kategori_secimi(frame), width=20, height=2, bg="#FF6F61", fg="#FFFFFF", font=("Arial", 12)).pack(pady=10)
    
    # Tarifleri göster butonu
    tk.Button(frame, text="Tarifi Göster", command=lambda: tarifleri_goster(frame, kullanici_adi)).pack(pady=10)

# Tarifleri gösterme fonksiyonu
def tarifleri_goster(frame, kullanici_adi):
    temizle_ekran(frame)  # Ekranı temizle
    tk.Label(frame, text="=== Eklenen Tarifler ===", font=("Arial", 16)).pack(pady=10)

    if kullanici_adi in kullanici_tarifleri and kullanici_tarifleri[kullanici_adi]:
        for tarif in kullanici_tarifleri[kullanici_adi]:
            kategori = tarif["kategori"]
            tarif_adi = tarif["tarif_adi"]
            malzemeler = tarif["malzemeler"]
            adimlar = tarif["adimlar"]
            
            # Kategori
            tk.Label(frame, text=f"Kategori: {kategori}", font=("Arial", 12, "bold")).pack(pady=5)
            
            # Tarif Adı
            tk.Label(frame, text=f"Tarif Adı: {tarif_adi}", font=("Arial", 14, "bold")).pack(pady=5)
            
            # Malzemeler
            tk.Label(frame, text="Malzemeler:", font=("Arial", 12, "bold")).pack(pady=5)
            malzemeler_listesi = malzemeler.split("\n")
            for malzeme in malzemeler_listesi:
                tk.Label(frame, text=f"• {malzeme}", font=("Arial", 10)).pack(pady=2)
            
            # Adımlar
            tk.Label(frame, text="Adımlar:", font=("Arial", 12, "bold")).pack(pady=5)
            adimlar_listesi = adimlar.split("\n")
            for adim in adimlar_listesi:
                tk.Label(frame, text=f"• {adim}", font=("Arial", 10)).pack(pady=2)
                
            # Menüye dönme butonu
            tk.Button(frame, text="Menüye Dön", command=lambda: kategori_secimi(frame), width=20, height=2, bg="#FF6F61", fg="#FFFFFF", font=("Arial", 12)).pack(pady=10)
    else:
        tk.Label(frame, text="Henüz tarif eklenmedi.", font=("Arial", 12)).pack(pady=20)
        # Menüye dönme butonu
        tk.Button(frame, text="Menüye Dön", command=lambda: kategori_secimi(frame), width=20, height=2, bg="#FF6F61", fg="#FFFFFF", font=("Arial", 12)).pack(pady=10)

 
# Ekranı temizleme fonksiyonu
def temizle_ekran(frame):
    for widget in frame.winfo_children():
        widget.destroy()

def resim_yukle_ve_goster(frame, resim_adı):
    try:
        # Resmi yükle
        image = Image.open(resim_adı)
        image = image.resize((300, 200), Image.Resampling.LANCZOS)  # Boyutlandırma (isteğe bağlı)

        # Resmi Tkinter ile uyumlu hale getir
        photo = ImageTk.PhotoImage(image)

        # Resmi göster
        resim_label = tk.Label(frame, image=photo, justify="left", bg="#FFE4E1")
        resim_label.pack(pady=15)

        # Resim referansını sakla, aksi takdirde resim kaybolabilir
        resim_label.image = photo  # image özelliğine resim referansını sakla
    except Exception as e:
        print(f"Resim yüklenemedi: {e}")

# Ortak tasarımı temizleme fonksiyonu
def temizle_ekran(frame):
    for widget in frame.winfo_children():
        widget.destroy()

def tarif_detayini_goster(frame, kategori, index):
    temizle_ekran(frame)

    # Tarif verisini güvenli bir şekilde al
    if 0 < index <= len(tarifler[kategori]):
        tarif = tarifler[kategori][index - 1]  # Kullanıcının girdiği index 1'den başlıyor
    else:
        raise ValueError("Geçersiz tarif indeksi. Lütfen doğru bir değer girin.")

    # Ana çerçeve
    content = tk.Frame(frame, bg="#f0f0f0")  # Daha açık gri arka plan
    content.pack(fill="both", expand=True, padx=20, pady=20)

    # Başlık
    tk.Label(content, text=f"--- {tarif['isim']} Tarif Detayları ---", 
             font=("Arial", 18, "bold"), fg="#FF6347", bg="#f0f0f0").pack(pady=15)

    # Canvas ve Scrollbar çerçevesi
    canvas_frame = tk.Frame(content, bg="#f0f0f0")
    canvas_frame.pack(fill="both", expand=True)

    # Canvas'ı oluştur ve hizala
    canvas = tk.Canvas(canvas_frame, bg="#f0f0f0")
    canvas.pack(side="left", fill="both", expand=True, padx=20, pady=20)

    # Scrollbar ekle
    scrollbar = tk.Scrollbar(canvas_frame, orient="vertical", command=canvas.yview)
    scrollbar.pack(side="right", fill="y")
    canvas.config(yscrollcommand=scrollbar.set)

    # Kaydırılabilir çerçeve
    scrollable_frame = tk.Frame(canvas, bg="#f0f0f0")
    scrollable_frame.bind(
        "<Configure>",
        lambda e: canvas.configure(scrollregion=canvas.bbox("all"))
    )
    canvas.create_window((0, 0), window=scrollable_frame, anchor="nw")

    # Tarif Resmi Gösterme
    tarif_resimleri = {
        "Waffle": "waffle.jpeg",
        "Cheescake": "cheescake.jpeg",
        "Profiterol": "profiterol.jpeg",
        "Fırında Sütlaç": "fırında sütlaç.jpeg",
        "Magnolia": "magnolia.jpeg",
        "Mercimek Çorbası": "mercimek.jpeg",
        "Tavuk Çorbası": "tavuk.jpeg",
        "Ezogelin Çorbası": "ezogelin.jpeg",
        "Domates Çorbası": "domates.jpeg",
        "Yoğurt Çorbası": "yoğurt.jpeg",
        "Fırında Tavuk Şiş": "şiş.jpeg",
        "Kadınbudu Köfte": "kadınbudu.jpeg",
        "Soğan Dolması": "soğan.jpeg",
        "Karnıyarık": "karnıyarık.jpeg",
        "Çökertme Kebabı": "kebap.jpeg",
        "Yeşil Smoothie": "yeşil.jpeg",
        "Ahududu-Çilek Smoothie": "ahududu.jpeg",
        "Muzlu Oreo Bisküvili Smoothie": "oreo.jpeg",
        "Armutlu Smoothie": "armut.jpeg"
    }

    if tarif['isim'] in tarif_resimleri:
        resim_yukle_ve_goster(scrollable_frame, tarif_resimleri[tarif['isim']])
    else:
        tk.Label(scrollable_frame, text="Bu tarif için bir resim bulunamadı.",
                 font=("Arial", 12), bg="#f0f0f0").pack(pady=5)

    # İçerik Çerçevesi (Malzemeler ve Adımlar)
    content_frame = tk.Frame(scrollable_frame, bg="#f0f0f0")
    content_frame.pack(pady=20, padx=30, fill="both", expand=True)

    # Malzemeler
    tk.Label(content_frame, text="Malzemeler:", font=("Arial", 14, "bold"), 
             fg="#FF6347", bg="#f0f0f0", justify="left").pack(pady=5)
    tk.Label(content_frame, text=tarif['malzemeler'], font=("Arial", 12), 
             justify="left", bg="#f0f0f0").pack(pady=5, anchor="w")

    # Adımlar
    tk.Label(content_frame, text="Adımlar:", font=("Arial", 14, "bold"), 
             fg="#FF6347", bg="#f0f0f0", justify="left").pack(pady=5)
    tk.Label(content_frame, text=tarif['adimlar'], font=("Arial", 12), 
             justify="left", bg="#f0f0f0").pack(pady=5, anchor="w")

    # Yorumlar Bölümü
    yorumlar_frame = tk.Frame(scrollable_frame, bg="#f0f0f0")
    yorumlar_frame.pack(pady=20, fill="both", expand=True)

    # Yorum Başlığı
    tk.Label(yorumlar_frame, text="Kullanıcı Yorumları:", font=("Arial", 14, "bold"), 
             fg="#FF6347", bg="#f0f0f0").pack(pady=5)

    # Yorumlar listesi
    yorumlar_listesi = []  # Yorumlar burada tutulacak

    # Yorum Ekleme Fonksiyonu
    def yorum_ekle():
        kullanici_adi = kullanici_adi_entry.get()
        yorum_metni = yorum_entry.get()
        if kullanici_adi and yorum_metni:
            yorumlar_listesi.append(f"{kullanici_adi}: {yorum_metni}")
            yorum_guncelle()

    # Yorumları güncelle
    def yorum_guncelle():
        # Yorumları temizle
        for widget in yorumlar_frame.winfo_children():
            widget.destroy()

        # Yorumları ekrana yerleştir
        tk.Label(yorumlar_frame, text="Kullanıcı Yorumları:", font=("Arial", 14, "bold"), 
                 fg="#FF6347", bg="#f0f0f0",justify="left").pack(pady=5)
        for yorum in yorumlar_listesi:
            tk.Label(yorumlar_frame, text=yorum, font=("Arial", 12), bg="#f0f0f0", anchor="w").pack(anchor="w")

    # Kullanıcı Adı ve Yorum Ekleme Alanı
    form_frame = tk.Frame(scrollable_frame, bg="#f0f0f0")
    form_frame.pack(pady=10, fill="both", expand=True)

    tk.Label(form_frame, text="Adınızı girin:", font=("Arial", 12), bg="#f0f0f0").pack()
    kullanici_adi_entry = tk.Entry(form_frame, font=("Arial", 12))
    kullanici_adi_entry.pack(pady=5)

    tk.Label(form_frame, text="Yorumunuzu girin:", font=("Arial", 12), bg="#f0f0f0").pack()
    yorum_entry = tk.Entry(form_frame, font=("Arial", 12))
    yorum_entry.pack(pady=5)
    

    # Yorum ekle butonu
    yorum_button = tk.Button(form_frame, text="Yorum Ekle", command=yorum_ekle, 
                             bg="#FF6F61", fg="#FFFFFF", font=("Arial", 12,))
    yorum_button.pack(pady=10)


    tk.Button(frame, text="Menüye Dön", command=lambda: kategori_secimi(frame), 
              width=20, height=2, bg="#6A4E77", fg="#FFFFFF", font=("Arial", 12)).pack(pady=10)

    yorum_guncelle()  # Başlangıçta mevcut yorumları ekranda göster

def tarif_detayi_goster_v2(frame, kategori):
    temizle_ekran(frame)

    tk.Label(frame, text=f"--- {kategori} Tarif Detayları ---", font=("Arial", 16, "bold"), fg="#FF6F61").pack(pady=20)

    # Eğer kategoriye ait tarif yoksa
    if not tarifler[kategori]:
        tk.Label(frame, text="Henüz tarif eklenmemiş.", font=("Arial", 12), fg="#333333").pack(pady=10)
        tk.Button(frame, text="Menüye Dön", command=lambda: kategori_secimi(frame), width=20, height=2, bg="#FF6F61", fg="#FFFFFF", font=("Arial", 12)).pack(pady=10)
        return

    # Tariflerin listesi
    tarif_frame = tk.Frame(frame, bg="#F9F9F9")
    tarif_frame.pack(pady=20)

    for i, tarif in enumerate(tarifler[kategori], start=1):
        tarif_row_frame = tk.Frame(tarif_frame, bg="#F9F9F9")
        tarif_row_frame.grid(row=i-1, column=0, padx=10, pady=10, sticky="w")

        # Tarif ismi
        tk.Label(tarif_row_frame, text=f"{i}. {tarif['isim']}", font=("Arial", 12, "bold"), bg="#F9F9F9").pack(side="left", padx=5)

        # Detayları göster butonu
        tk.Button(tarif_row_frame, text="Detayları Göster", 
                  command=lambda i=i: tarif_detayini_goster(frame, kategori, i),
                  width=20, height=2, bg="#6A4E77", fg="#FFFFFF", font=("Arial", 12, "bold"), relief="solid", bd=2).pack(side="left", padx=5)

    # Ana menüye dönme butonu
    tk.Button(frame, text="Menüye Dön", command=lambda: kategori_secimi(frame), width=20, height=2, bg="#6A4E77", fg="#FFFFFF", font=("Arial", 12)).pack(pady=10)

# Kategorilere yönlendirme
root = tk.Tk()
root.title("Yemek Tarifi Uygulaması")
root.geometry("400x600")

# İlk ekran olarak ana menüyü açma
ana_menu(root)
root.mainloop()
