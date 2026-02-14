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
        $totpModule = Module::where('slug', ModulSlug::TOTP)->first();

        if (! $totpModule) {
            return;
        }

        $questions = [
            [
                'text' => 'Co přesně znamená zkratka TOTP?',
                'options' => [
                    'a' => 'Token-Oriented Time Protocol',
                    'b' => 'Time-Based One-Time Password',
                    'c' => 'Temporary One-Time Passcode',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Proč server v naší simulaci přijal TOTP kód i na podvržené phishingové stránce?',
                'options' => [
                    'a' => 'Protože byl kód zachycen dříve, než vypršela jeho platnost.',
                    'b' => 'Protože útočník prolomil šifrování databáze.',
                    'c' => 'Protože protokol TOTP neověřuje původ domény (chybí Origin Binding), pouze matematickou shodu.',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Jak se v systémech nejčastěji zabraňuje tzv. Replay útoku (opakovanému použití kódu)?',
                'options' => [
                    'a' => 'Server si po úspěšném přihlášení uloží použitý kód do paměti (např. Redis) a během jeho časového okna jej znovu neakceptuje.',
                    'b' => 'Aplikace v mobilu zablokuje vygenerování dalšího kódu, dokud server nepotvrdí přihlášení.',
                    'c' => 'Replay útoku nelze u TOTP zabránit.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Jaká je nejběžnější doba platnosti (časové okno) jednoho TOTP kódu?',
                'options' => [
                    'a' => '10 sekund',
                    'b' => '30 sekund',
                    'c' => '60 sekund',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Bude vám Google Authenticator generovat platné kódy, pokud máte mobil v letadlovém režimu (bez internetu)?',
                'options' => [
                    'a' => 'Ne, aplikace se musí spojit se serverem pro získání nového kódu.',
                    'b' => 'Ano, výpočet probíhá lokálně pouze na základě uloženého tajemství a aktuálního času.',
                    'c' => 'Ano, ale pouze posledních 5 kódů uložených v cache.',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'Co se stane, pokud se systémový čas na vašem mobilu zpozdí o 5 minut oproti serveru (tzv. Time Drift)?',
                'options' => [
                    'a' => 'Kódy budou neplatné a nepřihlásíte se.',
                    'b' => 'Server automaticky pozná zpoždění a kód přijme.',
                    'c' => 'Aplikace v mobilu si čas sama sesynchronizuje přes GSM síť.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Do jaké kategorie autentizačních faktorů (MFA) řadíme mobilní aplikaci s TOTP kódy?',
                'options' => [
                    'a' => 'Inherence (Něco, co jsem - biometrie)',
                    'b' => 'Znalost (Něco, co vím - hesla)',
                    'c' => 'Vlastnictví (Něco, co mám - zařízení s klíčem)',
                ],
                'correct_option' => 'c',
            ],
            [
                'text' => 'Jaký je největší bezpečnostní problém samotného QR kódu, kterým se TOTP inicializuje?',
                'options' => [
                    'a' => 'QR kód obsahuje tajný klíč (Secret) v prostém textu a komukoliv, kdo si jej vyfotí, umožní vytvořit dokonalý klon autentizátoru.',
                    'b' => 'QR kódy mohou přenášet malware do mobilního zařízení.',
                    'c' => 'Platnost QR kódu po 5 minutách vyprší.',
                ],
                'correct_option' => 'a',
            ],
            [
                'text' => 'Jaká kryptografická hašovací funkce se podle RFC 6238 nejčastěji používá pro výpočet TOTP kódu?',
                'options' => [
                    'a' => 'MD5',
                    'b' => 'SHA-1 (případně SHA-256 / SHA-512)',
                    'c' => 'Bcrypt',
                ],
                'correct_option' => 'b',
            ],
            [
                'text' => 'V čem spočívá výhoda TOTP oproti ověřovacím kódům zasílaným přes SMS?',
                'options' => [
                    'a' => 'TOTP je odolný vůči útokům na infrastrukturu operátora (např. SIM Swapping).',
                    'b' => 'TOTP nevyžaduje opisování kódů, vše se děje na pozadí.',
                    'c' => 'TOTP zabraňuje phishingu pomocí Origin Binding.',
                ],
                'correct_option' => 'a',
            ],
        ];

        foreach ($questions as $q) {
            Question::create([
                'module_id' => $totpModule->id,
                'text' => $q['text'],
                'options' => $q['options'],
                'correct_option' => $q['correct_option'],
            ]);
        }
    }
}
