#include <stdint.h>
#include <stdbool.h>
#include "biometric_hal.h"
#include "crypto_hal.h"

#define EMBEDDING_SIZE 256
#define MATCH_THRESHOLD 0.85f

typedef struct {
    float features[EMBEDDING_SIZE];
    uint32_t user_id;
} bio_template_t;

int biometric_authenticate(const bio_template_t* stored_template, uint8_t* out_auth_token) {
    float live_features[EMBEDDING_SIZE] = {0.0f};
    float similarity_score = 0.0f;
    int status = -1;

    // 1. Liveness Check (Presentation Attack Detection) před samotným zpracováním
    if (!hw_sensor_check_liveness()) {
        return ERR_SPOOF_DETECTED;
    }

    if (hw_sensor_extract_features(live_features) != SENSOR_OK) {
        goto cleanup;
    }

    // 2. Pravděpodobnostní shoda: Porovnání vektoru vůči prahu (kompromis FAR/FRR)
    similarity_score = calculate_cosine_similarity(stored_template->features, live_features, EMBEDDING_SIZE);

    if (similarity_score >= MATCH_THRESHOLD) {
        generate_secure_auth_token(stored_template->user_id, out_auth_token);
        status = 0;
    } else {
        status = ERR_MATCH_FAILED;
    }

cleanup:
    // 3. Zeroization: Bezpečné smazání citlivých biometrických PII dat z operační RAM
    secure_memzero(live_features, sizeof(live_features));
    similarity_score = 0.0f;

    return status;
}