const { totp } = require('otplib');

// 1. SDÍLENÉ TAJEMSTVÍ (Seed)
// Tento klíč musí znát klient i server. V praxi se předává přes QR kód.
const secret = 'K6UVX7XJ7XJ7XJ7X';

/**
 * STRANA KLIENTA (Např. Google Authenticator)
 * Generuje kód na základě tajného klíče a aktuálního času.
 */
function generateCurrentToken(userSecret) {
    // Algoritmus TOTP = HOTP(Tajemství, Časový interval)
    return totp.generate(userSecret);
}

const token = generateCurrentToken(secret);
console.log(`Váš aktuální 6místný kód: ${token}`);

/**
 * STRANA SERVERU
 * Validuje kód zaslaný uživatelem.
 */
function verifyUserToken(userSecret, tokenFromUser) {
    // Server provede stejný výpočet jako klient a výsledky porovná.
    // 'check' automaticky počítá s časovým krokem (standardně 30s).
    const isValid = totp.check(tokenFromUser, userSecret);

    if (isValid) {
        console.log("Ověření úspěšné. Přístup povolen.");
        return true;
    } else {
        console.log("Neplatný nebo vypršený kód.");
        return false;
    }
}

// Simulace ověření
verifyUserToken(secret, token);
