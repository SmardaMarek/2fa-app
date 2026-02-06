<h3>Co je SMS OTP?</h3>
<p>
    SMS OTP (One-Time Password) je nejstarší a nejrozšířenější metoda dvoufaktorové autentizace.
    Funguje na principu "něco, co vlastníte" - v tomto případě SIM kartu spárovanou s telefonním číslem.
</p>

<div class="my-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700">
    <strong>Klíčový princip:</strong> Server vygeneruje náhodný kód (obvykle 6 číslic), pošle ho přes síť mobilního operátora a uživatel ho přepíše do formuláře.
</div>

<h3>Proč je to dnes problém?</h3>
<p>
    Ačkoliv je SMS lepší než žádné MFA, z pohledu moderní bezpečnosti je považována za "zastaralou" (Deprecated by NIST).
    Hlavní slabinou je protokol <strong>SS7</strong> (Signaling System No. 7), který telekomunikační sítě používají.
</p>

<ul class="list-disc pl-5 space-y-2">
    <li><strong>SIM Swapping:</strong> Útočník přesvědčí operátora, aby převedl vaše číslo na jeho SIM kartu.</li>
    <li><strong>Phishing:</strong> SMS zpráva neobsahuje kontext. Pokud kód zadáte na falešné stránce, útočník ho může okamžitě použít.</li>
    <li><strong>Nedostatek soukromí:</strong> Obsah SMS lze číst i na zamčené obrazovce telefonu (pokud není skryt).</li>
</ul>
