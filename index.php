<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php include('header.php'); ?>

<body>

<form action="submit.php" method="post">
	<table border="0" align="center" cellpadding="2" cellspacing="0">
		<tr>
		<td>How would you rate our interaction?</td>
		<td><select name="their_rate">
		<option value=""></option>
		<?php
		for($i = 1; $i<6; $i++){
			echo '<option value="'.$i.'">'.$i.'</option>';
		}
		?>
		</select></td>
		</tr>
		
		<tr>
		<td>How do you think I would rate our interaction?</td>
		<td><select name="their_predicted_rate">
		<option value=""></option>
		<?php
		for($i = 1; $i<6; $i++){
			echo '<option value="'.$i.'">'.$i.'</option>';
		}
		?>
		</select></td>
		</tr>
		
		<tr>
		<td>Describe our interaction in one sentence.<br></td>
		<td><input type="text" name="description"></td>
		</tr> 
		      
		<tr>
		<td><input type="submit"></td>
		</tr>
	</table>
</form>

</body>
</html>
