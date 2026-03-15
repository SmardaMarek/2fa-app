#include <stdint.h>
#include <stdbool.h>

#define TOTP_TIME_STEP_SEC 30
#define TOTP_WINDOW_TOLERANCE 1

extern uint32_t generate_totp_code(const uint8_t* secret_key, size_t key_len, uint64_t unix_time);

// 1. Ochrana proti Timing útokům: Operace XOR trvá vždy konstantní dobu
static bool constant_time_cmp(uint32_t a, uint32_t b) {
    return (a ^ b) == 0;
}

bool verify_totp_login(const uint8_t* secret_key, size_t key_len, uint64_t current_time, uint32_t user_input_code) {
    uint64_t base_time = current_time - (TOTP_WINDOW_TOLERANCE * TOTP_TIME_STEP_SEC);
    uint64_t end_time = current_time + (TOTP_WINDOW_TOLERANCE * TOTP_TIME_STEP_SEC);
    bool is_valid = false;

    // 2. Ochrana proti Time Driftu: Kontrola předchozího, aktuálního a následujícího okna
    for (uint64_t t = base_time; t <= end_time; t += TOTP_TIME_STEP_SEC) {
        uint32_t expected_code = generate_totp_code(secret_key, key_len, t);
        
        // 3. Neskáčeme ven z cyklu pomocí 'break', aby útočník nemohl měřit čas výpočtu
        if (constant_time_cmp(expected_code, user_input_code)) {
            is_valid = true;
        }
    }
    
    return is_valid;
}