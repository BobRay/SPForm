
SPForm Version: 3.0.6 - Simple Spam-proof Contact Form Snippet
==============================================================


This File
---------
    If you need to refer to this file again, you can view it by going to
    Tools | Package Management and clicking on the plus sign next to
    the SPForm Package.

    It is also stored as a file at: assets/components/spform/docs/readme.txt.

Introduction
------------
    SPForm is a simple spam-proof contact form for MODx. There are more
    details below, but that's all you need to know for now.

Basic Usage
-----------

    When the installation is completed, you should have a fully working
    spam-proof contact form that sends email to address you give during the install.

    Minimal snippet call: [[!SPForm]]

    To see SPForm's options, just go to the elements section of the Manager
    and select the SPForm snippet. Then click on the Snippet Properties tab.

    You can set almost all the options either by editing the snippet properties
    or by using parameters to override them in the snippet call on your contact
    page. You can rename the contact page if you like. You can also rename the
    response ("thank you") page but don't do it until after you have visited
    the contact page at least once so the response page ID has been set.
    You can also move the pages around in the tree so they appear where
    you want them to in your menu.

    To override the settings in the snippet call, just add parameters you see
    in the snippet properties grid.

    Example:

    [[!SPForm? &useTimer=`0` &warnAll=`1` &spfDebug=`1`]]

    This will turn off the timer and turn on all warnings and debug messages.
    You can override any property in the grid with a parameter in the snippet call,
    but if you only have one contact form, it's usually easier just to edit the
    properties in the grid.

    A few properties are attached to the SPFReponse snippet and you'll have to set
    those on the properties tab for that snippet.

    Hopefully, everything you need to know about the property settings is there
    in the snippet properties grids. Just click on the little plus sign next to
    a property to see an explanation of what it does.

    Important Note: If you have the "log" properties on at a busy site, your
    error log (assets/components/spform/error.log) can get very big, very fast.
    You can delete it or save it empty it at any time.

Styling the pages
-----------------
    Almost anything you want to do in the way of styling the form and the response
    page can be done by editing the spformTpl and spfresponseTpl files and by
    changing the SPForm CSS file at assets/components/spform/css/spform.css.
    The error page can be styled by editing the spformprocTpl file and
    the spform.css file.

    Note that the default is to have the prompts and inputs on separate lines
    of the form, but CSS for having then inline is already in the CSS file.
    Just change spf_block_prompt to spf_inline_prompt in the spformTpl chunk.

    If you want to have your own CSS file (a good idea if you've made changes
    that you don't want overwritten when you update the snipet), just create
    your css file and pass the path to it as a parameter in the snippet call:

    [[!SPForm? &spfCssPath=`path_to_your_css_file`]]
    [[!SPFResponse? &spfCssPath=`path_to_your_css_file`]]

    Be sure to do this for both snippet calls if you've made changes that will
    affect the response page.

    Another option is to paste the spform CSS file into your main CSS file and
    use &spfCssPath=`""` in the snippet calls. SPForm will then ignore its own
    CSS file.

The Ban List
------------
    You can ban individual email addresses, domains and subdomains either
    by name or by IP number by editing the banlist file at
    assets/components/spform/banlist.inc.php.

    There are instructions in the comments section of the
    file on how to do it. With all the spam-proofing options,
    banning is usually unnecessary but if someone is manually
    entering stuff in the form and annoying you, this is the
    way to stop them.

Troubleshooting
---------------

* Everything appears to work but no mail arrives.

    The most common problem with SPForm is that it uses php mail() by default.
    Many servers have this disabled. If this is the case, you should see an
    error message suggesting that you use SMTP. Use the SMTP settings in the snippet
    properties grid to turn on this option. You can use any SMTP account, even at
    a different server, to send with SPForm. Be sure to set all the SMTP options
    correctly.

    If you continue to have this problem, take a close look at the recipientArray
    setting in the snippet properties. It should be a comma-separated list of
    titles and email addresses. Like this:

    Webmaster :webmaster@yourdomain.com,Sales :Sales@yourdomain.com, Support :support@yourdomain.com

* I changed an option, but nothing has changed.

    Remember that when you change a snippet property
    setting, you have to *save* the snippet or the change will be lost.

    Clear the MODx site cache (Site | Clear cache), then clear your browswer cache
    (usually on the Tools menu -- something like Clear Private Data or Delete
    Browsing History).

* After submitting the page, I get a white screen with an unauthorized referer message.

    Make sure that the formprocAllowedRefers setting includes all domains that your
    form can be reached through (e.g. yourdomain.com,www.yourdomain.com, etc.). If
    you turn on the spfDebug option, you should see the actual referer near the top
    of the output. Make sure that referer is listed in formprocAllowedReferers.

    For example, if you see this for the referer:
        http://mydomain.com/modx/index.php?id=0

    You should have mydomain.com in your referers list.

* The spform page looks unstyled and the validation doesn't work.

    Be sure that the Contact page and the Response page have been assigned
    a template. If they have no template, they will display but with no
    CSS and no javascript.

    Clear the site cache after assigning a template.

* I have the hidden field turned on, but I can see it in the form.

    Be sure that the Contact page and the Response page have been assigned
    a template. If they have no template, they will display but with no
    CSS which will allow the hidden field to be visible.

    Clear the site cache after assigning a template.


* I keep getting error messages when submitting the form.

    The error message should tell you which SPForm option is causing the trouble.
    Turn it off in the properties grid.

* I have the takeMeBack option on, but no link appears on the response page.

    Some servers will delete the referer variable. For those servers, the
    Take Me Back option won't work.

* My users often send me lots of links in their messages and they always get an error.

    Change the maxLinks setting in the snippet properties grid to allow more links
    in a message.

* The box for entering a message is too big or too small.

    Change the spTextRows and spTextCols settings to make it the size you want.

* I'm still having trouble.

    Set the warnAll, spfDebug, and adviseAll settings to 1. This will give a warning
    for all errors and also email the errors to the errorsTo address in addition to
    printing the debugging information on the form. Be sure to turn all three off after
    you find the problem.

    If you're still having trouble, post your problem in the SPForm section at the
    MODx forums:

    http://modxcms.com/forums


About SPForm
------------
    Adapted from:  Many sources but particularly scform by James Seymour and CFFormProtect by Jake Munson
    Compatibility: MODX Revolution

    Special thanks to the following for their help and support:
        * Rene Tschannen
        * Susan Ottwell
        * Jason Coward
        * Ryan Thrash
        * Shaun McCormick

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

    SPForm has been completely refactored for MODx Revolution. It now has
    templates, classes, and its behavior can be controlled by changing
    the settings in the snippet properties grid.

    Installation is now fully automated and SPForm should work for you
    with little or no configuration.

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

    Please let me know via the MODx forum if you have any problems with
    SPForm or suggestions for improving it or these instructions.

	Bob Ray






