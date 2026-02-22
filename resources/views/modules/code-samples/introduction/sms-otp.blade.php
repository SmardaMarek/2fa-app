<p class="mt-1 text-sm">
    Zde vidíte implementaci metody založené na principu sdíleného tajemství generovaného na straně serveru. Server vygeneruje náhodný číselný kód, uloží jej do dočasné paměti (např. Cache) a odešle jej uživateli skrze nezabezpečený komunikační kanál sítě GSM. Všimněte si, že tato metoda postrádá mechanismus pro ověření původu (Origin Binding), což znamená, že kód není vázán na konkrétní webovou doménu a lze jej snadno zneužít při phishingovém útoku.
</p>
