
<div id="spf_form">

<form action="[[~[[*id]]]]" method="post" onsubmit="return checkform(this);">
  <fieldset style="display:none">
     [[+spf-use-mouse-or-keyboard1]]
     [[+spf-use-mouse-or-keyboard2]]
  </fieldset>

  [[+spf-use-hidden-field]]

  [[+spf-use-timer]]

  [[+spf-cookie-message]]

 <div class="spf_recipient">[[+spf-recipient]]</div>

<div class="spf_input_pair">
<label for="name"><span class="spf_block_prompt"> [[+spf-name-prompt]]: </span></label>
<span class="spf_normal_input"><input type="text" id="name" name="name" size="30" /></span>
</div>

<div class="spf_input_pair">
<label for="email"><span class="spf_block_prompt"> [[+spf-email-prompt]]: </span></label>
<span class="spf_normal_input"><input type="text" id="email" name="email" size="30" /></span><br />
</div>

<div class="spf_input_pair">
<label for="subject"><span class="spf_block_prompt">[[+spf-subject-prompt]]: </span></label>
<span class="spf_normal_input"><input type="text" id="subject" name="subject" size="30" /></span><br />
</div>

  [[+spf-captcha-stuff]]

<div class="spf_block_prompt">[[+spf-comments-prompt]]:</div>

<div class="spf_textarea">
<label for="comments">
<textarea id="comments" name="comments" rows="[[+spf-text-rows]]" cols="[[+spf-text-cols]]"></textarea></label>
</div>

<div class="spf_buttons"><input type="submit" name="s" value="[[+spf-submit]]" />&nbsp;

[[+spf-reset]]</div>

</form>
</div>