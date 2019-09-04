<style type="text/css">
	.btn-update, .btn-publish-edit, .btn-publish-info {
		border-radius: 2px;
	    padding: 5px 8px;
	    font-size: 11.5px;
	    color: #fff;
	    background-color: #5290BE;
	    cursor: pointer;
	    display: inline-block;
	    margin-right: 2px;
	}

	.btn-publish-info {
		background-color: #08d94363;
		color: #000000;
		display: none;
	}

	.btn-update {
		background-color: #5290BE;
	}

	.btn-publish-edit {
		background-color: #9A3C51;
	}

	@media screen and (max-width: 767px) {
		.mobile-space {margin-top:10px;}
	}
</style>

<div ui-view class="app-body" id="view">
  	<div class="row-col b-b">
    	<div class="col-md">
      		<div class="padding">
      			<div class="row-col m-b-sm mobile-space">
      				<h6>Text Editor</h6>
					<p>Menulis dengan singkat, padat dan jelas.</p>
					<div class="btn-update"><i class="fa fa-pencil"></i> &nbsp; Publish</div>
					<div class="btn-publish-edit"><i class="fa fa-pencil"></i> &nbsp; Draft</div>
					<div class="btn-publish-info pull-right"> &nbsp; Successfully published</div>
      			</div>
				<div class="row-col box" style="margin-top: 1rem; margin-bottom: .5rem;">
					<input type="text" class="form-control" id="guide_title" value="<?php echo $gdata->guide_title?>" style="padding-left: 9px;">
					<input name="gid" id="gid" type="hidden" value="<?php echo $gdata->id; ?>">
				</div>
        		<div class="row-col">
        			<!-- content -->
					<div class="box m-b-md">
						<div id="summernote"><?php echo $gdata->guide_content?></div>
					</div>
        			<!-- end of content -->
        		</div>
        		<div class="row-col">
        			<input class="pull-left btn btn-outline b-black dark" style="padding: 4px 6px; border-radius: .1rem; font-size: 14px;" action="action" onclick="window.history.go(-1); return false;" type="button" value="Previous" />
        		</div>
        		
        	</div>
        </div>
    </div>
</div>