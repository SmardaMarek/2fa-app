<?php

namespace Database\Seeders;

use App\Enums\ModuleSlug;
use App\Models\Module;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $this->seedTotpQuestions();
        $this->seedSmsQuestions();
        $this->seedBiometricsQuestions();
        $this->seedFidoQuestions();
    }

    private function seedTotpQuestions(): void
    {
        $totpModule = Module::where('slug', ModuleSlug::TOTP)->first();

        if (! $totpModule) {
            return;
        }

        $questions = [
            [
                'text' => 'Co znamená zkratka TOTP?',
                'options' => [
                    'a' => 'Token-Oriented Time Protocol',
                    'b' => 'Time-Based One-Time Password',
                    'c' => 'Temporary One-Time Passcode',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Proč server v simulaci přijal TOTP kód i na podvržené phishingové stránce?',
                'options' => [
                    'a' => 'Protože byl kód zachycen dříve, než vypršela jeho platnost a útočník prolomil šifrování databáze.',
                    'b' => 'Protokol TOTP neověřuje, odkud kód přišel — chybí mu Origin Binding. Kontroluje jen matematickou shodu.',
                    'c' => 'Protože asymetrický klíč prohlížeče nebyl správně zvalidován.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Jak může backend zabránit Replay útoku (znovupoužití stejného kódu)?',
                'options' => [
                    'a' => 'Po úspěšném přihlášení uloží kód do cache (např. Redis) a během jeho časového okna ho znovu neakceptuje.',
                    'b' => 'Aplikace v mobilu zablokuje generování dalšího kódu, dokud server nepotvrdí přihlášení přes WebSockets.',
                    'c' => 'Replay útoku u TOTP zabránit nelze — řeší to až FIDO2.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Jak se řeší problém, když hodiny klienta a serveru nejdou přesně (Time Drift)?',
                'options' => [
                    'a' => 'Algoritmus ignoruje čas a řídí se pouze počítadlem (counter).',
                    'b' => 'Klient si před každým generováním stahuje přesný čas z NTP serveru.',
                    'c' => 'Backend akceptuje nejen aktuální časový krok (30s), ale i sousední kroky (T-1 a T+1).',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Bude vám Authenticator generovat platné kódy, i když nemáte internet?',
                'options' => [
                    'a' => 'Ne, aplikace se musí spojit se serverem pro inicializaci výpočtu.',
                    'b' => 'Ano, výpočet $TOTP = Truncate(HMAC-SHA(K, T))$ probíhá zcela lokálně pouze z uloženého tajemství a lokálního času.',
                    'c' => 'Ano, ale pouze posledních 10 kódů uložených v off-line paměti.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Do jaké kategorie MFA faktorů patří mobilní aplikace s TOTP kódy?',
                'options' => [
                    'a' => 'Inherence (něco, co jsem — biometrie)',
                    'b' => 'Znalost (něco, co vím — hesla)',
                    'c' => 'Vlastnictví (něco, co mám — zařízení s klíčem)',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Proč je nebezpečné nechat QR kód pro nastavení TOTP na očích?',
                'options' => [
                    'a' => 'Obsahuje tajný klíč (Shared Secret) v čitelné podobě — kdo ho ofotí, vyrobí si klon vašeho autentizátoru.',
                    'b' => 'QR kódy mohou přenášet škodlivý payload (malware) přímo do jádra mobilního operačního systému.',
                    'c' => 'Standard RFC 6238 zakazuje jejich použití pro systémy úrovně AAL2.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Jaká hašovací funkce se nejčastěji používá pro výpočet TOTP kódu?',
                'options' => [
                    'a' => 'MD5',
                    'b' => 'HMAC-SHA-1 (případně novější SHA-256 / SHA-512)',
                    'c' => 'Bcrypt s dynamickým saltováním',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'V čem je TOTP bezpečnější než SMS kódy?',
                'options' => [
                    'a' => 'TOTP nezávisí na mobilním operátorovi — není zranitelný vůči SIM Swappingu ani zneužití SS7.',
                    'b' => 'TOTP automaticky implementuje asymetrickou kryptografii proti phishingu.',
                    'c' => 'TOTP zabraňuje AitM (Phishingu) pomocí nativního Origin Bindingu.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'V simulaci jste zapnuli cache jako mitigaci. Proti kterému útoku ale NEPOMÁHÁ?',
                'options' => [
                    'a' => 'Replay Attack — opětovné použití stejného kódu.',
                    'b' => 'AitM — útočník zachytí kód na phishingové stránce a okamžitě ho použije na legitimní službě.',
                    'c' => 'Time Drift — nesynchronizované hodiny mezi klientem a serverem.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Proč vám password manažer pomáhá proti TOTP phishingu?',
                'options' => [
                    'a' => 'Šifruje TOTP kód před odesláním na server.',
                    'b' => 'Odmítne automaticky vyplnit přihlašovací údaje na neznámé doméně — funguje jako de facto „lidský Origin Binding".',
                    'c' => 'Generuje náhodný TOTP seed pro každou relaci, čímž brání replaye.',
                ],
                'correct_option' => 'b',
            ],
        ];

        // Smažeme staré otázky, abychom při re-seedu neměli duplikáty
        Question::where('module_id', $totpModule->id)->delete();

        foreach ($questions as $q) {
            Question::create([
                'module_id' => $totpModule->id,
                'text' => $q['text'],
                'options' => $q['options'],
                'correct_option' => $q['correct_option'],
            ]);
        }
    }

    private function seedSmsQuestions(): void
    {
        $smsModule = Module::where('slug', ModuleSlug::SMS)->first();

        if (! $smsModule) {
            return;
        }

        $questions = [
            [
                'text' => 'Co se technicky děje u operátora, když útočník úspěšně provede SIM Swap?',
                'options' => [
                    'a' => 'Útočník nahraje malware na vysílač (BTS) a zkopíruje šifrovací klíče uživatele.',
                    'b' => 'Přepíše se záznam v HLR/HSS — útočník změní vazbu mezi veřejným číslem (MSISDN) a identifikátorem (IMSI) své vlastní SIM karty.',
                    'c' => 'Útočník prolomí PIN kód SIM karty pomocí brute-force útoku přes síť.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Proč telefon oběti po SIM Swapu okamžitě ztratí signál?',
                'options' => [
                    'a' => 'Výpadek SS7 sítě způsobený masivním routingem.',
                    'b' => 'Útočník musí použít lokální GSM rušičku.',
                    'c' => 'Původní SIM karta je sítí deautorizována — její klíč (Ki) v AuC už není spárován s daným číslem.',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Jak standard NIST SP 800-63B hodnotí SMS jako druhý faktor?',
                'options' => [
                    'a' => 'Jako plně doporučené pro úroveň AAL3, pokud je použit 6místný kód.',
                    'b' => 'Jako "Restricted" pro úroveň AAL2 a zcela je vylučuje pro nejvyšší úroveň AAL3.',
                    'c' => 'NIST zcela zakazuje využití SMS i pro nejnižší úroveň AAL1 z důvodu absence E2E šifrování.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Proč je doručování SMS (např. v roamingu) považováno za zranitelné?',
                'options' => [
                    'a' => 'Spoléhá na protokoly SS7/Diameter, které nemají end-to-end šifrování a fungují na principu implicitní důvěry mezi uzly.',
                    'b' => 'Protože SMS zprávy delší než 160 znaků se nešifrují vůbec.',
                    'c' => 'Protože banky odesílají kódy přes nezabezpečený HTTP protokol.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Co je Origin Binding a má ho SMS OTP?',
                'options' => [
                    'a' => 'Kryptografické svázání autentizátoru s doménou. SMS OTP ho má, pokud zpráva obsahuje odkaz.',
                    'b' => 'Kryptografické svázání tokenu s TLS relací dané domény. SMS OTP ho absolutně nemá.',
                    'c' => 'Funkce sítě, která váže SMS kód k GPS poloze uživatele. V 5G sítích to funguje.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Může banka zabránit kompromitaci účtu při SIM Swapu, pokud používá jen SMS?',
                'options' => [
                    'a' => 'Ne — banka odesílá zprávu na logické číslo (MSISDN) a nemá jak ověřit, ke kterému fyzickému čipu (IMSI) ho operátor přiřadil.',
                    'b' => 'Ano, banka může vyžadovat, aby operátor odeslal zpět otisk prstu čipu.',
                    'c' => 'Ano, zkrácením platnosti SMS kódu na méně než 10 sekund.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Jaký typ útoku jste provedli v chatovací simulaci SIM Swapu?',
                'options' => [
                    'a' => 'Prolomení šifrování SIM karty brute-force útokem na symetrický klíč Ki.',
                    'b' => 'Zmanipulování operátora zákaznické linky pomocí Social Engineeringu — využití ukradeného jména, adresy a rodného čísla.',
                    'c' => 'Odposlech SMS přes Wi-Fi síť oběti pomocí síťového analyzátoru.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Která technologie nejlépe chrání proti AitM (phishing) útokům, které obchází SMS i TOTP?',
                'options' => [
                    'a' => 'Aplikace typu Microsoft/Google Authenticator.',
                    'b' => 'Zasílání kódů na e-mail místo na mobil.',
                    'c' => 'Rodina protokolů FIDO2 / WebAuthn (hardwarové klíče a Passkeys).',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Jak se můžete jako uživatel bránit proti SIM Swappingu?',
                'options' => [
                    'a' => 'Používáním delšího PIN kódu na SIM kartě (4místný → 8místný).',
                    'b' => 'Nastavením autorizačního PINu u operátora pro veškeré změny na účtu a přechodem na eSIM, kterou nelze fyzicky vyměnit na pobočce.',
                    'c' => 'Vypnutím příjmu SMS na dobu, kdy aktivně nepoužívá telefon.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Co může vývojář udělat pro ochranu uživatelů, kteří stále používají SMS?',
                'options' => [
                    'a' => 'Zkrátit platnost SMS kódu (TTL < 60s) a implementovat detekci SIM swapu přes Number Verify API operátorů.',
                    'b' => 'Přidat CAPTCHA před odeslání každého SMS kódu.',
                    'c' => 'Šifrovat obsah SMS zprávy end-to-end pomocí PGP klíče uživatele.',
                ],
                'correct_option' => 'a',
            ],
        ];

        Question::where('module_id', $smsModule->id)->delete();

        foreach ($questions as $q) {
            Question::create([
                'module_id' => $smsModule->id,
                'text' => $q['text'],
                'options' => $q['options'],
                'correct_option' => $q['correct_option'],
            ]);
        }
    }

    private function seedBiometricsQuestions(): void
    {
        $biometricsModule = Module::where('slug', ModuleSlug::BIOMETRY)->first();

        if (! $biometricsModule) {
            return;
        }

        $questions = [
            [
                'text' => 'V čem se liší ověření heslem od ověření biometrií?',
                'options' => [
                    'a' => 'Heslo se vyhodnocuje pravděpodobnostně, biometrie vyžaduje 100% shodu.',
                    'b' => 'Heslo je buď správné, nebo špatné. Biometrie je stochastický proces — vyhodnocuje míru podobnosti vůči šabloně.',
                    'c' => 'Biometrie nativně chrání proti Man-in-the-Middle útokům pomocí Origin Bindingu.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Co je EER (Equal Error Rate) a proč je důležitá?',
                'options' => [
                    'a' => 'Práh (Threshold), při kterém systém začne automaticky blokovat účty z důvodu podezření na spoofing.',
                    'b' => 'Rychlost, jakou dokáže Secure Enclave zpracovat biometrickou šablonu v milisekundách.',
                    'c' => 'Bod na grafu, ve kterém se křivky FAR (False Acceptance Rate) a FRR (False Rejection Rate) protínají.',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Ukládá si váš telefon skutečnou fotografii obličeje nebo otisku prstu?',
                'options' => [
                    'a' => 'Ano, ale zašifrovaně pomocí AES-256.',
                    'b' => 'Ne — senzory extrahují jen klíčové markanty a vytvoří z nich nevratnou biometrickou šablonu (Template).',
                    'c' => 'Ano, obrázky se odesílají na servery výrobce (např. Apple iCloud).',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Proč se 2D kamera v simulaci nechala oklamat fotkou (Presentation Attack)?',
                'options' => [
                    'a' => 'Běžná kamera neumí měřit hloubku (Z-osu) — vidí jen 2D obraz a vyhodnocuje shodu rysů.',
                    'b' => 'Protože fotografie obsahovala skrytý malware (steganografie), který provedl buffer overflow v biometrickém modulu.',
                    'c' => 'Protože útočník snížil hodnotu FRR (False Rejection Rate) v nastavení systému oběti na minimum.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Jak se pokročilé systémy brání proti oklamání fotkou (PAD — detekce živosti)?',
                'options' => [
                    'a' => 'NFC čipy pro detekci krevního oběhu.',
                    'b' => 'Algoritmy pro sledování mrkání implementované v JavaScriptu.',
                    'c' => 'Infračervené (IR) projektory nebo ToF senzory, které vytváří 3D mapu povrchu.',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Co znamená „neodvolatelnost“ (Non-revocability) biometrie a proč je to problém?',
                'options' => [
                    'a' => 'Když někdo získá vaši biometrickou šablonu, nemůžete si „vygenerovat nový obličej“ ani „změnit otisk“.',
                    'b' => 'Znamená to, že jakmile je biometrie nastavena na úroveň AAL3, nelze ji v systému administrátorem vypnout.',
                    'c' => 'Označuje to fakt, že moderní snímače nelze fyzicky odpojit od základní desky zařízení.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Kde ve vašem telefonu probíhá porovnání biometrického vzorku se šablonou?',
                'options' => [
                    'a' => 'Přímo v jádře (kernelu) operačního systému (např. iOS / Android).',
                    'b' => 'V hardwarově izolovaném prostředí (Trusted Execution Environment / Secure Enclave), kam nemá přístup ani samotný operační systém.',
                    'c' => 'Na vzdálených serverech backendu (např. v bance), kam se šablona odesílá přes zabezpečené TLS spojení.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Jakou roli hraje biometrie ve FIDO2 / WebAuthn?',
                'options' => [
                    'a' => 'Biometrie se vůbec nepoužívá, standard FIDO2 spoléhá výhradně na hardwarové USB tokeny jako je YubiKey.',
                    'b' => 'Z prohlížeče se odesílá zašifrovaný hash obličeje přímo na server služby (Relying Party), který jej asymetricky ověří.',
                    'c' => 'Slouží výhradně jako lokální ověření uživatele (User Verification), které v rámci Secure Enclave odemkne asymetrický privátní klíč pro podepsání výzvy (Challenge).',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'V simulaci MasterPrintu malý senzor (80×80 px) ukládal 12 šablon. Proč to zvyšuje riziko útoku?',
                'options' => [
                    'a' => 'Více šablon = více cílů — syntetický otisk musí trefit jen jednu z nich, což zvyšuje FAR.',
                    'b' => 'Malý senzor má nižší rozlišení, a proto potřebuje více šablon pro kompenzaci optických vad.',
                    'c' => '12 šablon zabírá více paměti v Secure Enclave, což zpomaluje porovnání a umožňuje útok postranním kanálem.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Jak se můžete bránit proti oklamání fotkou (Presentation Attack)?',
                'options' => [
                    'a' => 'Registrací většího počtu prstů pro zvýšení přesnosti rozpoznávání.',
                    'b' => 'Použitím zařízení s 3D senzorem (Face ID / IR projektor) a kombinací biometrie s dalším faktorem (PIN/pattern).',
                    'c' => 'Zapnutím režimu „zvýšená bezpečnost" v nastavení fotoaparátu telefonu.',
                ],
                'correct_option' => 'b',
            ],
        ];

        Question::where('module_id', $biometricsModule->id)->delete();

        foreach ($questions as $q) {
            Question::create([
                'module_id' => $biometricsModule->id,
                'text' => $q['text'],
                'options' => $q['options'],
                'correct_option' => $q['correct_option'],
            ]);
        }
    }

    private function seedFidoQuestions(): void
    {
        $fidoModule = Module::where('slug', ModuleSlug::FIDO2)->first();

        if (! $fidoModule) {
            return;
        }

        $questions = [
            [
                'text' => 'Čím se FIDO2 zásadně liší od TOTP z pohledu kryptografie?',
                'options' => [
                    'a' => 'TOTP používá asymetrickou kryptografii, FIDO2 naopak symetrické sdílené tajemství.',
                    'b' => 'FIDO2 nepoužívá žádné sdílené tajemství — server si drží jen váš veřejný klíč a privátní klíč zůstává v hardwaru.',
                    'c' => 'Ověření u FIDO2 probíhá na serveru výrobce klíče (např. Yubico), ne přímo u služby.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Co je to Origin Binding a proč je klíčový pro obranu proti phishingu?',
                'options' => [
                    'a' => 'Prohlížeč předá klíči aktuální doménu a ta se zahrne do podpisu — na falešné doméně proto podpis nevznikne.',
                    'b' => 'Klíč se fyzicky spáruje s MAC adresou počítače přes USB nebo Bluetooth.',
                    'c' => 'Klíč funguje jen v zemi, kde byl registrován — ověřuje se IP adresa.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Útočník vykradl celou databázi banky. Proč mu to u FIDO2 nepomůže?',
                'options' => [
                    'a' => 'Klíče v databázi expirují po 30 sekundách díky HMAC algoritmu.',
                    'b' => 'V databázi jsou jen veřejné klíče — bez fyzického přístupu k vašemu hardwaru z nich nelze vytvořit platný podpis.',
                    'c' => 'Systém automaticky detekuje únik dat a zneplatní všechny klíče.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'K čemu slouží „Challenge" (výzva), kterou server posílá při přihlášení?',
                'options' => [
                    'a' => 'Určuje, jaký PIN nebo biometrii má systém po uživateli vyžadovat.',
                    'b' => 'Je to náhodná hodnota (nonce) zahrnutá do podpisu — díky ní nelze znovupoužít starý podpis (Replay Attack).',
                    'c' => 'Obsahuje zašifrovaný hash hesla, který token jen dešifruje a vrátí.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Co znamená „User Verification" (UV) u FIDO2 klíče?',
                'options' => [
                    'a' => 'Ověření administrátorských práv v operačním systému.',
                    'b' => 'Odeslání biometrického vzorku na server banky k ověření.',
                    'c' => 'Lokální ověření uživatele (PINem nebo biometrií) přímo na zařízení — teprve potom se odemkne privátní klíč.',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'V simulaci jste viděli, co se stane na phishingové doméně „fake-bank.cz". Co přesně prohlížeč udělal?',
                'options' => [
                    'a' => 'Vyhodil výjimku (SecurityError), protože rpId (banka.cz) nesouhlasí s aktuální doménou — klíč se vůbec neaktivoval.',
                    'b' => 'Klíč data podepsal, ale server banky podpis odmítl kvůli špatnému certifikátu.',
                    'c' => 'Útok uspěl, protože hardwarový klíč nekontroluje adresní řádek prohlížeče.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Co obsahuje objekt „clientDataJSON", jehož hash se podepisuje privátním klíčem?',
                'options' => [
                    'a' => 'Verzi OS, typ prohlížeče a IP adresu klienta.',
                    'b' => 'Unix Timestamp a symetrický klíč pro šifrování relace.',
                    'c' => 'Typ operace (webauthn.get), Challenge od serveru a Origin — doménu, na které se uživatel právě nachází.',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Proč NIST řadí FIDO2 do nejvyšší úrovně AAL3?',
                'options' => [
                    'a' => 'Protože je bezheslové — eliminuje faktor znalosti, který je nejslabší.',
                    'b' => 'Protože hardwarové klíče se nedají ukrást.',
                    'c' => 'Protože používá hardwarově vázané klíče a jako jediný standard je nativně odolný proti phishingu.',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Jaké je největší praktické riziko FIDO2 a jak se mu bránit?',
                'options' => [
                    'a' => 'Phishing — je nutné stále kontrolovat doménu v adresním řádku.',
                    'b' => 'Ztráta nebo krádež klíče — proto je důležité registrovat minimálně 2 klíče a uložit si recovery kódy.',
                    'c' => 'Expirace certifikátů — klíč je nutné každý rok obnovit u výrobce.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Proč byste měli na hardwarovém klíči nastavit PIN?',
                'options' => [
                    'a' => 'Bez PINu klíč odmítne komunikovat s prohlížečem.',
                    'b' => 'PIN vás chrání při krádeži — kdo klíč ukradne, bez PINu se nepřihlásí.',
                    'c' => 'PIN je povinný — bez něj klíč nejde zaregistrovat u žádné služby.',
                ],
                'correct_option' => 'b',
            ],
        ];

        // Smažeme staré otázky pro FIDO modul
        Question::where('module_id', $fidoModule->id)->delete();

        foreach ($questions as $q) {
            Question::create([
                'module_id' => $fidoModule->id,
                'text' => $q['text'],
                'options' => $q['options'],
                'correct_option' => $q['correct_option'],
            ]);
        }
    }
}
