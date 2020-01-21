<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/moment/moment.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		startYear = new Date(new Date().getFullYear(), 0, 1);
		dateNow = Date.now();

		function convertDate(inputFormat) {
			function pad(s) { return (s < 10) ? '0' + s : s; }
			var d = new Date(inputFormat);
			return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
		}

		function dmyToYmd(dmyDate) {
			var ymdDate = dmyDate.split("/").reverse().join("-");
			return ymdDate;
		}

		sy = convertDate(startYear);
		dn = convertDate(dateNow);

		$('#form_filter #start_date').val(sy);
		$('#form_filter #end_date').val(dn);

		function displayTable(jalur = '0', start_date = sy, end_date = dn) {
			$('#table-pfpd-data').DataTable({
				"destroy": true,
				"ajax": {
					"url": 'pfpd_data',
					"type": "POST",
					"data": {
						"jalur": jalur,
						"start_date": start_date,
						"end_date": end_date
					},
					"dataSrc": ''
				},
				"columns": [
					{ "data": "Nama" },
					{ "data": "Jml PIB" },
					{ "data": "Jml SPTNP" },
					{ 
						"data": "Hit Rate", 
						"render": function ( data, type, row, meta ) {
					      return data + ' %';
					    }
					},
					{ "data": "BM Hit", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' ) },
					{ "data": "PDRI", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' ) },
					{ "data": "Denda", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' ) }
				],
				"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;

					// Remove the formatting to get integer data for summation
		            var intVal = function ( i ) {
		                return typeof i === 'string' ?
		                    i.replace(/[\$,]/g, '')*1 :
		                    typeof i === 'number' ?
		                        i : 0;
		            };

		            var numberFormat = $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' ).display;
		            var percentFormat = $.fn.dataTable.render.number( ',', '.', 2).display;

		            // Total over all pages
		            totalPib = api
		                .column( 1 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );

		            totalSptnp = api
		                .column( 2 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );

	                totalBm = api
		                .column( 4 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );

					totalPdri = api
						.column( 5 )
						.data()
						.reduce( function (a, b) {
						return intVal(a) + intVal(b);
						}, 0 );

					totalDenda = api
						.column( 6 )
						.data()
						.reduce( function (a, b) {
						return intVal(a) + intVal(b);
						}, 0 );

		            // Update footer
		            $( api.column( 1 ).footer() ).html(
		                totalPib
		            );

		            $( api.column( 2 ).footer() ).html(
		                totalSptnp
		            );

		            $( api.column( 3 ).footer() ).html(
		                percentFormat((totalSptnp / totalPib)*100) + ' %'
		            );

		            $( api.column( 4 ).footer() ).html(
						numberFormat(totalBm)
		            );

		            $( api.column( 5 ).footer() ).html(
						numberFormat(totalPdri)
					);

					$( api.column( 6 ).footer() ).html(
						numberFormat(totalDenda)
					);
				}
			});
		}
		
		$('#form_filter').submit(function(event) {
			event.preventDefault();
			var jalur = document.getElementById("form_filter")[0].value;
			var start_date = document.getElementById("form_filter")[1].value;
			var end_date = document.getElementById("form_filter")[2].value;

			var sd = dmyToYmd(start_date);
			var ed = dmyToYmd(end_date);

			displayTable(jalur, sd, ed);
		});

		displayTable();
	});
</script>