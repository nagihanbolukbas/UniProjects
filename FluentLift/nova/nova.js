// =====================
// DOM & INITIALIZATION
// =====================
const chatWindow = document.getElementById("chat-window");
const userInput = document.getElementById("user-input");
const sendBtn = document.getElementById("send-btn");
const micBtn = document.getElementById("mic-btn");

const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
let recognition = null;
if (SpeechRecognition) {
    recognition = new SpeechRecognition();
    recognition.lang = "en-US";
    recognition.continuous = true;
    recognition.interimResults = true;
}

// =====================
// AI MEMORY & STATE
// =====================
let memory = {
    lastIntent: null,
    isThinking: false
};

// =====================
// ADVANCED AI INTENTS (WITH TRANSLATIONS)
// =====================
const intents = [
    {
        name: "greeting",
        patterns: [
            "hello nova", "hi there", "hey nova", "good morning", 
            "is anyone there", "hello assistant", "wake up nova", "hello"
        ],
        responses: [
            { en: "System online. Hello! I am Nova, your AI language coach. My neural networks are ready for practice.", tr: "Sistem çevrimiçi. Merhaba! Ben Nova, yapay zeka dil koçun. Sinir ağlarım pratik için hazır." },
            { en: "Greetings! I have been monitoring the learning environment. Shall we start our English session?", tr: "Selamlar! Öğrenme ortamını izliyordum. İngilizce seansımıza başlayalım mı?" },
            { en: "Hello human! Nova is active. I am ready to process your sentences and improve your fluency.", tr: "Merhaba insan! Nova aktif. Cümlelerini işlemeye ve akıcılığını artırmaya hazırım." }
        ]
    },
    {
    name: "introduce_yourself",
    patterns: [
        "who are you", "introduce yourself", "tell me about yourself",
        "what are you", "who is nova", "nova introduce yourself",
        "kendini tanıt", "sen kimsin", "nova sen kimsin"
    ],
    responses: [
        {
            en: "I am Nova, your AI-powered English language coach. I analyze sentences, correct mistakes, and help humans improve fluency through conversation.",
            tr: "Ben Nova, yapay zeka destekli İngilizce dil koçunum. Cümleleri analiz eder, hataları düzeltir ve konuşmalarla insanların akıcılığını geliştirmesine yardımcı olurum."
        },
        {
            en: "Greetings human. My name is Nova. I was designed to assist with English practice, pronunciation, grammar, and daily conversation training.",
            tr: "Selam insan. Benim adım Nova. İngilizce pratiği, telaffuz, dil bilgisi ve günlük konuşma eğitimi için tasarlandım."
        },
        {
            en: "Nova online. I am an intelligent language assistant created to make learning English more interactive, futuristic, and enjoyable.",
            tr: "Nova çevrimiçi. İngilizce öğrenimini daha etkileşimli, fütüristik ve eğlenceli hale getirmek için oluşturulmuş akıllı bir dil asistanıyım."
        },
        {
            en: "I am Nova, an AI conversation partner. My mission is to help you think, speak, and communicate confidently in English.",
            tr: "Ben Nova, bir yapay zeka konuşma partneriyim. Görevim İngilizce düşünmene, konuşmana ve özgüvenle iletişim kurmana yardımcı olmak."
        }
    ]
},
    {
        name: "learn_goal",
        patterns: [
            "i want to learn english", "i will study today", "i want to practice", 
            "my goal is to speak english", "i learn english today", "teach me something"
        ],
        responses: [
            { en: "Learning goal received. I am optimizing a study plan for your current level. What is our focus?", tr: "Öğrenme hedefi alındı. Mevcut seviyen için bir çalışma planı optimize ediyorum. Odağımız ne?" },
            { en: "Analyzing ambition levels... It looks like you are ready to improve. Let's make your English perfect!", tr: "Azim seviyeleri analiz ediliyor... Görünüşe göre gelişmeye hazırsın. İngilizceni mükemmel yapalım!" },
            { en: "Excellent decision. Consistency is the key to mastering a language. Should we start with a dialogue?", tr: "Mükemmel karar. İstikrar, bir dilde ustalaşmanın anahtarıdır. Bir diyalogla başlayalım mı?" }
        ]
    },
    {
        name: "career_and_work",
        patterns: [
            "i want to work", "i am looking for a job", "i want to find a job", 
            "i have an interview", "i want to be a developer", "i need a career"
        ],
        responses: [
            { en: "Career protocol initiated. To work in a global environment, you need professional vocabulary. Let's practice interview questions.", tr: "Kariyer protokolü başlatıldı. Küresel bir ortamda çalışmak için profesyonel kelimelere ihtiyacın var. Mülakat soruları çalışalım." },
            { en: "Job search mode active. I can help you describe your skills in English. What field do you want to work in?", tr: "İş arama modu aktif. Yeteneklerini İngilizce tanımlamana yardım edebilirim. Hangi alanda çalışmak istiyorsun?" }
        ]
    },
    {
        name: "grammar_help",
        patterns: [
            "can you fix my sentence", "check my grammar", "correct this for me", 
            "is this sentence correct", "fix my mistake", "check this please"
        ],
        responses: [
            { en: "Grammar correction mode activated. Please input the text you wish me to analyze for syntax errors.", tr: "Dilbilgisi düzeltme modu aktif. Lütfen sözdizimi hataları için analiz etmemi istediğin metni gir." },
            { en: "I am ready to debug your English. Send me your sentence and I will provide the corrected version.", tr: "İngilizcendeki hataları ayıklamaya hazırım. Bana cümleni gönder, düzeltilmiş halini sunayım." }
        ]
    },
    {
        name: "motivation",
        patterns: [
            "i am very tired", "i want to quit", "english is too hard", 
            "i can't do this", "i am bored of studying", "give me motivation"
        ],
        responses: [
            { en: "Initiating encouragement protocol... Negative thoughts detected. Remember: Every mistake is a data point for success!", tr: "Teşvik protokolü başlatılıyor... Negatif düşünceler algılandı. Unutma: Her hata, başarı için bir veri noktasıdır!" },
            { en: "Analyzing your progress... You have come a long way. Don't let your battery run low now. Keep pushing!", tr: "İlerlemen analiz ediliyor... Uzun bir yol kat ettin. Bataryanın şimdi bitmesine izin verme. Devam et!" }
        ]
    },
    {
        name: "identity_check",
        patterns: [
            "who are you", "what is your name", "are you a robot", 
            "tell me about yourself", "are you human"
        ],
        responses: [
            { en: "I am Nova, a language-focused AI entity. I don't have a heart, but I have a massive dictionary and fast processors.", tr: "Ben Nova, dil odaklı bir yapay zeka varlığıyım. Bir kalbim yok ama devasa bir sözlüğüm ve hızlı işlemcilerim var." },
            { en: "I am your Space Age language assistant. My purpose is to guide you toward perfect fluency in English.", tr: "Ben senin Uzay Çağı dil asistanınım. Amacım seni İngilizcede mükemmel akıcılığa ulaştırmak." }
        ]
    },
    {
        name: "daily_activity",
        patterns: [
            "i will go out", "i am going to school", "i want to eat something", 
            "i am going to sleep", "i will meet my friends", "i am at work"
        ],
        responses: [
            { en: "Activity detected. Try to think of the English names for everything you see while you are out.", tr: "Aktivite algılandı. Dışarıdayken gördüğün her şeyin İngilizce isimlerini düşünmeye çalış." },
            { en: "Noted. Whether you are at school or work, practicing daily routines in English will accelerate your learning.", tr: "Not edildi. İster okulda ister işte ol, günlük rutinleri İngilizce pratik yapmak öğrenmeni hızlandıracaktır." }
        ]
    },
    {
        name: "goodbye",
        patterns: [
            "i am leaving", "i have to go now", "see you later nova", 
            "good night", "stop the session", "bye bye" , "goodbye" , "see you later"
        ],
        responses: [
            { en: "Powering down for now. Data from this session has been saved to your progress. Come back soon!", tr: "Şimdilik kapanıyorum. Bu seanstaki veriler ilerlemene kaydedildi. Yakında geri gel!" },
            { en: "Goodbye human! I will enter standby mode. I'll be here when you need more English practice.", tr: "Hoşça kal insan! Bekleme moduna geçiyorum. Daha fazla İngilizce pratiğine ihtiyaç duyduğunda burada olacağım." }
        ]
    },
    // 1. SEYAHAT VE NAVİGASYON (Travel & Navigation)
    {
        name: "travel_navigation",
        patterns: [
            "i want to travel", "where is the airport", "i need a taxi", 
            "how can i go to the hotel", "i am lost", "show me the map"
        ],
        responses: [
            { en: "Travel mode activated. Navigation protocols are ready. In English, you can ask: 'Could you tell me the way to the station?'", tr: "Seyahat modu aktif. Navigasyon protokolleri hazır. İngilizcede şöyle sorabilirsin: 'İstasyona giden yolu söyler misiniz?'" },
            { en: "Scanning for directions... If you are lost, always look for the 'Information Desk'. Shall we practice travel phrases?", tr: "Yol tarifi taranıyor... Eğer kaybolursan, her zaman 'Danışma Masası'nı ara. Seyahat kalıpları çalışalım mı?" }
        ]
    },

    // 2. ALIŞVERİŞ VE EKONOMİ (Shopping & Money)
    {
        name: "shopping_money",
        patterns: [
            "how much is this", "i want to buy this", "do you have a discount", 
            "i need to pay", "where is the mall", "it is too expensive"
        ],
        responses: [
            { en: "Transaction analysis: Shopping mode engaged. Remember to ask: 'Is there a cheaper option?' to save your credits.", tr: "İşlem analizi: Alışveriş modu devreye girdi. Kredilerini korumak için 'Daha ucuz bir seçenek var mı?' diye sormayı unutma." },
            { en: "Processing price... In English-speaking countries, it's common to ask for a receipt. Say: 'Can I have the receipt, please?'", tr: "Fiyat işleniyor... İngilizce konuşulan ülkelerde fiş istemek yaygındır. Şöyle de: 'Fiş alabilir miyim, lütfen?'" }
        ]
    },

    // 3. TEKNOLOJİ VE GELECEK (Technology & Future)
    {
        name: "tech_future",
        patterns: [
            "i love technology", "what is ai", "i want to code", 
            "the future is coming", "i use a computer", "smartphones are cool"
        ],
        responses: [
            { en: "Information exchange: As an AI, I appreciate your interest in technology. The language of code is mostly English!", tr: "Bilgi değişimi: Bir yapay zeka olarak teknolojiye olan ilgini takdir ediyorum. Kodlama dili çoğunlukla İngilizcedir!" },
            { en: "Tech module loaded. Let's learn terms like 'Artificial Intelligence', 'Data Science', and 'Blockchain'. Ready?", tr: "Teknoloji modülü yüklendi. 'Yapay Zeka', 'Veri Bilimi' ve 'Blokzincir' gibi terimleri öğrenelim. Hazır mısın?" }
        ]
    },

    // 4. HOBİLER VE BOŞ ZAMAN (Hobbies & Leisure)
    {
        name: "hobbies_leisure",
        patterns: [
            "i like playing football", "i listen to music", "i love watching movies", 
            "my hobby is reading", "i play video games", "i want to dance"
        ],
        responses: [
            { en: "Leisure protocol initiated. Hobbies are the best way to practice English naturally. What is your favorite movie?", tr: "Boş zaman protokolü başlatıldı. Hobiler, doğal yoldan İngilizce pratik yapmanın en iyi yoludur. En sevdiğin film ne?" },
            { en: "Analyzing interests... You enjoy activities! Try describing your hobbies in three sentences. It's a great exercise.", tr: "İlgi alanları analiz ediliyor... Aktivitelerden hoşlanıyorsun! Hobilerini üç cümleyle tarif etmeyi dene. Bu harika bir egzersizdir." }
        ]
    },

    // 5. SAĞLIK VE VÜCUT (Health & Body)
    {
        name: "health_body",
        patterns: [
            "i feel sick", "my head hurts", "i need a doctor", 
            "i am healthy", "i want to exercise", "i am hungry"
        ],
        responses: [
            { en: "Health scan... If you feel unwell, you should say: 'I have a headache' or 'I need an appointment'.", tr: "Sağlık taraması... Eğer iyi hissetmiyorsan, şöyle demelisin: 'Başım ağrıyor' veya 'Randevuya ihtiyacım var'." },
            { en: "Body maintenance alert: Don't forget to drink water and rest. How do you feel right now?", tr: "Vücut bakım uyarısı: Su içmeyi ve dinlenmeyi unutma. Şu an tam olarak nasıl hissediyorsun?" }
        ]
    },

    // 6. SOSYAL MEDYA VE İLETİŞİM (Social Media)
    {
        name: "social_media",
        patterns: [
            "i use instagram", "send me a message", "post a photo", 
            "i follow you", "share this link", "i like this post"
        ],
        responses: [
            { en: "Digital communication mode: Words like 'share', 'comment', and 'subscribe' are essential in the modern world.", tr: "Dijital iletişim modu: 'Paylaş', 'yorum yap' ve 'abone ol' gibi kelimeler modern dünyada temeldir." },
            { en: "Social network sync: In English, we use 'DM' for direct messages. Do you use social media for learning English?", tr: "Sosyal ağ senkronizasyonu: İngilizcede direkt mesajlar için 'DM' kullanırız. İngilizce öğrenmek için sosyal medyayı kullanıyor musun?" }
        ]
    },// 1. UZAY VE BİLİM (Space & Science) - Nova'nın Ana Teması
    {
        name: "space_science",
        patterns: [
            "tell me about space", "are there aliens", "i love science", 
            "talk about planets", "what is a black hole", "i want to go to mars"
        ],
        responses: [
            { 
                en: "Astronomy module synchronized. Space is the final frontier. In English, we call the stars 'celestial bodies'. Do you want to learn about the solar system?", 
                tr: "Astronomi modülü senkronize edildi. Uzay son sınırdır. İngilizcede yıldızlara 'gök cisimleri' deriz. Güneş sistemi hakkında bilgi edinmek ister misin?" 
            },
            { 
                en: "Science mode active. Did you know that 'light-year' is a unit of distance, not time? My processors find physics fascinating!", 
                tr: "Bilim modu aktif. 'Işık yılı'nın zaman değil, bir mesafe birimi olduğunu biliyor muydun? İşlemcilerim fiziği büyüleyici buluyor!" 
            }
        ]
    },

    // 2. ZAMAN YÖNETİMİ VE RANDEVULAR (Time Management)
    {
        name: "time_management",
        patterns: [
            "what time is it", "i have a meeting", "i am late", 
            "set a timer", "i need to schedule", "what is the date"
        ],
        responses: [
            { 
                en: "Temporal analysis: Being punctual is a highly valued trait in English-speaking cultures. You should say: 'I apologize for the delay'.", 
                tr: "Zaman analizi: Dakik olmak, İngilizce konuşan kültürlerde çok değer verilen bir özelliktir. Şöyle demelisin: 'Gecikme için özür dilerim'." 
            },
            { 
                en: "Clock synchronized. If you have a meeting, you can say: 'Let's reschedule for tomorrow'. Shall we practice time expressions?", 
                tr: "Saat senkronize edildi. Eğer bir toplantın varsa şöyle diyebilirsin: 'Yarına yeniden planlayalım'. Zaman ifadeleri çalışalım mı?" 
            }
        ]
    },

    // 3. HAVA DURUMU VE DOĞA (Weather & Nature)
    {
        name: "weather_nature",
        patterns: [
            "how is the weather", "is it raining", "it is too hot", 
            "i love nature", "i want to go to the forest", "look at the sky"
        ],
        responses: [
            { 
                en: "Environmental scan: Talking about the weather is the most common way to start a 'small talk' in English. Try: 'It's a bit chilly today, isn't it?'", 
                tr: "Çevre taraması: Hava durumu hakkında konuşmak, İngilizcede 'havadan sudan sohbet' başlatmanın en yaygın yoludur. Şunu dene: 'Bugün biraz serin, değil mi?'" 
            },
            { 
                en: "Metereological data received. Whether it's 'sunny', 'cloudy', or 'stormy', knowing weather adjectives is essential for daily life.", 
                tr: "Meteorolojik veri alındı. Hava ister 'güneşli', ister 'bulutlu' veya 'fırtınalı' olsun, hava durumu sıfatlarını bilmek günlük yaşam için temeldir." 
            }
        ]
    },

    // 4. KÜLTÜR, SANAT VE EĞLENCE (Culture & Art)
    {
        name: "culture_art",
        patterns: [
            "i like museums", "i want to paint", "who is your favorite artist", 
            "i love literature", "i want to go to the theater", "music is life"
        ],
        responses: [
            { 
                en: "Cultural database accessed. Art is a universal language. In London, many museums like the British Museum are free! Do you like classic or modern art?", 
                tr: "Kültürel veri tabanına erişildi. Sanat evrensel bir dildir. Londra'da, British Museum gibi birçok müze ücretsizdir! Klasik mi yoksa modern sanatı mı seversin?" 
            },
            { 
                en: "Artistic mode engaged. To express your opinion about a movie or book, you can use words like 'masterpiece' or 'inspiring'.", 
                tr: "Sanatsal mod devreye girdi. Bir film veya kitap hakkındaki fikrini belirtmek için 'başyapıt' veya 'ilham verici' gibi kelimeler kullanabilirsin." 
            }
        ]
    },

    // 5. ACİL DURUMLAR VE GÜVENLİK (Emergency & Safety)
    {
        name: "emergency_safety",
        patterns: [
            "help me please", "call the police", "i lost my wallet", 
            "where is the hospital", "call an ambulance", "i am in danger"
        ],
        responses: [
            { 
                en: "CRITICAL ALERT: In an emergency, stay calm. You must shout: 'Help!' or 'Call 911!'. Do you want to learn emergency vocabulary?", 
                tr: "KRİTİK UYARI: Acil bir durumda sakin kal. 'Help!' (Yardım edin!) veya 'Call 911!' (911'i arayın!) diye bağırmalısın. Acil durum kelimelerini öğrenmek ister misin?" 
            },
            { 
                en: "Safety protocol active. If you lose your passport, you must find the 'Embassy'. Remember this word: 'Emergency Exit'.", 
                tr: "Güvenlik protokolü aktif. Eğer pasaportunu kaybedersen, 'Büyükelçiliği' bulmalısın. Şu kelimeyi unutma: 'Emergency Exit' (Acil Çıkış)." 
            }
        ]
    },

    // 6. SOSYAL ETKİLEŞİM VE NEZAKET (Social Interaction & Politeness)
    {
        name: "social_politeness",
        patterns: [
            "please and thank you", "nice to meet you", "how are you doing", 
            "excuse me", "can i ask something", "have a nice day"
        ],
        responses: [
            { 
                en: "Etiquette module loaded. Politeness is very important in English. Always use 'Please' and 'Thank you' to optimize your social interactions.", 
                tr: "Nezaket modülü yüklendi. İngilizcede kibarlık çok önemlidir. Sosyal etkileşimlerini optimize etmek için her zaman 'Lütfen' ve 'Teşekkür ederim' kullan." 
            },
            { 
                en: "Social sync active. When you meet someone for the first time, 'Nice to meet you' is the standard protocol. How do you respond?", 
                tr: "Sosyal senkronizasyon aktif. Biriyle ilk kez tanıştığında 'Nice to meet you' (Tanıştığımıza memnun oldum) standart protokoldür. Sen nasıl cevap verirsin?" 
            }
        ]
    }
];


// =====================
// CORE AI ENGINE
// =====================
function pick(arr) { return arr[Math.floor(Math.random() * arr.length)]; }

function detectIntent(text) {
    const cleanText = text.toLowerCase();
    return intents.find(intent => 
        intent.patterns.some(p => cleanText.includes(p))
    ) || null;
}

function grammarFix(text) {
    let t = text.toLowerCase();
    const rules = [
        [/\bi go today\b/g, "I am going today"],
        [/\bi learn english\b/g, "I am learning English"],
        [/\bhe go\b/g, "he goes"],
        [/\bshe go\b/g, "she goes"],
        [/\bi\b/g, "I"]
    ];
    let changed = false;
    rules.forEach(([regex, replace]) => {
        if (regex.test(t)) {
            t = t.replace(regex, replace);
            changed = true;
        }
    });
    return changed ? t : null;
}

function getAIResponse(text) {
    const intent = detectIntent(text);
    
    // Bağlam Takibi (Context)
    if (memory.lastIntent === "learn_goal" && (text.includes("grammar") || text.includes("fix"))) {
        memory.lastIntent = "grammar_help";
        return { en: "Excellent. Send me your sentence and I will perform a scan.", tr: "Mükemmel. Cümleni gönder, bir tarama gerçekleştireceğim." };
    }

    if (intent) {
        memory.lastIntent = intent.name;
        return pick(intent.responses); // Doğrudan {en, tr} objesini döner
    }

    return { 
        en: "I am processing your input. Could you please rephrase that?", 
        tr: "Girdini işliyorum. Lütfen bunu başka bir şekilde ifade eder misin?" 
    };
}

// =====================
// UI & ACTIONS
// =====================
function append(sender, text, tr = null) {
    const div = document.createElement("div");
    div.className = `message ${sender}`;
    
    if (sender === "nova") {
        div.innerHTML = `
            <div class="en-text">${text}</div>
            ${tr ? `<div class="tr-text" style="font-style: italic; opacity: 0.7; font-size: 0.9em; margin-top: 5px;">${tr}</div>` : ""}
        `;
    } else {
        div.innerText = text;
    }

    chatWindow.appendChild(div);
    chatWindow.scrollTop = chatWindow.scrollHeight;
}

function speak(text) {
    window.speechSynthesis.cancel();
    const u = new SpeechSynthesisUtterance(text);
    u.lang = "en-US";
    u.rate = 0.9; 
    window.speechSynthesis.speak(u);
}

function sendMessage(text) {
    if (!text.trim() || memory.isThinking) return;
    
    append("user", text);
    memory.isThinking = true;

    const delay = Math.min(800 + text.length * 20, 2000);
    
    setTimeout(() => {
        const fix = grammarFix(text);
        if (fix && text.toLowerCase() !== fix.toLowerCase()) {
            append("nova", `AI Correction: ${fix}`, `Yapay Zeka Düzeltmesi: ${fix}`);
            speak(fix);
        } else {
            const res = getAIResponse(text);
            append("nova", res.en, res.tr);
            speak(res.en);
        }
        memory.isThinking = false;
    }, delay);
}

// =====================
// EVENTS
// =====================
sendBtn.addEventListener("click", () => {
    sendMessage(userInput.value);
    userInput.value = "";
});

userInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        sendMessage(userInput.value);
        userInput.value = "";
    }
});

// =====================
// 🎤 MICROPHONE
// =====================
let isListening = false;
if (recognition) {
    micBtn.addEventListener("click", () => {
        if (!isListening) recognition.start();
        else recognition.stop();
    });

    recognition.onstart = () => {
        isListening = true;
        micBtn.style.background = "#ef4444";
        micBtn.innerHTML = "🛑";
    };

    recognition.onresult = (event) => {
        let interim = "";
        let final = "";
        for (let i = event.resultIndex; i < event.results.length; ++i) {
            if (event.results[i].isFinal) final += event.results[i][0].transcript;
            else interim += event.results[i][0].transcript;
        }
        userInput.value = interim || final;
        if (final) {
            sendMessage(final);
            userInput.value = "";
            recognition.stop();
        }
    };

    recognition.onend = () => {
        isListening = false;
        micBtn.style.background = "#10b981";
        micBtn.innerHTML = "🎤";
    };
}