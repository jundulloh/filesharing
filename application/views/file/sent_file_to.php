<h3>Sent File to <?php echo $user['fname'] ?></h3>
<?php echo form_open('file_controller/send_to/'.$user['idUsers'], array('id' => 'form_uploadfile')) ?>
  	<input type="file"  name="fileupload" id="fileupload" class="fileupload on-hide sr-only" multiple>
</form>

<div class="list-group list-queue-upload"></div>

