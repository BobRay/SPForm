
<div id="spf_form">

<form action="[[~[[*id]]]]" method="post" onsubmit="return checkform(this);">

  [[+spf-use-mouse-or-keyboard1]]
  [[+spf-use-mouse-or-keyboard2]]

  [[+spf-use-hidden-field]]

  [[+spf-use-timer]]

  [[+spf-cookie-message]]

 <div class = "spf_recipient">[[+spf-recipient]]</div>

<div class="spf_input_pair">
<span class="spf_block_prompt"> [[+spf-name-prompt]]: </span>
<span class="spf_normal_input"><input type="text" id="name" name="name" size="30" /></span>
</div>

<div class="spf_input_pair">
<span class="spf_block_prompt"> [[+spf-email-prompt]]: </span>
<span class="spf_normal_input"><input type="text" id="email" name="email" size="30" /></span><br />
</div>

<div class="spf_input_pair">
<span class="spf_block_prompt">[[+spf-subject-prompt]]: </span>
<span class="spf_normal_input"><input type="text" id="subject" name="subject" size="30" /></span><br />
</div>

  [[+spf-captcha-stuff]]

<div class="spf_block_prompt">[[+spf-comments-prompt]]:</div>

<div class = "spf_textarea">
<textarea name="comments" rows="[[+spf-text-rows]]" cols="[[+spf-text-cols]]"></textarea>
</div>

<div class = "spf_buttons"><input type="submit" name="s" value="[[+spf-submit]]" />&nbsp;

[[+spf-reset]]</div>

</form>
</div>