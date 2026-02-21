const { totp } = require('otplib');

// Simulace sdílené mezipaměti (např. Redis)
const usedTokensCache = new Map();

function verifyTotp(userId, secret, otpCode) {
    const cacheKey = `totp_${userId}_${otpCode}`;
    const now = Date.now();

    // 1. OBRANA PROTI REPLAY ÚTOKU
    if (usedTokensCache.has(cacheKey)) {
        const expiration = usedTokensCache.get(cacheKey);
        if (now < expiration) {
            console.error("Bezpečnostní chyba: Kód byl již použit!");
            return false;
        } else {
            // Úklid starých záznamů
            usedTokensCache.delete(cacheKey);
        }
    }

    // 2. Standardní matematické ověření
    const isValid = totp.check(otpCode, secret);

    if (isValid) {
        // 3. Zapsání použitého kódu do mezipaměti na 60 sekund (60000 ms)
        usedTokensCache.set(cacheKey, now + 60000);
        return true;
    }

    return false;
}
