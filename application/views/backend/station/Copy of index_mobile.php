<!-- PANEL HEADLINE -->
<div id="showstation"></div>
<script type="text/javascript">

function stdata()
{
xmlhttp=new XMLHttpRequest();
xmlhttp.open("GET","<?php echo base_url('manage/station/station'); ?>",false);
xmlhttp.send(null);
document.getElementById("showstation").innerHTML=xmlhttp.responseText;
}
stdata();

setInterval(function(){
stdata();
},1000);
</script>