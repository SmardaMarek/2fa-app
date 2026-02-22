<p class="mt-1 text-sm">
    Tato implementace využívá asymetrickou kryptografii, kde soukromý klíč nikdy neopouští zabezpečený čip hardwarového zařízení. Při přihlášení server odešle "výzvu" (challenge), kterou klíč podepíše pouze v případě, že se doména webové stránky shoduje s původem registrovaným při prvotním nastavení (Origin Binding). Tento mechanismus, realizovaný skrze WebAuthn API, představuje současný zlatý standard, který efektivně eliminuje riziko phishingu.
</p>
