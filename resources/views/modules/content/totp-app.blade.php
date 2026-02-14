<h3>Co je TOTP (Authenticator)?</h3>
<p>
    TOTP (Time-based One-Time Password) je moderní standard pro generování jednorázových hesel, který k provozu využívá mobilní aplikaci (např. Google Authenticator, Authy).
    Na rozdíl od SMS nezávisí na signálu mobilního operátora.
</p>

<div class="my-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700">
    <strong>Klíčový princip:</strong> Server a aplikace sdílejí <strong>tajný klíč (seed)</strong>, předaný obvykle naskenováním QR kódu.
    Kód se vypočítává lokálně na zařízení kombinací tohoto tajemství a <strong>aktuálního času</strong>.
</div>

<h3>Jaká je úroveň bezpečnosti?</h3>
<p>
    TOTP eliminuje rizika spojená s telekomunikační sítí (SIM Swapping, odposlech SS7).
    Ačkoliv je výrazně bezpečnější než SMS, stále spadá do kategorie metod, které lze oklamat sociálním inženýrstvím (je "phishable").
</p>

<ul class="list-disc pl-5 space-y-2">
    <li><strong>AitM Phishing (Real-time):</strong> Pokud útočník vytvoří falešnou přihlašovací stránku, uživatel mu může kód přepsat a útočník jej v reálném čase zneužije.</li>
    <li><strong>Žádná vazba na původ (Origin Binding):</strong> Samotný kód neobsahuje informaci o tom, pro jakou doménu byl vygenerován (útočník ho může použít jinde).</li>
    <li><strong>Zabezpečení zařízení:</strong> Bezpečnost závisí na tom, zda útočník nemá fyzický přístup k odemčenému telefonu nebo zda v něm není malware.</li>
</ul>
