<?php

namespace Database\Seeders;

use App\Enums\ModulSlug;
use App\Models\Module;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $this->seedTotpQuestions();
        $this->seedSmsQuestions();
    }

    private function seedTotpQuestions(): void
    {
        $totpModule = Module::where('slug', ModulSlug::TOTP)->first();

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
        $smsModule = Module::where('slug', ModulSlug::SMS)->first();

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
}
