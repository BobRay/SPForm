/*******************************************
File: readme.txt $

Snippet:       SPForm
Version: 1.0.3
$Revision: 118 $
$Author: Bob Ray $
$Date: 2008-10-01 01:12:07 -0500 (Wed, 01 Oct 2008) $
Adapted from:  Many sources but particularly scform by James Seymour and CFFormProtect by Jake Munson
Compatibility: MODX 0.9.6

Special thanks to the following for their help and support:
	* René Tschannen
	* Susan Ottwell
	* Jason Coward
	* Ryan Thrash

*******************************************/
    I created this snippet for people who want a really simple, easy to
    install, easy to use, easy to reconfigure, email contact form with the
    best spam protection I could manage. The MODx eForm snippet is available
    for use in email contact forms, but it is extremely flexible and
    powerful. As a result, it is somewhat daunting for some people to
    install and use.

    If you need complex templates, multiple templates, file uploads,
    multi-language support, or communication between your contact form and
    the MODx DB, you want eForm. If you want extra fields, you can modify
    the SPForm snippet code, or use eForm. SPForm may have those features
    in the future, but it doesn't now.

    SPForm is as spam proof as I could make it. It protects well against
    email injection attacks, flooding, and various other techniques. The
    email addresses of your recipients are well hidden and never appear in
    the source code of a page. It also has a number of options that will
    give even more protection against spammers such as pseudo form fields
    and CAPTCHA. You can also enter spammers with specific email addresses
    or IP numbers into the banlist file to prevent them from using your
    form. You can ban whole domains if you want. It also allows you to set
    the maximum length of the e-mail and subject fields and limit the
    number of URLs that can be sent in a single message. It has options to
    use hidden form fields, and to require keyboard or mouse action in
    filling the form. You can set maximum and minimum times that users can
    take to fill out your form. You can even ask users to solve simple math
    problems to prove that they are human. All the options are individually
    configurable, the idea being that everyone will use a different
    configuration and spammers will find it more work to adjust to yours
    than it's worth.

    Please note that no contact form can prevent spammers from visiting
    your site and manually sending you spam through your contact form.
    SPForm will protect you from most autospammers and will let you limit
    the number of http links in each e-mail message.

    As a MODx snippet, SPForm is fairly lame. The form simply has a
    contact(s) field, subject, return email address, and a comment text
    box. At present, these are hard-coded into the snippet (i.e. no TPL, no
    placeholders). It has many options, but they can only be set by editing
    the config file, spfconfig.cfg.php, (i.e. no parameters in the snippet
    call). If you have multiple recipients to send to, the user will see a
    drop-down box to select from. My goal was to adapt Jim Seymour's ScForm
    for use as a MODx snippet and add some new spam-protection tricks to
    it. To increase the spam protection, Jim's ScForm handles the form over
    two separate pages so the parameter values need to be available in two
    separate places. It seemed that it might compromise the spam proofing
    to _POST them to the second page and I didn't have time to put them all
    into a session variable and test them, so I left them in the config file
    as per the original design.

    On the plus side, installation is simple and SPForm should work for you
    with very little configuration.

    The parameters are described in the spfconfig.cfg.php file (where they
    are also set), but once you set the few required parameters at the top
    of that file, the defaults should work fine on the rest. The intended
    email addresses are set in the contacts.cfg.php file. Banned emailers
    or domains are set in the banlist.cfg.php file.

    Some of the original code for SPForm comes from Scform.php, written by
    James Seymour. I left Jim's GPL notice in the snippet source code. I've
    made extensive modifications to Jim's code. Some are to make the form
    work as a MODx snippet. Others are based on ideas I've found in other
    spam-proof contact forms including Jake Munson's CFFormProtect. Some of
    the ideas are my own. If SPForm works for you, Jim and Jake deserve
    most of the credit. If it doesn't, I deserve most of the blame. Please
    don't contact Jim or Jake for help with the snippet. As far as I know,
    neither are MODx-aware and they almost certainly won't be able to help
    you.

    If there is enough interest, I may rewrite SPForm from scratch as a
    proper, object-oriented, MODx snippet with multi-language support and
    parameters in the snippet call. For now, it's ugly on the inside but
    beautiful on the outside. I've been using it on a production site for
    about three months and it seems stable and reliable, but I'm not
    guaranteeing anything.

    Please let me know via the MODx forum if you have any problems with
    SPForm or suggestions for improving it or these instructions.

	Bob Ray

	Installing SPForm

    [Note: The naming convention I used has file, directory, and document
    names in all lower case and all snippet names in mixed case (camel-case
    -- sort of). Remembering this may help keep you from running into
    trouble, especially if your server honors case-sensitive names. It's
    difficult to debug naming errors in SPForm, so be careful.]

    1. Expand the the spform .zip file in your assets/snippets folder or,
       to install manually, follow step 1a.

	1a. Create a subdirectory under assets/snippets called spform.

	  Unzip spform.zip somewhere and upload these files to the spform directory:
		 index.html
	     spform.inc.php
	     spformproc.inc.php
	     spfresponse.inc.php
	     spfconfig.cfg.php
         spfdebug.php
	     contacts.cfg.php
	     banlist.cfg.php
	     spfveriword.php
	     spfvericlass.inc.php
	     mathstringclass.inc.php
	     mouseMovement.js
	     usedKeyboard.js

	     In the spform directory, create the following three directories:
	     	noises
	     	ttf
	     	lang

	     Copy the 4 noise jpgs to the noise subdirectory
	     Copy the .ttf files to the ttf subdirectory
	     Copy the language files (en.inc.php, etc.) to the lang subdirectory

    2. In the Modx Manager, create the contact page you want your form to
    appear on (click on "New Document" on the Site tab). Be sure to publish
    it, make it show in the menu, and enter a menu alias for it (e.g.
    "Contact Us"). You can probably use your default template because the
    form is not very wide and will fit in most designs.

	Put the following snippet call on the contact page:

	     [!SPForm!]

         Note: For MODx 0.9.7 use: [[!SPForm]]

    3. Create a page to hold the processing snippet (SPFormProc). Use any
    template. This page will only be viewed by users who have made an
    error. Set the title and alias to spformproc. It should not show in the
    menu. Put the following snippet call on that page:

	     [!SPFormProc!]

         Note: For MODx 0.9.7 use: [[!SPFormProc]]

	IMPORTANT: Make a note of the spformproc document ID, you'll need it.

    4. Create a response page using your default template. Set the page
    title and alias to spfresponse. It should not show in the menu. Put the
    following snippet call on that page:

	     [!SPFResponse!]

         Note: For MODx 0.9.7 use: [[!SPFResponse]]

    IMPORTANT: Make a note of the spfresponse document ID, you'll need it/

    5. Create the snippets. Remember that snippet names are case sensitive
    so the snippet names need to match the names in the snippet calls
    above.

	Paste the following code into a snippet called SPForm:
		require_once $modx->config['base_path']."assets/snippets/spform/spform.inc.php";

	Paste the following code into a snippet called SPFormProc:
		require_once $modx->config['base_path']."assets/snippets/spform/spformproc.inc.php";

	Paste the following code into a snippet called SPFResponse:
		require_once $modx->config['base_path']."assets/snippets/spform/spfresponse.inc.php";

    6. In the MODx file manager, edit the file contacts.cfg.php.
    Instructions in that file will tell you what to do. This is where you
    put the email address(es) to send form content to. (The file should be
    in the /assets/snippets/spform directory.)

    7. In the MODx file manager, edit the file spfconfig.cfg.php.
    Instructions in the file will tell you what to do. (The file should be
    in the /assets/snippets/spform directory.) Be sure to set the two document
    IDs you noted above (for spformproc and spfresponse).

    8. For additional protection, you may also want to create a robots.txt
    file (name must be all lower case) or add the lines below to your
    existing robots.txt file. Not all search bots will honor it, but many
    do. This may help keep your spform files from being indexed and found
    directly by spammers searching for "contact."

    There can be only one robots.txt file at a site and it must be in the
    root (usually in the public_html directory).

	[add just these two lines to robots.txt]

	User-agent: *
	Disallow: /assets/snippets/spform/




