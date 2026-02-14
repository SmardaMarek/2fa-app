import base64
from fido2.webauthn import AuthenticatorData

def verify_biometric_response(auth_data_base64, challenge):
    """
    Simulace serverového ověření biometrické autentizace (FIDO2/WebAuthn).
    """
    # Dekódování dat z autentikátoru zaslaných prohlížečem
    auth_data_bytes = base64.b64decode(auth_data_base64)
    auth_data = AuthenticatorData(auth_data_bytes)

    # 1. Kontrola příznaku User Verification (UV)
    # Tento příznak potvrzuje, že proběhlo biometrické ověření (otisk, obličej)
    if not auth_data.is_user_verified:
        print("Chyba: Biometrické ověření uživatele neproběhlo.")
        return False

    # 2. Kontrola příznaku User Presence (UP)
    # Potvrzuje, že uživatel byl u zařízení fyzicky přítomen
    if not auth_data.is_user_present:
        return False

    print("Biometrické ověření na straně klienta bylo úspěšné.")
    return True

def internal_sensor_match(captured_scan, stored_template):
    """
    Tento proces probíhá POUZE uvnitř hardware senzoru.
    Biometrická data (vzor) nikdy neopouštějí zařízení.
    """
    # Výpočet shody mezi skenem a uloženou šablonou (matching score)
    score = compare_features(captured_scan, stored_template)

    # Práh citlivosti pro přijetí (rovnováha mezi FAR a FRR)
    acceptance_threshold = 0.96

    if score >= acceptance_threshold:
        # Pokud je shoda vysoká, senzor "povolí" podepsání FIDO2 výzvy
        return "SUCCESS: Unlocking private key"

    return "FAILURE: Biometric mismatch"
