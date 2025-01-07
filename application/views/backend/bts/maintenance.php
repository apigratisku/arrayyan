<!-- PANEL HEADLINE -->
<div id="showmaintenance"></div>
<script type="text/javascript">

function stdata()
{
xmlhttp=new XMLHttpRequest();
xmlhttp.open("GET","<?php echo base_url('manage/bts/maintenance_proses'); ?>",false);
xmlhttp.send(null);
document.getElementById("showmaintenance").innerHTML=xmlhttp.responseText;
}
stdata();

setInterval(function(){
stdata();
},1000);
</script>