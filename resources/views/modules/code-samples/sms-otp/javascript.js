const axios = require('axios');

/**
 * Odešle požadavek na SMS bránu pro doručení OTP kódu.
 */
async function dispatchSmsOtp(phoneNumber, code) {
    const apiEndpoint = 'https://api.sms-brana.cz/v1/send';

    const data = {
        recipient: phoneNumber,
        message: `Váš ověřovací kód pro přihlášení je: ${code}. Platnost je 5 minut.`,
        api_key: process.env.SMS_SERVICE_KEY
    };

    try {
        const response = await axios.post(apiEndpoint, data);
        console.log('SMS byla předána k odeslání:', response.status);
    } catch (error) {
        console.error('Chyba při komunikaci s SMS bránou:', error.message);
    }
}
