<?php

// Zjednodušená backendová logika pro ověření FIDO2 podpisu (např. v PHP webauthn knihovně)

// 1. Dekódování zpráv od klienta
$clientDataJSON = base64_decode($request->clientDataJSON);
$clientData = json_decode($clientDataJSON);

// 2. Kontrola Origin Bindingu na backendu (Pád phishingových útoků)
if ($clientData->origin !== 'https://securebank.cz') {
    throw new SecurityException('Origin mismatch! Detekován pokus o Phishing.');
}

// 3. Kontrola Challenge (Obrana proti Replay útokům)
if ($clientData->challenge !== $sessionChallenge) {
    throw new SecurityException('Challenge mismatch! Možný Replay Attack.');
}

// 4. Kryptografické ověření
// Použijeme Public Key (K_pub) uložený při registraci k ověření,
// že asertace byla podepsána patřičným Private Key (K_priv).
$isValid = $crypto->verifySignature(
    $publicKey,
    $signature,
    $authData.hash('sha256', $clientDataJSON)
);
