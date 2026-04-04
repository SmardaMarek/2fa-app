<?php

namespace Database\Seeders;

use App\Enums\FactorType;
use App\Enums\ModuleDifficulty;
use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            [
                'slug' => 'sms-otp',
                'title' => 'Ověřování pomocí SMS (OTP)',
                'description' => 'Základní metoda využívající mobilní síť GSM. Zjistíte, proč je dnes považována za zastaralou a zranitelnou vůči útokům SIM Swapping a odposlechu protokolu SS7.',
                'factor_type' => FactorType::Possession,
                'difficulty' => ModuleDifficulty::Beginner,
                'is_active' => true,
            ],
            [
                'slug' => 'totp-app',
                'title' => 'Autentizační aplikace (TOTP)',
                'description' => 'Generování jednorázových kódů offline (např. Google Authenticator). Eliminace rizika odposlechu sítě, ale stále existuje riziko phishingu (Real-time Phishing Proxy).',
                'factor_type' => FactorType::Possession,
                'difficulty' => ModuleDifficulty::Intermediate,
                'is_active' => true,
            ],
            [
                'slug' => 'fido2-key',
                'title' => 'Fyzický bezpečnostní klíč (FIDO2)',
                'description' => 'Zlatý standard bezpečnosti. Využití asymetrické kryptografie a hardwarového klíče (YubiKey). Díky vazbě na původ (Origin Binding) je tato metoda odolná vůči phishingu.',
                'factor_type' => FactorType::Possession,
                'difficulty' => ModuleDifficulty::Advanced,
                'is_active' => true,
            ],
            [
                'slug' => 'biometrics',
                'title' => 'Biometrická autentizace',
                'description' => 'Ověření pomocí otisku prstu nebo skenu obličeje. V kontextu webu funguje jako "User Verification" pro odemknutí kryptografického klíče v zařízení.',
                'factor_type' => FactorType::Inherence,
                'difficulty' => ModuleDifficulty::Intermediate,
                'is_active' => true,
            ],
        ];

        foreach ($modules as $data) {
            Module::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
