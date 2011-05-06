<?php
/**
 * spform properties German lexicon file
 *
 * Translation by Guido Gallenkamp (dogo)
 *
 * Encoding: UTF-8
 *
 *
 *
 * SPForm is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * SPForm is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * SPForm; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package spform
 */

/**
 * Properties (property descriptions) German Lexicon Topic
 *
 * @package spform
 * @subpackage lexicon
 * @language de
 */

/* SPForm Property Description strings */
$_lang['spf_recipientarray_desc'] = 'Komma-getrennte Liste von Titel/E-Mail-Paaren für die gesendete E-Mail. Sollte in dieser Form vorliegen: Webmaster :webmaster@mydomain.de,Sales :verkauf@mydomain.de';
$_lang['spf_errorsto_desc'] = 'Wenn entsprechend eingestellt, werden alle Fehlermeldungen an diese Andresse gesendet.';
$_lang['spf_spformtpl_desc'] = 'Name des SPForm Template chunks; default: spformTpl.';
$_lang['spf_spformproctpl_desc'] = 'Name des SPFormproc Template chunk; default: spformprocTpl.';
$_lang['spf_spfcaptchatpl_desc'] = 'Name des SPForm captcha Template chunks; default: spfcaptchaTpl.';
$_lang['spf_test_mode_desc'] = 'SPForm ohne wirklichen Mail-Versand testen; default: 0.';
$_lang['spf_spfdebug_desc'] = 'Debugging-Info ausgeben - Nicht in einer laufenden Seite zu verwenden; default: 0.';
$_lang['spf_formprocallowedreferers_desc'] = 'Komma-getrennte Liste erlaubter verweisender Domains. Hier gehören alle Domains aufgeführt, die auf das Formular verweisen.';
$_lang['spf_spfresponseid_desc'] = 'Resource ID der SPFResponse-Seite. Dieser Wert wird beim ersten Aufruf des Formulars automatisch gesetzt. Entspricht der ID der "Danke"-Seite';
$_lang['spf_adviseall_desc'] = 'Alle Fehler an &errorsTo Empfänger melden; default: 0.';
$_lang['spf_warnall_desc'] = 'Vollständige Warnmeldungen an Benutzer ausgeben (nur zum Debugen einsetzen); default: 0.';
$_lang['spf_spfusesmtp_desc'] = 'SMTP anstelle von mail() verwenden. Stelle vor der Benutzung sicher, dass alle spfSMTP_ Variables gesetzt sind; default: 0.';
$_lang['spf_spfsmtp_port_desc'] = 'SMTP Port; default: 587.';
$_lang['spf_spfsmtp_host_desc'] = 'SMTP Konto Host.';
$_lang['spf_spfsmtp_username_desc'] = 'SMTP Konto Benutzername.';
$_lang['spf_spfsmtp_password_desc'] = 'SMTP Konto Passwort.';
$_lang['spf_usehiddenfield_desc'] = 'Benutze verstecktes Feld um Spambots in die Irre zu führen. Denn wenn sie es ausfüllen wird die Mail nicht versandt. Anmerkung: Diese EInstellung verwendet kein visibility:hidden und sollte damit keinen Einfluss auf SEO nehmen; default: 1.';
$_lang['spf_warnhiddenfield_desc'] = 'Den Benutzer über Verstöße das versteckte Feld betreffend warnen?; default: 0.';
$_lang['spf_logonhidden_desc'] = 'Verstöße das versteckte Feld betreffend mitloggen?; default: 0.';
$_lang['spf_requiremouseorkeyboard_desc'] = 'Erfordert vom Benutzer, entweder Maus oder Tastatur zu benutzen. Sollte keine Probleme mit Barrierefreiheit verursachen.; default: 1.';
$_lang['spf_requirekeyboard_desc'] = 'Erfordert vom Benutzer die Tastatur zu benutzen (wird ignoriert wenn requireMouseOrKeyboard=1 gesetzt ist). Diese Einstellung verursacht Probleme mit der Barrierefreiheit und sollte nur zum Debuggen benutzt werden.; default: 0.';
$_lang['spf_requiremouse_desc'] = 'Erfordert vpom Benutzer die Maus zu benutzen (wird ignoriert wenn requireMouseOrKeyboard=1 gesetzt ist). Diese Einstellung verursacht Probleme mit der Barrierefreiheit und sollte nur zum Debuggen benutzt werden.; default: 0.';
$_lang['spf_warnmouseandkeyboard_desc'] = 'Den Benutzer über Verstöße gegen Maus- oder Tastatur-Zwang benachrichtigen?; default: 0.';
$_lang['spf_logmouseandkeyboarderrors_desc'] = 'Verstöße gegen Maus- oder Tastatur-Zwang ins Log schreiben?; default: 0.';
$_lang['spf_usetimer_desc'] = 'Mindest- und Höchstzeit für das Ausfüllen des Formulars sezten. Spambots senden entweder sehr schnell oder sehr langsam ab. Die Einstellungen hierzu sollten sehr locker gedacht werden um der Eingabe durch beeinträchtigte Meschen nicht im Wege zu stehen.; default: 1.';
$_lang['spf_usetimermin_desc'] = 'Mindestzeit (Sekunden); default: 10.';
$_lang['spf_usetimermax_desc'] = 'Höchstzeit (Sekunden); default: 1800.';
$_lang['spf_warntimer_desc'] = 'Benutzer über Verstöße gegen die Zeitbeschränkung informieren?; default: 0.';
$_lang['spf_logontimer_desc'] = 'Verstöße gegen die Zeitbeschränkung ins Log schreiben?; default: 0.';
$_lang['spf_timeroffset_desc'] = 'Den Wert für die Zeitnahme verwässern; default: 14543.';
$_lang['spf_addsubjsig_desc'] = 'Dem Betreff einen Begriff voranstellen; default: 1.';
$_lang['spf_dfltsubj_desc'] = 'Begriff vor dem Betreff. Falls addSubjSig = 1 gesetzt ist wird dieser Begriff vor den Betreff jeder E-Mail gesetzt; default: Contact.';
$_lang['spf_loginjections_desc'] = 'Versuchen einer script injection ins Log schreiben?; default: 0.';
$_lang['spf_warninjections_desc'] = 'Benutzer über den Versuch einer script injection informieren?; default: 0.';
$_lang['spf_maxrecipientlen_desc'] = 'Höchstlänge des Adressfeldes des Empfängers. Wenn an mehrere Personen mit langen E-Mail Adressen gesendet wird, sollte dieser Wert angepasst werden; default: 65.';
$_lang['spf_logrecipientlen_desc'] = 'Verstöße gegen die Adressfeld-Beschränkung ins Log schreiben; default: 0.';
$_lang['spf_warnrecipientlen_desc'] = 'Benjutzer vor Verstößen gegen die Adressfeld-Beschränkung warnen; default: 0.';
$_lang['spf_maxsubjectlen_desc'] = 'Höchstlänge der Betreffzeile. Kann beliebig angepasst werden.; default: 100.';
$_lang['spf_logsubjectlen_desc'] = 'Verstöße gegen die Höchstlänge der Betreffzeile ins Log schreiben.; default: 0.';
$_lang['spf_warnsubjectlen_desc'] = 'Benutzer über Verstöße gegen die Höchstlänge der Betreffzeile warnen.; default: 0.';
$_lang['spf_maxlinks_desc'] = 'Höchstmenge der Links in der Nachricht. If your users will be sending you long lists of links, you will need to make this bigger; default: 3.';
$_lang['spf_logmaxlinks_desc'] = 'Verletzung der Regel für die Höchstmenge der Links ind Log schreiben; default: 0.';
$_lang['spf_warnmaxlinks_desc'] = 'Benutzer vor Verletzung der Regel für die Höchstmenge der Links warnen; default: 0.';
$_lang['spf_logillegalsubject_desc'] = 'Unzulässige Betreffzeilen ins Log schreiben; default: 0.';
$_lang['spf_warnillegalsubject_desc'] = 'Vor unzulässigen Betreffzeilen warnen; default: 0.';
$_lang['spf_mailalso_desc'] = 'Alle gesendeten E-Mails gehen in Kopie an diese Adresse.';
$_lang['spf_requirename_desc'] = 'Erfodert die Eingabe eines Namens; default: 1.';
$_lang['spf_requiresubject_desc'] = 'Erfodert die Eingabe eines Betreffs; default: 1.';
$_lang['spf_requireemail_desc'] = 'Erfodert die Eingabe einer E-Mail Adresse; default: 1.';
$_lang['spf_sptextrows_desc'] = 'Zeilen des Eingabefeldes für die Nachricht; default: 10.';
$_lang['spf_sptextcols_desc'] = 'Zeilenlänge des Eingabefeldes für die Nachricht; default: 50.';
$_lang['spf_includeresetbutton_desc'] = 'Button zum Leeren des Formulars einblenden?; default: 0.';
$_lang['spf_showsinglerecipientto_desc'] = 'Empfängername anzeigen, wenn es nur einen gibt; default: 0.';
$_lang['spf_requireverify_desc'] = 'Captcha-Überprüfung benutzen; default: 0.';
$_lang['spf_usemathstring_desc'] = 'Einfache Mathe-Aufgabven im Captcha Bild stellen. Verhindet das einlesen durch Spambots.; default: 1.';
$_lang['spf_warnverify_desc'] = 'Dem Benutzer mitteilen, wenn seine Captcha-Einbage falsch ist; default: 1.';
$_lang['spf_adviseonverify_desc'] = 'E-Mail an errorsTo Empfänger senden, wenn falsches Captcha eingegeben wurde.; default: 0.';
$_lang['spf_logonverify_desc'] = 'Captcha-Fehlversuche ins Log schreiben.; default: 0.';
$_lang['spf_reportremotehost_desc'] = 'Server in x-headers erwähnen (wenn möglich); default: 1.';
$_lang['spf_reportremoteuser_desc'] = 'Server-User in x-headers erwähnen (wenn möglich); default: 1.';
$_lang['spf_reportremoteaddr_desc'] = 'Server-Adresse in x-headers erwähnen (wenn möglich); default: 1.';
$_lang['spf_reportremoteident_desc'] = 'Server-Identity in x-headers erwähnen (wenn möglich); default: 1.';
$_lang['spf_reportorigreferer_desc'] = 'Original-Referrer in x-headers verwenden (wenn möglich); default: 1.';
$_lang['spf_formprocblankrefokay_desc'] = 'Dem HTTP REFERER erlauben, leer zu sein; default: 1.';
$_lang['spf_adviseonreferer_desc'] = 'Den errorsTo Empfänger über ungültige Referrer informieren.; default: 0.';
$_lang['spf_logonreferer_desc'] = 'Ungültige Referrer ins Log schreiben; default: 0.';
$_lang['spf_usebanlist_desc'] = 'Jede Nachricht gegen die Bann-Liste prüfen. Um die Bann-Liste zu benutzen, muss folgende Datei editiert werden: core/components/spform/banlist.inc.php; default: 0.';
$_lang['spf_banlistchunk_desc'] = 'Name des Banlist chunks; default: spfBanlist.';
$_lang['spf_warnbanned_desc'] = 'Benutzer benachrichtigen, wenn sie verbannt wurden; default: 0.';
$_lang['spf_adviseonban_desc'] = 'E-Mail an errorsTo Empfänger senden, wenn eine Nachricht in der Bann-Liste gelandet ist.; default: 0.';
$_lang['spf_logonban_desc'] = 'In der Bann-Liste gelandete Nachrichten ins Log schreiben; default: 0.';
$_lang['spf_chkformrefnotself_desc'] = 'Sicherstellen, dass der Referrer nicht das Formular selbst ist. Spammer tun das nämlich gerne.; default: 1.';
$_lang['spf_chkformrefownserver_desc'] = 'Sicherstellen, dass der Aufruf von der eigenen Seite kommt. Diese Einstellung kann zu einem  "Disallowed HTTP referer" Fehler führen, wenn das Kontaktformular unter mehreren URLs zu erreichen ist oder keine Seite der selen Domain zuvor aufgerufen wurde.; default: 0.';
$_lang['spf_chkformrefnotblank_desc'] = 'Sicherstellen, dass es eine verweisende Seite gibt. Mit Vorsicht zu genießen, da manche Firewalls den Hinweis auf den Referrer unterbinden.; default: 0.';

/* SPFResponse language strings */

$_lang['spf_takemeback_desc'] = 'Einen "bring mich zurück" Link auf die Danke-Seite setzen; default: 1.';
$_lang['spf_spfresponsetpl_desc'] = 'Name des SPF Response Template chunks; default: spfresponseTpl.';