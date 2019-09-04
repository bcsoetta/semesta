<div ui-view class="app-body" id="view">
  	<div class="row-col b-b">
    	<div class="col-md">
      		<div class="padding">
        		<div class="row-col box">
        			<!-- content -->
        			<div class="col-sm-4">
						<div class="box-header">
							<h3 style="margin-bottom: .6rem; font-weight: bold;"><?php echo $gdata->guide_title; ?></h3>
							<small><?php echo $gdata->name; ?> - <?php echo $gdata->guide_date; ?></small>
						</div>
						<div class="box-body">
							<p class="m-a-0"><?php echo $gdata->guide_content; ?></p>
						</div>
					</div>
        			<!-- end of content -->
        		</div>
        		<div class="row-col m-t m-b">
        			<input class="pull-left btn btn-outline b-black dark" style="padding: 4px 6px; border-radius: .1rem; font-size: 12px;" action="action" onclick="window.history.go(-1); return false;" type="button" value="Previous" />
        		</div>
        	</div>
        </div>
    </div>
</div>