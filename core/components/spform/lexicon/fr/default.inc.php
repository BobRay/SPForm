<?php
/**
 * Default lexicon topic for SPForm package
 * @author Bob Ray
 * 1/15/11
 *
 * @package spform
 * @subpackage lexicon
 * @language fr
 */

/* English language file for SPForm package */

/* form field labels */
$_lang['hidden-last-name'] = 'Veuillez ne pas renseigner votre nom ici';
$_lang['send-to'] = 'Envoyer à';
$_lang['your-name'] = 'Votre nom';
$_lang['email-address'] = 'Votre adresse email';
$_lang['subject'] = 'Objet de votre message';
$_lang['math-problem'] = 'Effectuer le calcul et donner le résultat dans le champ réponse';
$_lang['veri-string'] = 'Entrer le texte de vérification';
$_lang['verification'] = 'Vérification';
$_lang['enter-comments'] = 'Saisissez votre message';
$_lang['submit'] = 'Envoyer';
$_lang['wrote'] = " vous a écrit:\n\n";
/* error messages */
$_lang['bad-referer'] = 'Erreur : Serveur HTTP Référant interdit !';
$_lang['cookies-required'] = 'les cookies doivent être actif pour utiliser ce formulaire';
$_lang['form-errors'] = 'Il y a eu un problème avec l\'envoi de votre message. Veuillez revenir sur la page pécédente et corriger les erreurs suivantes :';
$_lang['could-not-initiate-mail-service'] = 'Erreur : impossible d\'initialiser le service mail de MODx';
$_lang['unauthorized'] = 'Erreur : Accès interdit.';
$_lang['no-captcha'] = 'Erreur : Le module de Captcha doit être installé pour l\'utiliser dans le module spform.';
$_lang['no-config'] = 'Erreur : Les propriétés du snippet n\'ont pas été paramétrées.';
$_lang['no-js'] = 'Fichier introuvable.';
$_lang['no-template'] = "Modèle chunk introuvable.";
$_lang['set-email'] = 'Veuillez renseigner votre email dans le paramétrage système';

/* email errors */
$_lang['fatal1'] = 'Il y a eu un problème avec l\'envoi de votre message.';
$_lang['fatal2'] = 'Vous n\'avez pas fait d\'erreur mais le problème ne peut pas être corrigé immédiatement.<br />Veuillez revenir ultérieurement et essayer de nouveau.';
$_lang['unauthorized-server'] = 'Vous accédez à ce forumulaire à partir d\'un serveur non autorisé !';
$_lang['banned'] = 'Essai à partir d\'une adresse email, serveur ou domaine banni.';
$_lang['form-problem'] = 'Problème avec le traitement de votre message.';
$_lang['form-problem-content'] = 'Les problèmes suivants ont eu lieu pendant le traitement de votre demande :';
$_lang['bad-file'] = "Impossible d\'ouvrir le fichier.";
$_lang['bad-destination'] = ' est un destinataire erroné.';
$_lang['no-email'] = "Vous n'avez pas renseigné votre adresse email.";
$_lang['bad-email'] = "Votre adresse email ne semble pas valide.";
$_lang['no-name'] = "Vous n'avez pas renseigné votre nom.";
$_lang['no-subject'] = "Vous n'avez pas renseigné l'objet de votre message.";
$_lang['no-comments'] = "Vous n'avez saisi aucun message.";
$_lang['mouse-kb-warning'] = 'Ni souris ou clavier utilisé.';
$_lang['mouse-warning'] = 'Souris non utilisée.';
$_lang['kb-warning'] = 'Clavier non utilisé.';
$_lang['last-name'] = 'Ne pas saisir le champ nom.';
$_lang['timeout1'] = 'Vous n\'avez pas pris assez de temps ou trop de temps pour saisir votre message.';
$_lang['timer-violation'] = 'Temps dépassé.';
$_lang['no-time'] = 'Minuteur activé, mais pas de temps paramétré.';
$_lang['bad-verification'] = 'Echec de vérification du code de sécurité.';
$_lang['bad-recipient'] = 'Expéditeur incorrect.';
$_lang['bad-recipient-length'] = 'Expéditeur trop long.';
$_lang['bad-subject-length'] = 'L\'objet de votre message est trop long.';
$_lang['illegal-subject'] = 'Contenu interdit dans l\'objet de votre message.';
$_lang['illegal-message'] = 'Contenu interdit dans votre message.';
$_lang['content-links'] = 'Votre message contient trop de liens.';
$_lang['mail-failure'] = 'Désolé, le système d\'envoi de message a détecté des erreurs.<br />L\'erreur la plus fréquente est une adresse email de retour incorrecte.<br /><br />NB: Si la fonction mail() est bloqué, l\'administrateur doit paramétré l\'option SMTP';
/* response messages */
$_lang['thank-you'] = 'Votre message a bien été envoyé et nous vous en remercions.';
$_lang['came-from'] = 'We remembered where you were.<br />Click the link below to be taken back.';
$_lang['back'] = 'Retour';
