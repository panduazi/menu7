<?php
   if (isset($_GET['cust'])){
        $nmcust=$_GET['cust'];
		$alcust1=$_GET['al1'];
		$alcust2=$_GET['al2'];
		$alcust3=$_GET['al3'];
		$telp=$_GET['telp'];
		$piccust=$_GET['pic'];
		$sales=$_GET['sales'];
		}
   $hari_ini=date('Y-m-d');
   $tgl=date('Ymd');
?>
<!DOCTYPE html> 
<html> 
<head> 
	<meta charset="utf-8" />
	<title>List View</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head> 
<body> 
<div id="restau" data-role="page" data-add-back-btn="true">
	<div data-role="header"> 
		<h1> Customer Detail</h1>
	</div> 
	
	<div data-role="content">
	<div class="ui-grid-a" id="contact_infos">	
		<div class="ui-block-a">
		<? echo "<h1>". $nmcust."</h1>"; ?> 
		<p><strong> Alamat customer : </strong></p>
		<? echo $alcust1."</br>"; ?> 
		<? echo $alcust2; ?> 
		<? echo " Telp. ".$telp."</br>"; ?> 
        <? echo "<strong> Contack : </strong>".$piccust."</br><strong>Sales : </strong>".$sales; ?> 
		</div>		
		<div class="ui-block-b">
		<img src="01_maps.jpg" alt="plan jeanette"/>
		</div>
	</div><!-- /grid-a -->
	
	<div id="contact_buttons">	
		<a href="http://maps.google.fr/maps?q=jeannette+et+les+cycleux&hl=fr&sll=46.75984,1.738281&sspn=10.221882,18.764648&hq=jeannette+et+les+cycleux&t=m&z=13&iwloc=A" data-role="button" data-icon="maps"> Temukan Customer ini pada Google Maps </a> 	
	</div>	
	<hr/>
	
	<div id="notation">	
	<form>
	<label for="select-choice-0" class="select">
	<h2> Picup ini akan : </h2></label>
		<select name="note_utilisateur" id="note_utilisateur" data-native-menu="false" data-theme="c" >
		   <option value="one" class="one">Diambil</option>
		   <option value="two" class="two">Ditolak </option>
		   <option value="three" class="three">Tidak cukup waktu</option>
		</select>	
	</form>
	</div>


	<script type="text/javascript">

	$( '#restau' ).live( 'pageinit',function(event){
		var SelectedOptionClass = $('option:selected').attr('class');
		$('div.ui-select').addClass(SelectedOptionClass);
		
		$('#note_utilisateur').live('change', function(){	 
			$('div.ui-select').removeClass(SelectedOptionClass);
			
			SelectedOptionClass = $('option:selected').attr('class');
			$('div.ui-select').addClass(SelectedOptionClass);		
			
		 });
		
	  
	});

	</script>
	

	</div>


</div><!-- /page -->
</body>
</html>