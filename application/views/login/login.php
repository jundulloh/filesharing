<style type="text/css">
	.img-place
	{
		margin-top: 2em;
	}
</style>
<div class="row">
	<div class="col-md-6">
		<div class="img-place">
			<img src="<?php echo source_cdn('assets/images/fileshare.png') ?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="alert alert-warning">
			<span class="glyphicon glyphicon-remove-circle"></span>
			Password or something what is failure.
		</div>

		<div class="alert alert-success">
			<span class="glyphicon glyphicon-info-sign"></span>
			Password or something what is failure.
		</div>

		<?php echo form_open('login/authorize') ?>
			<div class="form-group">
				<label>Username</label>
				<input class="form-control" type="text" value="" required placeholder="Your Cplusco Username">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input class="form-control" type="password" value="" required placeholder="Your Password">
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-block btn-login" id="btn-login" type="submit"> Login </button>
			</div>
		</form>
		<div class="row">
			<div class="col-md-6"></div>
			<div class="col-md-6 text-right"><a href="#"> what this is? </a></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo source_cdn('spin/spin.js') ?>"></script>
<script type="text/javascript">
	$(function(){
		target = document.getElementById('btn-login');
		var spinner = new Spinner();

		$('form').on('submit', function(event){
			event.preventDefault();
				// new Spinner().spin(target);
				spinner.spin(target);
			setTimeout(function(){
				spinner.stop();
			},2000)
		})
	})
</script>