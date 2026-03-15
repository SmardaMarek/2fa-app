#include <stdint.h>
#include <string.h>
#include <stdbool.h>
#include "crypto_hal.h"
#include "secure_element.h"

#define FLAG_USER_PRESENCE     0x01
#define FLAG_USER_VERIFICATION 0x04
#define SHA256_DIGEST_LENGTH   32

int ctap2_generate_assertion(
    const uint8_t rpid_hash[SHA256_DIGEST_LENGTH],
    const uint8_t client_data_hash[SHA256_DIGEST_LENGTH],
    const uint8_t* credential_id,
    size_t cred_id_len,
    bool user_verified,
    uint8_t* out_signature,
    uint8_t* out_auth_data
) {
    uint8_t private_key[32] = {0};
    uint8_t signature_base[100] = {0}; 
    uint8_t final_hash[SHA256_DIGEST_LENGTH] = {0};
    int status = -1;

    // 1. Ověření fyzické přítomnosti (User Presence)
    // Chrání před malwarem, který by se pokusil podepsat výzvu automaticky na pozadí.
    if (!hw_sensor_check_touch()) {
        return ERR_USER_PRESENCE_REQUIRED;
    }

    // 2. Vynucený Origin Binding
    // Prvních 32 bytů authData je hash domény. Podpis je tak neoddělitelně spjat s konkrétním webem.
    memcpy(out_auth_data, rpid_hash, SHA256_DIGEST_LENGTH);
    
    // Zápis stavových vlajek: UP (dotyk) a případně UV (správný PIN/biometrie)
    out_auth_data[32] = FLAG_USER_PRESENCE | (user_verified ? FLAG_USER_VERIFICATION : 0);

    // 3. Ochrana proti klonování klíče (Clone Detection)
    // Zvýšení čítače v trvalé paměti (NVM). Server asynchronii čítačů detekuje a klon zablokuje.
    uint32_t sign_count = nvm_get_and_increment_counter(credential_id);
    out_auth_data[33] = (sign_count >> 24) & 0xFF;
    out_auth_data[34] = (sign_count >> 16) & 0xFF;
    out_auth_data[35] = (sign_count >> 8) & 0xFF;
    out_auth_data[36] = sign_count & 0xFF;

    size_t auth_data_len = 37;

    // 4. Svázání dat do jednoho bloku pro podpis
    // Spojujeme stav klíče (authData) s výzvou prohlížeče (clientDataHash).
    memcpy(signature_base, out_auth_data, auth_data_len);
    memcpy(signature_base + auth_data_len, client_data_hash, SHA256_DIGEST_LENGTH);
    
    crypto_sha256(signature_base, auth_data_len + SHA256_DIGEST_LENGTH, final_hash);

    // 5. Extrakce klíče ze Secure Elementu
    // Klíč se do operační paměti dostane jen na zlomek vteřiny nutný k výpočtu.
    if (secure_element_unwrap_key(credential_id, cred_id_len, private_key) != SE_SUCCESS) {
        goto cleanup;
    }

    // Provedení samotného ECDSA podpisu
    if (crypto_ecdsa_sign(private_key, final_hash, SHA256_DIGEST_LENGTH, out_signature) != CRYPTO_SUCCESS) {
        goto cleanup;
    }

    status = 0;

cleanup:
    // 6. Sanitizace paměti (Zeroization)
    // Kritický krok: Bezpečné smazání citlivých dat z RAM, aby nešly vyčíst (např. memory scraping).
    // Používá se speciální funkce, kterou překladač nesmí odstranit (odolnost vůči optimalizacím).
    secure_memzero(private_key, sizeof(private_key));
    secure_memzero(signature_base, sizeof(signature_base));
    secure_memzero(final_hash, sizeof(final_hash));

    return status;
}