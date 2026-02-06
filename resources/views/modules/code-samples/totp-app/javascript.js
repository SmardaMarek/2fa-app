// Příklad za použití knihovny 'otplib'
const { totp } = require('otplib');

const secret = 'K6UVX7XJ7XJ7XJ7X'; // Sdílený tajný klíč (Base32)

// Generování aktuálního 6místného kódu
const token = totp.generate(secret);

console.log(`Váš aktuální kód je: ${token}`);
