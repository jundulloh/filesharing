<div style="margin-top: 1.2em;">

	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3>New Filesharing Users</h3>
					<?php 
						$attr = array('id' => 'new_member');
						echo form_open('form/save_member', $attr) 
					?>
						<div class="form-group">
							<label>First Name</label>
							<input type="text" name="firstname" id="firstname" class="form-control">
						</div>
						<div class="form-group">
							<label> Last name</label>
							<input type="text" name="lastname" id="lastname" class="form-control">
						</div>
						<div class="form-group">
							<label>E-mail</label>
							<input type="email" name="email" id="email" class="form-control">
						</div>
						<div class="form-group">
							<label>handphone Number</label>
							<input type="text" name="handphone" id="handphone" class="form-control">
						</div>
						<div class="form-group">
							<button class="btn btn-primary btn-block" type="submit"> Save New User</button>
						</div>

						<div class="progress">
							<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
								<span class="sr-only">0% Complete</span>
							</div>
						</div>
					
					</form>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-body">
					<h3>New Filesharing Admin</h3>
					<?php 
						$attr = array('id' => 'new_admin');
						echo form_open('form/save_admin', $attr) 
					?>
						<div class="form-group">
							<label>First Name</label>
							<input type="text" name="firstname" id="firstname" class="form-control">
						</div>
						<div class="form-group">
							<label> Last name</label>
							<input type="text" name="lastname" id="lastname" class="form-control">
						</div>
						<div class="form-group">
							<label>E-mail</label>
							<input type="email" name="email" id="email" class="form-control">
						</div>
						<div class="form-group">
							<label>handphone Number</label>
							<input type="text" name="handphone" id="handphone" class="form-control">
						</div>
						<div class="form-group">
							<button class="btn btn-primary btn-block" type="submit"> Save New Admin</button>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$('form#new_member').on('submit', function(event){
			event.preventDefault();
			var link = $(this).attr('action');
			var form = document.querySelector('form');
			var formData = $(this).serializeArray();
			$.post(link, formData)
			.done(function(data){
				console.log(data)
				alert('data disimpan');
			})
		})
	})
</script>