import pyotp
import time

# Inicializace s tajným klíčem
totp = pyotp.TOTP("JBSWY3DPEHPK3PXP")

print("Aktuální OTP kód:", totp.now())

# Simulace vypršení platnosti (standardně 30 sekund)
# print("Kód za 30 sekund:", totp.at(time.time() + 30))
