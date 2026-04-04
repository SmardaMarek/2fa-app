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
                'text' => 'Co přesně znamená zkratka TOTP (definováno v RFC 6238)?',
                'options' => [
                    'a' => 'Token-Oriented Time Protocol',
                    'b' => 'Time-Based One-Time Password',
                    'c' => 'Temporary One-Time Passcode',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Proč server v naší simulaci přijal TOTP kód i na podvržené phishingové stránce (AitM)?',
                'options' => [
                    'a' => 'Protože byl kód zachycen dříve, než vypršela jeho platnost a útočník prolomil šifrování databáze.',
                    'b' => 'Protože protokol TOTP neověřuje kontext spojení (zcela chybí kryptografický Origin Binding), kontroluje pouze matematickou shodu algoritmu.',
                    'c' => 'Protože asymetrický klíč prohlížeče nebyl správně zvalidován.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Jak se na backendu architektonicky zabraňuje tzv. Replay útoku v rámci jednoho časového okna?',
                'options' => [
                    'a' => 'Backend musí implementovat stavovou logiku (Stateful validation) – po úspěšném přihlášení uloží kód např. do Redis cache a během jeho časového okna jej znovu neakceptuje.',
                    'b' => 'Aplikace v mobilu zablokuje vygenerování dalšího kódu, dokud server nepotvrdí přihlášení přes WebSockets.',
                    'c' => 'Replay útoku nelze u TOTP z principu nijak zabránit, řeší to až FIDO2.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Jaký parametr řeší problém nesynchronizovaných hodin klienta a serveru (Time Drift)?',
                'options' => [
                    'a' => 'Algoritmus ignoruje čas a řídí se pouze počítadlem (counter).',
                    'b' => 'Klient si před každým generováním stahuje přesný čas z NTP serveru.',
                    'c' => 'Backend validuje nejen aktuální časový krok (typicky 30s), ale i přilehlé kroky (např. T-1 a T+1).',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Bude vám autentizační aplikace (např. Google Authenticator) generovat platné kódy, pokud máte zařízení bez připojení k internetu?',
                'options' => [
                    'a' => 'Ne, aplikace se musí spojit se serverem pro inicializaci výpočtu.',
                    'b' => 'Ano, výpočet $TOTP = Truncate(HMAC-SHA(K, T))$ probíhá zcela lokálně pouze z uloženého tajemství a lokálního času.',
                    'c' => 'Ano, ale pouze posledních 10 kódů uložených v off-line paměti.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Do jaké kategorie autentizačních faktorů (MFA) řadíme mobilní aplikaci s TOTP kódy z pohledu informační bezpečnosti?',
                'options' => [
                    'a' => 'Inherence (Něco, co jsem - biometrie)',
                    'b' => 'Znalost (Něco, co vím - hesla)',
                    'c' => 'Vlastnictví (Něco, co mám - hardwarové / softwarové zařízení s klíčem)',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Jaký je největší bezpečnostní problém samotného QR kódu, kterým se TOTP na začátku inicializuje?',
                'options' => [
                    'a' => 'Obsahuje tajný klíč (Shared Secret) v prostém textu; jeho ofocením získá útočník možnost vytvořit dokonalý klon autentizátoru.',
                    'b' => 'QR kódy mohou přenášet škodlivý payload (malware) přímo do jádra mobilního operačního systému.',
                    'c' => 'Standard RFC 6238 zakazuje jejich použití pro systémy úrovně AAL2.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Jaká kryptografická hašovací funkce se podle RFC 6238 nejčastěji používá jako základní pro výpočet TOTP kódu?',
                'options' => [
                    'a' => 'MD5',
                    'b' => 'HMAC-SHA-1 (případně novější SHA-256 / SHA-512)',
                    'c' => 'Bcrypt s dynamickým saltováním',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'V čem spočívá hlavní výhoda TOTP oproti ověřovacím kódům zasílaným přes SMS OOB kanál?',
                'options' => [
                    'a' => 'TOTP je odolný vůči útokům na infrastrukturu mobilních operátorů (např. SIM Swapping a kompromitace SS7).',
                    'b' => 'TOTP automaticky implementuje asymetrickou kryptografii proti phishingu.',
                    'c' => 'TOTP zabraňuje AitM (Phishingu) pomocí nativního Origin Bindingu.',
                ],
                'correct_option' => 'a',
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
                'text' => 'Co se primárně děje v infrastruktuře operátora při úspěšném útoku typu SIM Swapping?',
                'options' => [
                    'a' => 'Útočník nahraje malware na vysílač (BTS) a zkopíruje šifrovací klíče uživatele.',
                    'b' => 'Dochází k přepsání záznamu v HLR/HSS - útočník změní vazbu mezi veřejným číslem (MSISDN) a hardwarovým identifikátorem (IMSI) své vlastní SIM karty.',
                    'c' => 'Útočník prolomí PIN kód SIM karty pomocí brute-force útoku přes síť.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Proč telefon oběti v momentě provedení SIM Swapu okamžitě ztratí signál (Žádná služba)?',
                'options' => [
                    'a' => 'Z důvodu výpadku SS7 sítě způsobeného masivním routingem.',
                    'b' => 'Útočník musí použít lokální GSM rušičku, aby síť přesměrovala zprávu na jeho vzdálené zařízení.',
                    'c' => 'Původní SIM karta je sítí deautorizována, protože její symetrický klíč (Ki) v AuC již není spárován s daným MSISDN.',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Jak klasifikuje americký standard NIST SP 800-63B použití SMS zpráv pro dvoufaktorové ověření (MFA)?',
                'options' => [
                    'a' => 'Jako plně doporučené pro úroveň AAL3, pokud je použit 6místný kód.',
                    'b' => 'Jako "Restricted" pro úroveň AAL2 a zcela je vylučuje pro nejvyšší úroveň AAL3.',
                    'c' => 'NIST zcela zakazuje využití SMS i pro nejnižší úroveň AAL1 z důvodu absence E2E šifrování.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Proč je doručování SMS na globální úrovni (např. v roamingu) považováno z architektonického hlediska za zranitelné?',
                'options' => [
                    'a' => 'Protože spoléhá na rodinu signálních protokolů SS7/Diameter, která postrádá moderní end-to-end šifrování a spoléhá na implicitní důvěru mezi uzly.',
                    'b' => 'Protože SMS zprávy delší než 160 znaků se nešifrují vůbec.',
                    'c' => 'Protože banky odesílají kódy přes nezabezpečený HTTP protokol.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Co znamená pojem "Origin Binding" a disponuje jím SMS OTP?',
                'options' => [
                    'a' => 'Znamená kryptografické svázání autentizátoru s původcem (doménou/rpId). SMS OTP jím disponuje, pokud zpráva obsahuje odkaz.',
                    'b' => 'Znamená kryptografické svázání autentizačního tokenu s TLS relací dané domény. SMS OTP jím absolutně nedisponuje.',
                    'c' => 'Jde o funkci sítě, která váže SMS kód k fyzické GPS poloze uživatele. SMS OTP to umí v 5G sítích.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Může banka (Relying Party) softwarově zabránit kompromitaci účtu při SIM Swapu, pokud jako jediný MFA faktor používá SMS?',
                'options' => [
                    'a' => 'Ne, protože banka odesílá zprávu na logické číslo (MSISDN) a nemá jak kryptograficky ověřit, ke kterému fyzickému čipu (IMSI) jej operátor zrovna přiřadil.',
                    'b' => 'Ano, banka může vyžadovat, aby operátor odeslal zpět otisk prstu čipu.',
                    'c' => 'Ano, zkrácením platnosti SMS kódu na méně než 10 sekund.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Co je to tzv. SMS Interception na úrovni protokolu MAP (Mobile Application Part)?',
                'options' => [
                    'a' => 'Typ phishingového útoku, kdy uživatel sám přepošle kód útočníkovi.',
                    'b' => 'Útok, při kterém aktér s přístupem do SS7 sítě vyšle paket (např. UpdateLocation) a přesměruje doručování zpráv bez nutnosti fyzického SIM Swapu.',
                    'c' => 'Odposlech SMS komunikace na lokální Wi-Fi síti oběti pomocí nástroje Wireshark.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Která technologie poskytuje absolutní mitigaci proti AitM (Phishing) útokům, které snadno obchází SMS i TOTP?',
                'options' => [
                    'a' => 'Aplikace typu Microsoft/Google Authenticator.',
                    'b' => 'Zasílání kódů na e-mail místo na mobil.',
                    'c' => 'Rodina protokolů FIDO2 / WebAuthn (hardwarové klíče a Passkeys).',
                ],
                'correct_option' => 'c',
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
                'text' => 'Jaký je fundamentální rozdíl mezi autentizací pomocí hesla (Znalost) a biometrií (Inherence)?',
                'options' => [
                    'a' => 'Heslo se vyhodnocuje pravděpodobnostně, zatímco biometrie vyžaduje vždy 100% shodu bitů na úrovni hardwaru.',
                    'b' => 'Heslo je diskrétní hodnota (buď je správné, nebo chybné), zatímco biometrie je stochastický proces vyhodnocující míru podobnosti vůči šabloně.',
                    'c' => 'Biometrie jako jediný faktor nativně poskytuje ochranu proti Man-in-the-Middle útokům pomocí Origin Bindingu.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Co v kontextu biometrických systémů označuje metrika EER (Equal Error Rate)?',
                'options' => [
                    'a' => 'Práh (Threshold), při kterém systém začne automaticky blokovat účty z důvodu podezření na spoofing.',
                    'b' => 'Rychlost, jakou dokáže Secure Enclave zpracovat biometrickou šablonu v milisekundách.',
                    'c' => 'Bod na grafu, ve kterém se křivky FAR (False Acceptance Rate) a FRR (False Rejection Rate) protínají.',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Ukládají moderní systémy (jako Apple FaceID nebo Android BiometricPrompt) reálnou fotografii vašeho obličeje / otisk prstu?',
                'options' => [
                    'a' => 'Ano, ale tyto obrázky jsou zašifrovány pomocí symetrického klíče AES-256 v databázi operačního systému.',
                    'b' => 'Ne, senzory extrahují pouze klíčové markanty, ze kterých matematicky vytvoří nevratnou biometrickou šablonu (Template).',
                    'c' => 'Ano, obrázky se odesílají a ukládají na zabezpečených serverech výrobce hardwaru (např. Apple iCloud).',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Proč byla 2D RGB kamera v naší simulaci úspěšně oklamána ukradenou fotografií (Presentation Attack)?',
                'options' => [
                    'a' => 'Protože běžná optická kamera nedokáže měřit Z-osu (hloubku prostoru) a vyhodnocuje pouze dvourozměrnou shodu pixelů/rysů.',
                    'b' => 'Protože fotografie obsahovala skrytý malware (steganografie), který provedl buffer overflow v biometrickém modulu.',
                    'c' => 'Protože útočník snížil hodnotu FRR (False Rejection Rate) v nastavení systému oběti na minimum.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Jakou hardwarovou technologii využívají pokročilé systémy pro aktivní detekci živosti (PAD) a obranu proti 2D spoofingu?',
                'options' => [
                    'a' => 'NFC (Near Field Communication) čipy pro detekci krevního oběhu.',
                    'b' => 'Algoritmy pro sledování pohybu očí (mrkání) implementované v JavaScriptu.',
                    'c' => 'Infračervené (IR) projektory nebo Time-of-Flight (ToF) senzory, které vytvářejí 3D topografickou mapu povrchu.',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Co v biometrii znamená pojem "neodvolatelnost" (Non-revocability) a proč představuje architektonické riziko?',
                'options' => [
                    'a' => 'Skutečnost, že při odcizení nebo kompromitaci biometrické šablony si uživatel nemůže "vygenerovat nový obličej" nebo "změnit otisk".',
                    'b' => 'Znamená to, že jakmile je biometrie nastavena na úroveň AAL3, nelze ji v systému administrátorem vypnout.',
                    'c' => 'Označuje to fakt, že moderní snímače nelze fyzicky odpojit od základní desky zařízení.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Kde probíhá samotné kryptografické porovnání biometrického vzorku s uloženou šablonou v moderních smartphonech?',
                'options' => [
                    'a' => 'Přímo v jádře (kernelu) operačního systému (např. iOS / Android).',
                    'b' => 'V hardwarově izolovaném prostředí (Trusted Execution Environment / Secure Enclave), kam nemá přístup ani samotný operační systém.',
                    'c' => 'Na vzdálených serverech backendu (např. v bance), kam se šablona odesílá přes zabezpečené TLS spojení.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Jakou přesně roli hraje biometrie v moderním bezheslovém standardu FIDO2 / WebAuthn?',
                'options' => [
                    'a' => 'Biometrie se vůbec nepoužívá, standard FIDO2 spoléhá výhradně na hardwarové USB tokeny jako je YubiKey.',
                    'b' => 'Z prohlížeče se odesílá zašifrovaný hash obličeje přímo na server služby (Relying Party), který jej asymetricky ověří.',
                    'c' => 'Slouží výhradně jako lokální ověření uživatele (User Verification), které v rámci Secure Enclave odemkne asymetrický privátní klíč pro podepsání výzvy (Challenge).',
                ],
                'correct_option' => 'c',
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
                'text' => 'Jaký je fundamentální architektonický rozdíl mezi TOTP a FIDO2 (WebAuthn)?',
                'options' => [
                    'a' => 'TOTP využívá asymetrickou kryptografii s veřejným klíčem, zatímco FIDO2 spoléhá na bezpečnější symetrické sdílené tajemství.',
                    'b' => 'FIDO2 opouští koncept sdíleného tajemství (Shared Secret) a využívá asymetrickou kryptografii, kdy server drží pouze veřejný klíč.',
                    'c' => 'Ověření u FIDO2 probíhá výhradně na serveru výrobce klíče (např. Yubico), zatímco TOTP se ověřuje přímo u poskytovatele služby.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Co přesně znamená pojem "Origin Binding" v kontextu WebAuthn API?',
                'options' => [
                    'a' => 'Prohlížeč předává hardwarovému klíči informaci o aktuální doméně (Origin) a ta je následně zahrnuta do kryptografického podpisu, což znemožňuje AitM útoky.',
                    'b' => 'Technika, kdy se hardwarový klíč fyzicky spáruje s MAC adresou počítače pomocí Bluetooth nebo USB protokolu.',
                    'c' => 'Mechanismus, který zaručuje, že FIDO2 klíč bude fungovat pouze na území státu (dle IP adresy), kde byl původně registrován.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Jak systém FIDO2 chrání účet uživatele v případě, že útočník kompletně zkopíruje (vykrade) databázi přihlašovacích údajů banky?',
                'options' => [
                    'a' => 'Útočník musí data do 30 sekund dešifrovat, jinak klíče díky algoritmu HMAC expirují.',
                    'b' => 'Databáze banky obsahuje pouze veřejné klíče (Public Keys). Bez fyzického přístupu k hardwaru uživatele (kde je uzamčen privátní klíč) z nich nelze vygenerovat platný podpis.',
                    'c' => 'Systém automaticky detekuje masivní stažení dat a zneplatní všechny existující klíče, takže si uživatelé musí koupit nové.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Jakou roli hraje parametr "Challenge" (Výzva) zasílaný ze serveru při autentizaci (GetAssertion)?',
                'options' => [
                    'a' => 'Určuje, jaký PIN kód nebo biometrii má systém po uživateli vyžadovat.',
                    'b' => 'Slouží jako náhodná hodnota (Nonce), která je zahrnuta do podpisu, aby se matematicky zabránilo Replay útokům (znovupoužití starého podpisu).',
                    'c' => 'Je to zašifrovaný hash hesla uživatele, který token pouze dešifruje a pošle zpět.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'V konfiguraci WebAuthn narazíte na parametr "User Verification" (UV). Co tento pojem znamená z pohledu hardwaru?',
                'options' => [
                    'a' => 'Ověření, zda má uživatel administrátorská práva v operačním systému Windows/macOS.',
                    'b' => 'Odeslání biometrického vzorku (otisku prstu) přímo na server banky k jeho validaci.',
                    'c' => 'Lokální ověření uživatele (např. PINem nebo biometrií) přímo v Secure Enclave, které slouží jako podmínka k odemčení privátního klíče pro podepsání výzvy.',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Pokud útočník při AitM (Phishing) útoku pošle prohlížeči oběti platnou výzvu z banky, ale na podvržené doméně "fake-bank.cz", co se stane?',
                'options' => [
                    'a' => 'Prohlížeč vyhodí výjimku (SecurityError), protože parametr rpId (např. banka.cz) nesouhlasí s aktuální doménou (Origin). Autentizátor se vůbec neprobudí.',
                    'b' => 'Uživatel je vyzván k dotyku klíče, klíč podepíše data, ale server banky podpis následně odmítne kvůli špatnému certifikátu.',
                    'c' => 'Útok bude úspěšný, protože hardwarový klíč nedokáže číst text v adresním řádku prohlížeče.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Co přesně je obsahem objektu "clientDataJSON", jehož hash se v rámci FIDO2 podepisuje privátním klíčem?',
                'options' => [
                    'a' => 'Verze operačního systému, typ prohlížeče a IP adresa klienta.',
                    'b' => 'Aktuální čas (Unix Timestamp) a symetrický klíč pro šifrování relace.',
                    'c' => 'Typ operace (webauthn.get), Challenge (výzva od serveru) a Origin (URL domény, na které se uživatel právě nachází).',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Do jaké úrovně záruky autentizátoru (AAL) dle standardu NIST SP 800-63B spadá FIDO2 / WebAuthn a proč?',
                'options' => [
                    'a' => 'AAL1, protože se jedná o bezheslové řešení (chybí faktor znalosti).',
                    'b' => 'AAL2, protože hardwarové klíče lze fyzicky ukrást.',
                    'c' => 'AAL3, protože využívá hardwarově vázané kryptografické klíče a jako jediný standard poskytuje nativní odolnost proti phishingu (Phishing-Resistant).',
                ],
                'correct_option' => 'c',
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
