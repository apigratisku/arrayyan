<html>
<head>
<title></title>
<!-- Select2 CSS --> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> 

<!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 

<!-- Select2 JS --> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
$(document).ready(function(){
 
  // Initialize select2
  $("#selUser").select2();

  // Read selected option
  $('#but_read').click(function(){
    var username = $('#selUser option:selected').text();
    

  });
});
</script>

</head>
<body>
<!-- Dropdown --> 
<select id='selUser' style='width: 200px;'>
     <option value='0'>Select User</option> 
     <option value='1'>Yogesh singh</option> 
     <option value='2'>Sonarika Bhadoria</option> 
     <option value='3'>Anil Singh</option> 
     <option value='4'>Vishal Sahu</option> 
     <option value='5'>Mayank Patidar</option> 
     <option value='6'>Vijay Mourya</option> 
     <option value='7'>Rakesh sahu</option> 
</select>

<input type='button' value='Seleted option' id='but_read'>

<br/>
<div id='result'></div>
</body>
</html>
