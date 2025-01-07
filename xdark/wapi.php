<?php
if(isset($_POST['kirim']))
{
echo "Sukses kirim";
}
?>

<form id="form1" enctype="application/x-www-form-urlencoded" name="form1" method="post" action="http://165.22.62.174:8000/send-message">
<p>
  <input name="number" type="text" />
</p>
  <label>
  <textarea name="message"></textarea>
  </label>

  <p>
    <input name="kirim" type="submit" value="Send" />
    </p>
</form>
<p>&nbsp;</p>
