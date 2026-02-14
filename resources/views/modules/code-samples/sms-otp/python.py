import secrets
import time

# Simulovaná databáze kódů s expirací
otp_store = {}

def generate_otp(phone_number):
    """Generuje bezpečný 6místný kód a uloží jej s časem expirace."""
    code = str(secrets.randbelow(900000) + 100000)
    # Expirace za 300 sekund (5 minut)
    otp_store[phone_number] = {
        "code": code,
        "expires_at": time.time() + 300
    }
    return code

def verify_otp(phone_number, user_input):
    """Ověří kód a zkontroluje, zda nevypršela jeho platnost."""
    record = otp_store.get(phone_number)

    if not record:
        return False

    # Kontrola času a shody kódu
    if time.time() < record["expires_at"] and record["code"] == user_input:
        del otp_store[phone_number]  # Kód je jednorázový
        return True

    return False
