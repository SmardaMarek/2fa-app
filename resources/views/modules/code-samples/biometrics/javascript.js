/**
 * Spustí registraci biometrických údajů pomocí WebAuthn API.
 */
async function registerBiometrics(challengeFromServer) {
    const options = {
        publicKey: {
            // Relying Party - identifikace vaší aplikace
            rp: { name: "MFA Výuková Aplikace", id: window.location.hostname },
            user: {
                id: Uint8Array.from("user_id", c => c.charCodeAt(0)),
                name: "student@mendelu.cz",
                displayName: "Student"
            },
            challenge: Uint8Array.from(challengeFromServer, c => c.charCodeAt(0)),
            pubKeyCredParams: [{ type: "public-key", alg: -7 }], // ES256 algoritmus
            authenticatorSelection: {
                // 'required' vynutí biometrii (User Verification)
                userVerification: "required",
                // 'platform' omezí použití na vestavěné senzory (TouchID/FaceID)
                authenticatorAttachment: "platform",
            },
            timeout: 60000,
        }
    };

    try {
        // Prohlížeč vyvolá systémové okno pro biometrické ověření
        const credential = await navigator.credentials.create(options);

        // Odeslání výsledku na server k uložení veřejného klíče
        return await sendCredentialToServer(credential);
    } catch (err) {
        console.error("Biometrické ověření selhalo nebo bylo zrušeno:", err);
        throw err;
    }
}

/**
 * Pomocná funkce pro odeslání kryptografických dat na Laravel backend.
 */
async function sendCredentialToServer(credential) {
    // WebAuthn vrací binární data (ArrayBuffer), která musíme
    // před odesláním převést do formátu čitelného pro JSON (Base64).
    const body = {
        id: credential.id,
        rawId: btoa(String.fromCharCode(...new Uint8Array(credential.rawId))),
        type: credential.type,
        response: {
            attestationObject: btoa(String.fromCharCode(...new Uint8Array(credential.response.attestationObject))),
            clientDataJSON: btoa(String.fromCharCode(...new Uint8Array(credential.response.clientDataJSON))),
        },
    };

    // Odeslání na endpoint definovaný v Laravel routes
    const response = await fetch('/mfa/biometry/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(body)
    });

    return response.json();
}
