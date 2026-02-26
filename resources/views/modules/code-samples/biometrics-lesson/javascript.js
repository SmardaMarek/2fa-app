/**
 * Příklad: WebAuthn API s vynucením lokální biometrie (User Verification)
 * Server posílá challenge, prohlížeč spustí lokální Windows Hello / TouchID.
 */
const publicKeyCredentialRequestOptions = {
    challenge: Uint8Array.from(serverChallenge, c => c.charCodeAt(0)),
    rpId: "securebank.cz",

    // Klíčový parametr pro biometrii!
    // "required" znamená: Vynutit lokální biometrii nebo PIN.
    // "discouraged" by znamenalo pouze ověření přítomnosti zařízení (kliknutí).
    userVerification: "required",

    allowCredentials: [{
        id: Uint8Array.from(credentialId, c => c.charCodeAt(0)),
        type: 'public-key',
        transports: ['internal'] // Omezíme pouze na zabudovaný senzor zařízení
    }]
};

// Spuštění biometrického dialogu OS
const assertion = await navigator.credentials.get({
    publicKey: publicKeyCredentialRequestOptions
});
