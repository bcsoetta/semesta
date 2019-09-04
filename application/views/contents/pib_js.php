<!-- echarts -->
<script src="<?php echo base_url('assets/libs/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/macarons.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/infographic.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/vintage.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/shine.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/roma.js'); ?>"></script>

<script type="text/javascript">

	var dom = document.getElementById("pibp");
	var myChartfd = echarts.init(dom);
	var app = {};
	option = null;
	var data = [{
	    name: '',
	    itemStyle: {
	        color: "#d87a80"
	    },
	    children: [{
	        name: 'MA',
	        value: 70,
	        itemStyle: {
    	        color: "#d87a80"
    	    },
	    }, {
	        name: 'MH',
	        value: 50,
	        itemStyle: {
    	        color: "#d87a80"
    	    },
	    }, {
	        name: 'MM',
	        value: 85,
	        itemStyle: {
    	        color: "#d87a80"
    	    },
	    }]
	}, {
	    name: '',
	    itemStyle: {
	        color: "#ffb980"
	    },
	    children: [{
	        name: 'MK',
	        value: 90,
	        itemStyle: {
    	        color: "#ffb980"
    	    },
	    }]
	}, {
	    name: '',
	    itemStyle: {
	        color: "#6cc788"
	    },
	    children: [{
	        name: 'HH',
	        value: 100,
	        itemStyle: {
	            color: "#6cc788"
	        },
	    }, {
	        name: 'HM',
	        value: 50,
	        itemStyle: {
	            color: "#6cc788"
	        },
	    }, {
	        name: 'HL',
	        value: 60,
	        itemStyle: {
	            color: "#6cc788"
	        },
	        
	    }]
	}, {
	    name: '',
	    itemStyle: {
	        color: "#2ec7c9"
	    },
	    children: [{
	        name: 'RH',
	        value: 100,
	        itemStyle: {
	            color: "#2ec7c9"
	        },
	    }]
	}, {
	    name: '',
	    itemStyle: {
	        color: "#7EDF71"
	    },
	    children: [{
	        name: 'HP',
	        value: 100,
	        itemStyle: {
	            color: "#7EDF71"
	        },
	    }, {
	        name: 'HT',
	        value: 40,
	        itemStyle: {
	            color: "#7EDF71"
	        },
	        
	    }]
	}];

	option = {
		textStyle: {
	    	fontSize: '10'
	    },
		tooltip: {
            trigger: 'item',
            formatter: "{b} {c}"
        },
	    series: {
	    	tooltip: {
	            trigger: 'item'
	        },
	        type: 'sunburst',
	        data: data,
	        radius: ['0%', '90%'],
	        itemStyle: {
	            color: '#ddd',
	            borderWidth: 0.5
	        },
	        label: {
	            rotate: 'radial'
	        }
	    }
	};

	if (option && typeof option === "object") {
	    myChartfd.setOption(option, true);
	}

	// Resize chart
	$(function () {

		// Resize chart on menu width change and window resize
		$(window).on('resize', resize);
		$(".menu-toggle").on('click', resize);

		// Resize function
		function resize() {
			setTimeout(function() {
				// Resize chart
				myChartfd.resize();
			}, 200);
		}
	});

</script>

<script type="text/javascript">
	var dom = document.getElementById("pibx");
	var myChartf = echarts.init(dom);
	var app = {};
	option = null;
	option = {
	    tooltip: {
	        trigger: 'axis'
	    },
	    legend: {
	        data:['Merah','Kuning','Hijau','RH','MITA'],
	        left: 1
	    },
	    grid: {
	        left: 2,
	        right: 15,
	        bottom: '3%',
	        containLabel: true
	    },
	    toolbox: {
	        feature: {
	            saveAsImage: {}
	        }
	    },
	    xAxis: {
	        type: 'category',
	        boundaryGap: false,
	        data: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul']
	    },
	    yAxis: {
	        type: 'value'
	    },
	    series: [
	        {
	            name:'Merah',
	            type:'line',
	            stack: '总量',
	            data:[120, 132, 101, 134, 90, 230, 210],
	            smooth: true
	        },
	        {
	            name:'Kuning',
	            type:'line',
	            stack: '总量',
	            data:[220, 182, 191, 234, 290, 330, 310],
	            smooth: true
	        },
	        {
	            name:'Hijau',
	            type:'line',
	            stack: '总量',
	            data:[150, 232, 201, 154, 190, 330, 410],
	            smooth: true
	        },
	        {
	            name:'RH',
	            type:'line',
	            stack: '总量',
	            data:[320, 332, 301, 334, 390, 330, 320],
	            smooth: true
	        },
	        {
	            name:'MITA',
	            type:'line',
	            stack: '总量',
	            data:[820, 932, 901, 934, 1290, 1330, 1320],
	            smooth: true
	        }
	    ]
	};

	if (option && typeof option === "object") {
	    myChartf.setOption(option, true);
	}

	// Resize chart
	$(function () {

		// Resize chart on menu width change and window resize
		$(window).on('resize', resize);
		$(".menu-toggle").on('click', resize);

		// Resize function
		function resize() {
			setTimeout(function() {
				// Resize chart
				myChartf.resize();
			}, 200);
		}
	});

</script>

<script type="text/javascript">
	var dom = document.getElementById("datax");
	var myChartx = echarts.init(dom);
	var app = {};
	option = null;
	option = {
	    xAxis: {
	        type: 'category',
	        data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', 'Day']
	    },
	    yAxis: {
	        type: 'value'
	    },
	    grid: {
	    	left: 45,
	    	right: 20
	    },
	    series: [{
	        data: [120, 200, 150, 80, 70, 110, 130, 300],
	        type: 'bar'
	    }]
	};
	;
	if (option && typeof option === "object") {
	    myChartx.setOption(option, true);
	}

	// Resize chart
	$(function () {

		// Resize chart on menu width change and window resize
		$(window).on('resize', resize);
		$(".menu-toggle").on('click', resize);

		// Resize function
		function resize() {
			setTimeout(function() {
				// Resize chart
				myChartx.resize();
			}, 200);
		}
	});

</script>


<script type="text/javascript">
	var dom = document.getElementById("dataz");
	var myChart = echarts.init(dom);
	var app = {};
	option = null;
	option = {
	    tooltip : {
	        trigger: 'axis',
	        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
	            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
	        },
	        formatter: function (params) {
	            var tar;
	            if (params[1].value != '-') {
	                tar = params[1];
	            }
	            else {
	                tar = params[0];
	            }
	            return tar.name + '<br/>' + tar.seriesName + ' : ' + tar.value;
	        }
	    },
	    legend: {
	        data:['支出','收入']
	    },
	    grid: {
	        bottom: '3%',
	        left: 20,
		    right: 20,
	        containLabel: true
	    },
	    xAxis: {
	        type : 'category',
	        splitLine: {show:false},
	        data :  function (){
	            var list = [];
	            for (var i = 1; i <= 11; i++) {
	                list.push('11月' + i + '日');
	            }
	            return list;
	        }()
	    },
	    yAxis: {
	        type : 'value'
	    },
	    series: [
	        {
	            name: '辅助',
	            type: 'bar',
	            stack: '总量',
	            itemStyle: {
	                normal: {
	                    barBorderColor: 'rgba(0,0,0,0)',
	                    color: 'rgba(0,0,0,0)'
	                },
	                emphasis: {
	                    barBorderColor: 'rgba(0,0,0,0)',
	                    color: 'rgba(0,0,0,0)'
	                }
	            },
	            data: [0, 900, 1245, 1530, 1376, 1376, 1511, 1689, 1856, 1495, 1292]
	        },
	        {
	            name: '收入',
	            type: 'bar',
	            stack: '总量',
	            label: {
	                normal: {
	                    show: true,
	                    position: 'top'
	                }
	            },
	            data: [900, 345, 393, '-', '-', 135, 178, 286, '-', '-', '-']
	        },
	        {
	            name: '支出',
	            type: 'bar',
	            stack: '总量',
	            label: {
	                normal: {
	                    show: true,
	                    position: 'bottom'
	                }
	            },
	            data: ['-', '-', '-', 108, 154, '-', '-', '-', 119, 361, 203]
	        }
	    ]
	};
	
	if (option && typeof option === "object") {
	    myChart.setOption(option, true);
	}

	// Resize chart
	$(function () {

		// Resize chart on menu width change and window resize
		$(window).on('resize', resize);
		$(".menu-toggle").on('click', resize);

		// Resize function
		function resize() {
			setTimeout(function() {
				// Resize chart
				myChart.resize();
			}, 200);
		}
	});

</script>