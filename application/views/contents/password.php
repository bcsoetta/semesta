<style type="text/css">
  .reginfo {
    color: #d9534f;
  }
</style>

<div ui-view class="app-body" id="view">
  	<div class="row-col b-b">
    	<div class="col-md">
      		<div class="padding">
        		<div class="row-col box">
        			<!-- content -->
        			<div class="col-sm">
						<form ui-jp="parsley" action="<?php echo base_url('user/upassw');?>" method="POST">
							<div class="box">
								<input name="user_id" type="hidden" class="form-control" required value="<?php echo $_SESSION['user_id']; ?>">
								<div class="box-header">
									<h3>Form Password</h3>
									<small>Simpan dan rahasiakan password Anda</small>
								</div>
								<div class="box-body">
									<div class="form-group">
										<label>Masukkan Password</label>
										<p><?php echo form_error('password'); ?></p>
										<input name="password" type="password" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Konfirmasi Password</label>
										<p><?php echo form_error('passconf'); ?></p>
										<input name="passconf" type="password" class="form-control" required>
									</div>
								</div>
								<div class="p-a text-right">
									<input class="pull-left btn btn-outline b-black text-black" action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />
									<button type="submit" class="btn info">Submit</button>
								</div>
							</div>
						</form>
					</div>
					<!-- end content -->
        		</div>
    		</div>
		</div>
	</div>
</div>
