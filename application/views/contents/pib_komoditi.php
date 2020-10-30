<div ui-view class="app-body" id="view">
	<!-- ############ PAGE START ############ -->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<!-- Date filter -->
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-body">
							<form action="#" id="form_imp">
								<div class="col-sm-6 form-group">
								</div>
								<div class="col-sm-2 form-group">
									<div class='input-group date' id="start_date" name="start_date" ui-jp="datetimepicker" ui-options="{
											format: 'DD/MM/YYYY',
											icons: {
												time: 'fa fa-clock-o',
												date: 'fa fa-calendar',
												up: 'fa fa-chevron-up',
												down: 'fa fa-chevron-down',
												previous: 'fa fa-chevron-left',
												next: 'fa fa-chevron-right',
												today: 'fa fa-screenshot',
												clear: 'fa fa-trash',
												close: 'fa fa-remove'
											}
										}">
										<input type='text' class="form-control" id="start_date" name="start_date" placeholder="Tanggal Awal" />
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-sm-1 text-center">
									<label class="form-control-label">s.d.</label>
								</div>
								<div class="col-sm-2 form-group">
									<div class='input-group date' id="end_date" name="end_date" ui-jp="datetimepicker" ui-options="{
											format: 'DD/MM/YYYY',
											icons: {
												time: 'fa fa-clock-o',
												date: 'fa fa-calendar',
												up: 'fa fa-chevron-up',
												down: 'fa fa-chevron-down',
												previous: 'fa fa-chevron-left',
												next: 'fa fa-chevron-right',
												today: 'fa fa-screenshot',
												clear: 'fa fa-trash',
												close: 'fa fa-remove'
											}
										}">
										<input type='text' class="form-control" id="end_date" name="end_date" placeholder="Tanggal Akhir" />
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-sm-1">
									<button type="submit" class="btn rounded success">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<!-- Chart nilai pabean -->
				<div class="row-col box">
					
					<!-- Chart pie -->
					<div class="col-sm-5">
						<div class="box-header">
							<h3>Nilai Pabean</h3>
							<small class="block text-muted">Nilai pabean dalam miliar rupiah</small>
						</div>
						<div class="box-body">
							<div id="chart-pie-nilai" style="height: 50vh;"></div>
						</div>
					</div>

					<!-- Chart stack -->
					<div class="col-sm-7">
						<div class="box-header">
							<h3>&nbsp;</h3>
							<small class="block text-muted">Nilai pabean per bulan dalam miliar rupiah</small>
						</div>
						<div class="box-body">
							<div id="chart-stack-nilai" style="height: 50vh;"></div>
						</div>
					</div>
				</div>

				<!-- Chart bea masuk -->
				<div class="row-col box">
					
					<!-- Chart pie -->
					<div class="col-sm-5">
						<div class="box-header">
							<h3>Bea Masuk</h3>
							<small class="block text-muted">Bea masuk dalam miliar rupiah</small>
						</div>
						<div class="box-body">
							<div id="chart-pie-bm" style="height: 50vh;"></div>
						</div>
					</div>

					<!-- Chart stack -->
					<div class="col-sm-7">
						<div class="box-header">
							<h3>&nbsp;</h3>
							<small class="block text-muted">Bea masuk per bulan dalam miliar rupiah</small>
						</div>
						<div class="box-body">
							<div id="chart-stack-bm" style="height: 50vh;"></div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
					<div class="box">
						<div class="box-header">
						<h3>Nested Pie</h3>
						<small class="block text-muted">set multiple pies' centers and radii</small>
						</div>
						<div class="box-body">
						<div ui-jp="chart" ui-options="{
							tooltip : {
								trigger: 'item',
								formatter: '{a} <br/>{b} : {c} ({d}%)'
							},
							legend: {
								orient : 'vertical',
								x : 'left',
								data:['Direct','AD','Search','Mail','Affiliate','Video','Baidu','Google','Bing','Other']
							},
							calculable : false,
							series : [
								{
									name:'Source',
									type:'pie',
									selectedMode: 'single',
									radius : [0, 50],
									
									// for funnel
									x: '20%',
									width: '40%',
									funnelAlign: 'right',
									max: 1548,
									
									itemStyle : {
										normal : {
											label : {
												position : 'inner'
											},
											labelLine : {
												show : false
											}
										}
									},
									data:[
										{value:335, name:'Direct'},
										{value:679, name:'AD'},
										{value:1548, name:'Search', selected:true}
									]
								},
								{
									name:'Source',
									type:'pie',
									radius : [80, 100],
									
									// for funnel
									x: '60%',
									width: '35%',
									funnelAlign: 'left',
									max: 1048,
									
									data:[
										{value:335, name:'Direct'},
										{value:310, name:'Mail'},
										{value:234, name:'Affiliate'},
										{value:135, name:'Video'},
										{value:1048, name:'Baidu'},
										{value:251, name:'Google'},
										{value:147, name:'Bing'},
										{value:102, name:'Other'}
									]
								}
							]
						}" style="height:300px" >
						</div>
						</div>
					</div>
					</div>

					<div class="col-sm-6">
					<div class="box">
						<div class="box-header">
						<h3>Doughnut</h3>
						<small class="block text-muted">infographic style, extra content addition</small>
						</div>
						<div class="box-body" id="pie">
						<div ui-jp="chart" ui-options="{
							title: {
								text: 'It is Cool？',
								subtext: 'From Echarts',
								x: 'center',
								y: 'center',
								itemGap: 20,
								textStyle : {
									color : 'rgba(30,144,255,0.8)',
									fontSize : 20,
									fontWeight : 'bolder'
								}
							},
							tooltip : {
								show: true,
								formatter: '{a} <br/>{b} : {c} ({d}%)'
							},
							legend: {
								orient : 'vertical',
								x : $('#pie').width()/2 + 10,
								y : 25,
								itemGap:12,
								data:['68% Disagree','29% Agree','3% No idea']
							},
							series : [
								{
									name:'1',
									type:'pie',
									clockWise:false,
									radius : [105, 130],
									itemStyle : {
										normal: {
											label: {show:false},
											labelLine: {show:false}
										}
									},
									data:[
										{
											value:68,
											name:'68% Disagree'
										},
										{
											value:32,
											name:'invisible',
											itemStyle : {
												normal : {
													color: 'rgba(0,0,0,0)',
													label: {show:false},
													labelLine: {show:false}
												},
												emphasis : {
													color: 'rgba(0,0,0,0)'
												}
											}
										}
									]
								},
								{
									name:'2',
									type:'pie',
									clockWise:false,
									radius : [80, 105],
									itemStyle : {
										normal: {
											label: {show:false},
											labelLine: {show:false}
										}
									},
									data:[
										{
											value:29, 
											name:'29% Agree'
										},
										{
											value:71,
											name:'invisible',
											itemStyle : {
												normal : {
													color: 'rgba(0,0,0,0)',
													label: {show:false},
													labelLine: {show:false}
												},
												emphasis : {
													color: 'rgba(0,0,0,0)'
												}
											}
										}
									]
								},
								{
									name:'3',
									type:'pie',
									clockWise:false,
									radius : [55, 80],
									itemStyle : {
										normal: {
											label: {show:false},
											labelLine: {show:false}
										}
									},
									data:[
										{
											value:3, 
											name:'3% No idea'
										},
										{
											value:97,
											name:'invisible',
											itemStyle : {
												normal : {
													color: 'rgba(0,0,0,0)',
													label: {show:false},
													labelLine: {show:false}
												},
												emphasis : {
													color: 'rgba(0,0,0,0)'
												}
											}
										}
									]
								}
							]
						}" style="height:300px" >
						</div>
						</div>
					</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>