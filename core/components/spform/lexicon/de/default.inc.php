<?php
/**
 * spform properties German lexicon file for fields and error messages
 *
 * Translation by Guido Gallenkamp (dogo) and Roland Solenthaler
 *
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
/* German language file for SPForm package */

/* form field labels */
$_lang['hidden-last-name'] = 'Bitte geben Sie hier nicht<br /> Ihren Nachnamen ein';
$_lang['send-to'] = 'Senden an';
$_lang['your-name'] = 'Ihr Name';
$_lang['email-address'] = 'E-Mail Adresse';
$_lang['subject'] = 'Betreff';
$_lang['math-problem'] = 'Bitte lösen Sie diese Aufgabe.';
$_lang['veri-string'] = 'Bitte geben Sie die Zeichen ein.';
$_lang['verification'] = 'Überprüfung';
$_lang['enter-comments'] = 'Bitte geben Sie Ihre Nachricht ein';
$_lang['submit'] = 'Absenden';
$_lang['reset'] = 'Leeren';
$_lang['wrote'] = "schrieb:\n\n";

/* error messages */
$_lang['bad-referer'] = 'Fehler: Nicht erlaubter Fremdzugriff!';
$_lang['cookies-required'] = 'Cookies müssen aktiviert sein.';
$_lang['form-errors'] = 'Es gab Schwierigkeiten mit Ihrer Nachricht. Bitte gehen Sie zurück auf die vorherige Seite und korrigieren Sie folgende Eingaben:';
$_lang['could-not-initiate-mail-service'] = 'Fehler: Konnte MODx Mail Service nicht erreichen';
$_lang['unauthorized'] = 'Fehler: Unberechtigter Zugriff';
$_lang['no-captcha'] = 'Fehler: Das Captcha Plugin muss installiert sein, um es mit SPForm zu benutzen.';
$_lang['no-config'] = 'Fehler: Snippet Eigenschaften nicht gesetzt';
$_lang['no-js'] = 'Datei nicht gefunden: ';
$_lang['no-template'] = 'Kann Chunk nicht finden: ';
$_lang['set-email'] = 'Bitte gleichen Sie den E-Mail Sender und den Siteadmin in der Systemkonfiguration an.';

/* email errors */
$_lang['fatal1'] = 'Es gab ein Problem mit der Verarbeitung des Formulars.';
$_lang['fatal2'] = 'Dies muss nicht an Ihnen gelegen haben und ist nicht sofort behebbar.<br />Bitte versuchen Sie es später erneut.';
$_lang['unauthorized-server'] = 'Dieses Formular wurde von einem nicht zugelassenen Server abgesendet!';
$_lang['banned'] = 'Sendeversuch von einer nicht zugelassenen Adresse, IP oder Domain: ';
$_lang['form-problem'] = 'Fehler beim verarbeiten des Formulars';
$_lang['form-problem-content'] = 'Folgende Fehler traten auf, als die Daten aus dem Kontaktformular verarbeitet wurde:';
$_lang['bad-file'] = 'Kann Datei nicht öffnen: ';
$_lang['bad-destination'] = ' ist eine ungültige Adresse.';
$_lang['no-email'] = 'Sie haben keine E-Mail Adresse eingegeben.';
$_lang['bad-email'] = 'sieht nicht nach einer gültigen E-Mail Adresse aus.';
$_lang['no-name'] = 'Sie haben keinen Namen eingegeben.';
$_lang['no-subject'] = 'Sie haben keinen Betreff angegeben.';
$_lang['no-comments'] = 'Sie haben keine Nachricht geschrieben.';
$_lang['mouse-kb-warning'] = 'Sie haben entweder Maus oder Tastatur nicht benutzt';
$_lang['mouse-warning'] = 'Ihre Maus wurde nicht benutzt';
$_lang['kb-warning'] = 'Ihre Tastatur wurde nicht benutzt';
$_lang['last-name'] = 'Nachnamen bitte freilassen';
$_lang['timeout1'] = 'Sie haben das Formular verdächtig schnell oder verdächtig langsam ausgefüllt.';
$_lang['timer-violation'] = 'Zeitfehler';
$_lang['no-time'] = 'Zeitnahme aktiviert, aber keine Zeit ermittelt';
$_lang['bad-verification'] = 'Überprüfung der Zeichenkette fehlgeschlagen';
$_lang['bad-recipient'] = 'Ungültiger Empfänger: ';
$_lang['bad-recipient-length'] = 'Empfängerfeld ist zu lang';
$_lang['bad-subject-length'] = 'Betreffzeile ist zu lang';
$_lang['illegal-subject'] = 'Ungültige Betreffzeile: ';
$_lang['illegal-message'] = 'Ungültiger Nachrichten-Inhalt: ';
$_lang['content-links'] = 'Zu viele Links in der Nachricht: ';
$_lang['mail-failure'] = 'Entschuldigung. Das E-MailSystem meldet einen Fehler beim Versandt der E-Mail.<br />Am wahrscheinlichsten ist eine fehlerhafte ReturnTo-Adresse.<br /><br />Achtung: Falls Ihr ISP die Funktion mail() blockiert hat, sollten Sie über SMTP versenden.';
/* response messages */
$_lang['thank-you'] = 'Vielen Dank für Ihre Nachricht!';
$_lang['came-from'] = 'Klicken Sie auf den unten stehenden Link um zur zuletzt besuchten Seite zurück zu kehren.';
$_lang['back'] = 'Zurück';


/* Captcha messages  */
$_lang['area_captcha'] = 'CAPTCHA';
$_lang['captcha_code'] = 'Sicherheits Code';
$_lang['captcha_mathstring_code'] = 'Antwort';
$_lang['login_captcha_error'] = 'Sie haben den Text des Captcha-Bildes falsch eingegeben. Bitte versuchen Sie es erneut!';
$_lang['login_captcha_message'] = 'Bitte geben Sie den Sicherheits-Code so ein, wie er im Captcha-Bild erscheint. Wenn Sie den Code nicht lesen können, klicken Sie erneut auf das Bild um einen neuen Code zu generieren - oder kontaktieren Sie Ihren Site-Administatoren.';
$_lang['login_mathstring_error'] = 'Falsche Antwort. Bitte versuchen Sie es erneut.';
$_lang['login_mathstring_message'] = 'Bitte lösen Sie die Rechenaufgabe. Wenn Sie die Rechenaufgabe nicht lesen können, klicken Sie erneut auf das Bild um eine neue Aufgabe zu generieren - oder kontaktieren Sie Ihren Site-Administatoren.';
