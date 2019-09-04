<style type="text/css">
  .list-item {
    padding-left: 0;
  }
  .p-edit {
    color: #1F618D !important;
  }
  .guide_list {
    width: 95%;
  }
  .guide_light {
    margin-top: 0.05rem;
    font-size: 1rem;
  }
</style>

<div ui-view class="app-body" id="view">
  <!-- ############ PAGE START-->
  <div class="row-col b-b">
    <div class="col-md">
      <div class="padding">
        <div class="row-col box">
          <div class="col-sm-8 lt light">
            <div class="box-body"">
              <div class="input-group m-b">
                <input type="text" id="myInput" class="form-control" placeholder="masukkan nama">
                <span class="input-group-btn">
                  <button id="user_search_btn" class="btn white" type="button">Cari</button>
                </span>
              </div>
              <ul class="list inset m-a-0" id="myList"></ul>
              <div id="pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>