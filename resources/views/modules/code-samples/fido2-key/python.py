import os
from fido2.server import Fido2Server
from fido2.webauthn import PublicKeyCredentialRpEntity
from fido2.client import ClientData
from fido2.ctap2 import AuthenticatorData

# 1. Konfigurace Relying Party (RP)
# 'id' musí odpovídat doméně webu (Origin Binding)
rp = PublicKeyCredentialRpEntity(id="localhost", name="MFA Výuková Aplikace")
server = Fido2Server(rp)

def start_authentication(user_credentials):
    """
    FÁZE 1: Inicializace autentizace.
    Vygeneruje unikátní výzvu (challenge), kterou musí klíč podepsat.
    """
    # Vygenerujeme výzvu a parametry pro prohlížeč
    options, state = server.authenticate_begin(user_credentials)

    # 'state' obsahuje challenge, který se musí uložit do session na serveru
    return options, state

def complete_authentication(credential_data, expected_challenge, user_credentials):
    """
    FÁZE 2: Verifikace podpisu.
    Ověří kryptografický podpis zaslaný z fyzického klíče.
    """
    try:
        # Knihovna automaticky ověří:
        # - Platnost kryptografického podpisu
        # - Shodu výzvy (anti-replay ochrana)
        # - Shodu domény (Origin Binding / ochrana proti phishingu)
        credential = server.authenticate_complete(
            expected_challenge,
            user_credentials,
            credential_data
        )

        # Pokud metoda neskončí výjimkou, autentizace je úspěšná
        print(f"Uživatel úspěšně ověřen klíčem ID: {credential.credential_id}")
        return True
    except Exception as e:
        print(f"Chyba při ověřování podpisu: {e}")
        return False
