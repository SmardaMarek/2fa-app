import pyotp
import time

# 1. KROK: Generování nového tajného klíče (Seed)
# Vytvoří náhodný Base32 řetězec, který si server uloží k profilu uživatele.
new_secret = pyotp.random_base32()
print(f"Nový tajný klíč pro uživatele: {new_secret}")

# 2. KROK: Příprava pro mobilní aplikaci (Provisioning)
# Vytvoření URI, které se následně zakóduje do QR kódu.
totp = pyotp.TOTP(new_secret)
provisioning_uri = totp.provisioning_uri(
    name="student@mendelu.cz",
    issuer_name="MFA Výuková Aplikace"
)
print(f"URI pro QR kód: {provisioning_uri}")

# 3. KROK: Generování aktuálního kódu (Strana klienta)
# Toto provádí aplikace jako Google Authenticator každých 30 sekund.
current_code = totp.now()
print(f"Aktuální OTP kód v aplikaci: {current_code}")

# 4. KROK: Validace na serveru (Strana serveru)
# Server přijme kód od uživatele a ověří jeho platnost.
def verify_user_input(secret, user_input):
    verifier = pyotp.TOTP(secret)
    # verify() vrací True/False a automaticky řeší časová okna.
    if verifier.verify(user_input):
        print("Ověření proběhlo úspěšně!")
        return True
    else:
        print("Kód je neplatný nebo již vypršel.")
        return False

# Simulace úspěšného ověření
verify_user_input(new_secret, current_code)
