<div class="alert alert-info"><span class="glyphicon glyphicon-info-sign"></span> Information about file <br></div>	
<div class="list-group">
	<div class="list-group-item">File Name : <strong> <?php echo $file['file_name'] ?> </strong></div>
	<div class="list-group-item">File Size : <strong> <?php echo $file['file_size'] ?> Kb </strong></div>
</div>

<?php 
	$attr_form = array('id' => 'share-form');
	echo form_open('file_controller/share', $attr_form);
?>
<div class="list-group">
	<a href="#" class="list-group-item active"> Share With? </a>
<?php 
	foreach ($users as $key => $value) {
?>
		<label class="list-group-item ">
			<input type="checkbox" name="share-item[]" id="share-item-<?php echo $key ?>" class="share-item" value="<?php echo $value['idUsers'] ?>"> <?php echo $value['fname'].' '.$value['lname'] ?>
		</label>

<?php } ?>
</div>
<div class="form-group">
	<input type="hidden" name="idFile" value="<?php echo $file['idFile'] ?>">
	<button class="btn btn-info btn-block btn-submit-share" type="submit" name="btn-share"> Share Now!</button>
</div>
</form>