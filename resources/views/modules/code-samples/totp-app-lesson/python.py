import pyotp
import time

# Simulace sdílené mezipaměti pro použité tokeny (např. Redis)
used_tokens_cache = {}

def verify_totp(user_id, secret, otp_code):
    # 1. Vytvoření unikátního klíče
    cache_key = f"totp_{user_id}_{otp_code}"
    current_time = time.time()

    # 2. OBRANA PROTI REPLAY ÚTOKU
    if cache_key in used_tokens_cache and used_tokens_cache[cache_key] > current_time:
        print("Bezpečnostní chyba: Kód byl již použit (Replay Attack)!")
        return False

    # 3. Standardní ověření kódu
    totp = pyotp.TOTP(secret)
    is_valid = totp.verify(otp_code)

    if is_valid:
        # 4. Kód je platný. Uložíme jej do cache s expirací 60 sekund,
        # aby nešel použít znovu.
        used_tokens_cache[cache_key] = current_time + 60
        return True
        
    return False
