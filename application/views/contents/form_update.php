<div ui-view class="app-body" id="view">
  <!-- ############ PAGE START-->
  <div class="row-col b-b">
    <div class="col-md">
      <div class="padding">
        <div class="row">
          <div class="col-sm">
            <form ui-jp="parsley" action="<?php echo base_url('user/update_process');?>" method="POST">
              <div class="box">
                <div class="box-header"> 
                  <h3>Form Update</h3>
                  <small>Pastikan data sudah benar, simpan username dan password Anda</small>
                </div>
                <div class="box-body">
                  <input name="user_id" type="hidden" class="form-control" required value="<?php echo $udata->user_id; ?>">
                  <div class="form-group">
                    <label>Username</label>
                    <input name="username" type="text" class="form-control" required value="<?php echo $udata->username; ?>">
                  </div>
                  <div class="row m-b">
                    <div class="col-sm-6">
                      <label>Masukkan password baru</label>
                      <input name="password" type="password" class="form-control" required disabled>   
                    </div>
                    <div class="col-sm-6">
                      <label>Konfirmasi password</label>
                      <input name="passconf" type="password" class="form-control" required disabled>      
                    </div>   
                  </div>
                  <div class="row m-b">
                    <div class="col-sm-6">
                      <label>Nama</label>
                      <input name="name" type="text" class="form-control" required value="<?php echo $udata->name; ?>">   
                    </div>
                    <div class="col-sm-6">
                      <label>NIP</label>
                      <input name="nip" type="text" class="form-control" required value="<?php echo $udata->nip; ?>">      
                    </div>   
                  </div>
                  <div class="row m-b">
                    <div class="col-sm-6">
                      <label>Role</label>
                      <select name="role" required class="form-control c-select">
                          <option value="default" <?php if($udata->role=="default") echo "selected"; ?>>Default</option>
                          <option value="administrator" <?php if($udata->role=="administrator") echo "selected"; ?>>Administrator</option>
                          <option value="kasi" <?php if($udata->role=="kasi") echo "selected"; ?>>kasi</option>
                          <option value="kabid" <?php if($udata->role=="kabid") echo "selected"; ?>>kabid</option>
                          <option value="ho" <?php if($udata->role=="ho") echo "selected"; ?>>Kepala Kantor</option>
                      </select>     
                    </div> 
                    <div class="col-sm-6">
                      <label>Status</label>
                      <select required class="form-control c-select" name="status">
                          <option value="100" <?php if($udata->status=="100") echo "selected"; ?>>Aktif</option>
                          <option value="400" <?php if($udata->status=="400") echo "selected"; ?>>Non Aktif</option>
                      </select>  
                    </div>  
                  </div>
                  <div class="checkbox">
                    <label class="ui-check">
                      <input type="checkbox" name="check" checked required="true"><i></i> Saya setuju dengan <a href="#" class="text-info">syarat dan ketentuan</a> yang berlaku.
                    </label>
                  </div>
                </div>
                <div class="p-a text-right">
                  <input class="pull-left btn btn-outline b-black text-black" action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />
                  <button type="submit" class="btn info">Submit</button>
                </div>
              </div>
            </form>
          </div>

      </div>
    </div>
    </div>
  </div>
</div>