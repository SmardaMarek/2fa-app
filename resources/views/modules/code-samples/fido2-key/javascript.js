/**
 * Spustí autentizaci pomocí fyzického bezpečnostního klíče (WebAuthn).
 */
async function authenticateWithKey(challengeFromServer, credentialIdFromServer) {
    const publicKeyCredentialRequestOptions = {
        // Unikátní výzva ze serveru k podpisu
        challenge: Uint8Array.from(challengeFromServer, c => c.charCodeAt(0)),
        allowCredentials: [{
            id: Uint8Array.from(credentialIdFromServer, c => c.charCodeAt(0)),
            type: 'public-key',
            transports: ['usb', 'nfc', 'ble'],
        }],
        timeout: 60000,
        // Pro fyzické klíče často stačí User Presence (dotyk),
        // ale může být vyžadován i PIN (User Verification).
        userVerification: "discouraged",
    };

    try {
        // Prohlížeč aktivuje komunikaci s USB/NFC klíčem
        const assertion = await navigator.credentials.get({
            publicKey: publicKeyCredentialRequestOptions
        });

        // Odeslání kryptografického podpisu na server k validaci
        return await sendAssertionToServer(assertion);
    } catch (err) {
        console.error("Chyba při komunikaci s klíčem:", err);
        throw err;
    }
}

/**
 * Zpracuje binární data z klíče a odešle je na backend.
 */
async function sendAssertionToServer(assertion) {
    // Převod binárních polí (ArrayBuffer) na Base64 řetězce
    const body = {
        id: assertion.id,
        rawId: btoa(String.fromCharCode(...new Uint8Array(assertion.rawId))),
        type: assertion.type,
        response: {
            authenticatorData: btoa(String.fromCharCode(...new Uint8Array(assertion.response.authenticatorData))),
            clientDataJSON: btoa(String.fromCharCode(...new Uint8Array(assertion.response.clientDataJSON))),
            signature: btoa(String.fromCharCode(...new Uint8Array(assertion.response.signature))),
            userHandle: assertion.response.userHandle
                ? btoa(String.fromCharCode(...new Uint8Array(assertion.response.userHandle)))
                : null,
        },
    };

    // AJAX požadavek na Laravel endpoint
    const response = await fetch('/mfa/fido2/verify', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(body)
    });

    return response.json();
}
