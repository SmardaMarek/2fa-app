#include <stdint.h>
#include <stddef.h>
#include "crypto_hal.h"

uint32_t generate_hotp_code(const uint8_t* secret_key, size_t key_len, uint64_t counter) {
    uint8_t hmac_result[20];
    uint8_t counter_be[8];

    // 1. Endianness: Čítač (nebo čas u TOTP) musí být pro HMAC serializován striktně jako Big-Endian
    for (int i = 7; i >= 0; i--) {
        counter_be[i] = counter & 0xFF;
        counter >>= 8;
    }

    crypto_hmac_sha1(secret_key, key_len, counter_be, sizeof(counter_be), hmac_result);

    // 2. Dynamic Truncation: Použití spodních 4 bitů posledního bajtu jako ukazatele (offsetu)
    uint8_t offset = hmac_result[19] & 0x0F;

    // 3. Maskování: Extrakce 31 bitů (maska 0x7F zahazuje znaménkový bit) a oříznutí na 6 číslic
    uint32_t binary_code = ((hmac_result[offset] & 0x7F) << 24) |
                           ((hmac_result[offset + 1] & 0xFF) << 16) |
                           ((hmac_result[offset + 2] & 0xFF) << 8) |
                           (hmac_result[offset + 3] & 0xFF);

    return binary_code % 1000000;
}