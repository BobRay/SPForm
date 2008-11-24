
<div id="spf_form">

<form action="[[~[[*id]]]]" method="post" onsubmit="return checkform(this);">

  [[+useMouseOrKeyboard1]]
  [[+useMouseOrKeyboard2]]

  [[+useHiddenField]]

  [[+useTimer]]

  [[+cookie_message]]

 <div class = "spf_recipient">[[+recipient]]</div>

<div class="spf_input_pair">
<span class="spf_block_prompt"> [[+namePrompt]]: </span>
<span class="spf_normal_input"><input type="text" id="name" name="name" size="30" /></span>
</div>

<div class="spf_input_pair">
<span class="spf_block_prompt"> [[+emailPrompt]]: </span>
<span class="spf_normal_input"><input type="text" id="email" name="email" size="30" /></span><br />
</div>

<div class="spf_input_pair">
<span class="spf_block_prompt">[[+subjectPrompt]]: </span>
<span class="spf_normal_input"><input type="text" id="subject" name="subject" size="30" /></span><br />
</div>

  [[+captcha]]

<div class="spf_block_prompt">[[+commentsPrompt]]:</div>

<div class = "spf_textarea">
<textarea name="comments" rows="[[+spTextRows]]" cols="[[+spTextCols]]"></textarea>
</div>

<div class = "spf_buttons"><input type="submit" name="s" value="[[+spfSubmit]]" />&nbsp;

[[+spfReset]]</div>

</form>
</div>