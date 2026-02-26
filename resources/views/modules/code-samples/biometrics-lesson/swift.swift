/**
 * Příklad: iOS LocalAuthentication framework
 * Zabezpečené odemčení šifrovaných dat pomocí FaceID / TouchID
 */
import LocalAuthentication

let context = LAContext()
var error: NSError?

// Kontrola, zda zařízení má biometrický senzor a zda je nakonfigurován
if context.canEvaluatePolicy(.deviceOwnerAuthenticationWithBiometrics, error: &error) {
    let reason = "Ověřte svou identitu pro zobrazení privátního klíče."

    context.evaluatePolicy(.deviceOwnerAuthenticationWithBiometrics, localizedReason: reason) { success, authenticationError in
        DispatchQueue.main.async {
            if success {
                // Biometrie úspěšná. Secure Enclave nám nyní dovolí
                // přistoupit k privátnímu klíči pro podepsání transakce.
                signTransaction(with: privateKey)
            } else {
                // Autentizace selhala (např. 2D Spoofing byl zablokován PAD systémem)
                print("Přístup odepřen.")
            }
        }
    }
}
