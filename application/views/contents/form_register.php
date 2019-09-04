<style type="text/css">
  .reginfo {
    color: #d9534f;
  }
</style>

<div ui-view class="app-body" id="view">
  <!-- ############ PAGE START-->
  <div class="row-col b-b">
    <div class="col-md">
      <div class="padding">
        <div class="row">
          <div class="col-sm">
            <form ui-jp="parsley" action="<?php echo base_url('user/register');?>" method="POST">
              <div class="box">
                <div class="box-header">
                    <h3>Form Registrasi</h3>
                    <small>Pastikan data sudah benar, simpan username dan password Anda</small>
                  </div>
                <div class="box-body">
                  <div class="form-group">
                    <label>Username</label>
                    <?php echo form_error('username'); ?>
                    <input name="username" type="text" class="form-control" required>                        
                  </div>

                  <div class="row m-b">
                    <div class="col-sm-6 m-b">
                      <label>Masukkan Password</label>
                      <?php echo form_error('password'); ?>
                      <input name="password" type="password" class="form-control" required>   
                    </div>
                    <div class="col-sm-6">
                      <label>Konfirmasi Password</label>
                      <?php echo form_error('passconf'); ?>
                      <input name="passconf" type="password" class="form-control" required>      
                    </div>   
                  </div>
                  <div class="row m-b">
                    <div class="col-sm-6 m-b">
                      <label>Nama</label>
                      <input name="name" type="text" class="form-control" required>   
                    </div>
                    <div class="col-sm-6">
                      <label>NIP</label>
                      <?php echo form_error('nip'); ?>
                      <input name="nip" type="text" class="form-control" required>      
                    </div>   
                  </div>
                  <div class="row m-b">
                    <div class="col-sm-6 m-b">
                      <label>Role</label>
                      <select name="role" required class="form-control c-select">
                          <option value="default">Default</option>
                          <option value="administrator">Administrator</option>
                          <option value="kasi">Kasi</option>
                          <option value="kabid">Kabid</option>
                          <option value="ho">Kepala Kantor</option>
                      </select>     
                    </div> 
                    <div class="col-sm-6">
                      <label>Status</label>
                      <select required class="form-control c-select" name="status">
                          <option value="100">Aktif</option>
                          <option value="400">Non Aktif</option>
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