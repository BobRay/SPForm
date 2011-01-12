SPForm Extra for MODx Revolution
=======================================

**Author:** Bob Ray [Bob's Guides](http://bobsguides.com)

SPForm is a simple spam-proof contact form for MODx. It is, for the most part, self-installing and self-configuring in MODx
Revolution.

##Basic Usage

When the installation is completed, you should have a fully working
spam-proof contact form that sends email to the address you give
during the install.

Minimal snippet call:

      [[!SPForm]]

The most common alteration is to the &recipientArray parameter,
which contains the list of recipients SPForm will display in a drop-down
list in the form. Here's an example:

      [[!SPForm? &recipientArray=`Webmaster:webmaster@yourdomain.com,Sales:sales@yourdomain.com`]]

The entries are separated by commmas. For each entry, the part to the left of the colon will show
in the drop-down list and the part to the right will be the email address the message is sent to.

To see SPForm's many other options, just go to the elements section of the Manager
and select the SPForm snippet. Then click on the "Properties" tab. Click on the
"Default Properties Locked" button to unlock the properties, then on the
little plus sign next to each property to see what it does.

