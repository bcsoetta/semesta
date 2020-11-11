<?php

class Pib_importir_detail_model extends CI_Model {
	// Importir Description
	public function GetImportirDescription($id)
	{
		$sql = "
			SELECT *
			FROM db_semesta.dim_pengguna_jasa a
			WHERE
				a.id = $id
		";
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result;
	}

	// Fact importir
	public function GetDataImportir($id, $sta='2020-01-01', $end='2020-12-31')
	{
		$periods = $this->ListMonth($sta, $end);

		$dates = [
			'sta' => $sta,
			'end' => $end
		];
		foreach ($dates as $key => $value) {
			$date = date_create($value);
			date_sub($date,date_interval_create_from_date_string("1 year"));
			$dateString = date_format($date,"Y-m-d");
			$datesBefore[$key] = $dateString;
		}

		// Bar chart nilai pabean dan BM
		$dataMonthCurrent = $this->GetDataMonthly($id, $sta, $end);
		$dataMonthBefore = $this->GetDataMonthly($id, $datesBefore['sta'], $datesBefore['end']);
		$data['barNilai'] = $this->PrepareBarChart($dataMonthCurrent, $dataMonthBefore, $periods, 'nilai');
		$data['barBm'] = $this->PrepareBarChart($dataMonthCurrent, $dataMonthBefore, $periods, 'bm');

		// Chart HS
		$dataHs = $this->GetDataHs($id, $sta, $end);
		$data['pieHsNilai'] = $this->PreparePieChart($dataHs, 'nilai');
		$data['pieHsBm'] = $this->PreparePieChart($dataHs, 'bm');
		$data['tableHs'] = $dataHs;

		// Chart jalur
		$dataJalur = $this->GetDataJalur($id, $sta, $end);
		$dataJalurBulan = $this->GetDataJalurBulan($id, $sta, $end);
		$data['pieJalurDok'] = $this->PreparePieChart($dataJalur, 'jml_pib', 'aggregate');
		$data['barJalurDok'] = $this->PrepareBarChartJalur($dataJalurBulan, $periods);
		$data['tableJalur'] = $dataJalur;
		
		// Chart fasilitas
		$dataFasilitas = $this->GetDataFasilitas($id, $sta, $end);
		$data['pieFasilitasNilai'] = $this->PreparePieChart($dataFasilitas, 'nilai');
		$data['pieFasilitasPungutan'] = $this->PreparePieChart($dataFasilitas, 'pungutan', 'aggregate');
		$data['tableFasilitas'] = $dataFasilitas;

		// Chart negara
		$dataNegara = $this->GetDataNegara($id, $sta, $end);
		$data['mapNegaraNilai'] = $this->PrepareMapChart($dataNegara, "nilai");
		$data['tableNegara'] = $dataNegara;

		return $data;
	}

	private function ListMonth($sta, $end)
	{
		$yearMonths = [];
		$start = (new DateTime($sta))->modify('first day of this month');
		$end = (new DateTime($end))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period = new DatePeriod($start, $interval, $end);

		foreach ($period as $dt) {
			$year = $dt->format("Y");
			$month = $dt->format("m");
			$yearMonth = [$year, $month];
			array_push($yearMonths, $yearMonth);
		}
		return $yearMonths;
	}

	// Monthly summary
	private function GetDataMonthly($id, $sta, $end)
	{
		$query = $this->db->query("
			SELECT
				b.year,
				b.month,
				SUM(a.nilai_pabean_idr) nilai,
				SUM(a.bm) bm
			FROM db_semesta.fact_pib_importir a
			INNER JOIN db_semesta.dim_date b ON
				a.tgl_pib = b.id
			WHERE
				a.importir = $id and
				b.date BETWEEN '$sta' AND '$end'
			GROUP BY
				1,2
		");

		$result = $query->result_array();
		return $result;
	}

	private function PrepareBarChart($dataMonthCurrent, $dataMonthBefore, $periods, $dataType)
	{
		if ($dataType == "nilai") {
			$yAxisName = "Nilai Pabean (miliar Rp)";
		} else if ($dataType == "bm") {
			$yAxisName = "Bea Masuk (juta Rp)";
		}

		$dataCurrent = $this->PrepareBarData($dataMonthCurrent, $periods, $dataType);
		$dataBefore = $this->PrepareBarData($dataMonthBefore, $periods, $dataType, 'before');

		$xLabels = [];
		foreach ($periods as $key => $value) {
			array_push($xLabels, $value[1]);
		}

		$chartOptions = [
			'tooltip' => [
				'trigger' => 'axis',
				'axisPointer' => [
					'type' => 'cross',
					'label' => [
						'backgroundColor' => '#6a7985'
					]
				]
			],
			'grid' => [
				'top' => 40,
				'bottom' => 40,
				'left' => 75,
				'right' => 15
			],
			'legend' => [
				'show' => true,
				'data' => [$dataBefore['label'], $dataCurrent['label']]
			],
			'xAxis' => [
				'name' => 'Bulan',
				'nameLocation' => 'center',
				'nameGap' => 30,
				'type' => 'category',
				'data' => $xLabels
			],
			'yAxis' => [
				'name' => $yAxisName,
				'nameLocation' => 'center',
				'nameGap' => 60,
				'type' => 'value'
			],
			'series' => [
				[
					'name' => $dataBefore['label'],
					'data' => $dataBefore['series'],
					'type' => 'bar',
					'barGap' => '0%'
				],
				[
					'name' => $dataCurrent['label'],
					'data' => $dataCurrent['series'],
					'type' => 'bar',
					'barGap' => '0%'
				]
			]
		];

		return $chartOptions;
	}

	private function PrepareBarData($dataMonth, $periods, $dataType, $state='current')
	{
		if ($dataType == "nilai") {
			$divisor = 1000000000;
		} else if ($dataType == "bm") {
			$divisor = 1000000;
		}

		$data['series'] = array_fill(0, count($periods), 0);
		foreach ($dataMonth as $key => $value) {
			$year = ($state == 'current') ? $value['year'] : $value['year']+1;
			$monthIdx = array_search([$year, $value['month']], $periods);
			$data['series'][$monthIdx] = round((float)$value[$dataType] / $divisor,2,PHP_ROUND_HALF_UP);
		}

		$staYear = $dataMonth[0]['year'];
		$endYear = (end($dataMonth))['year'];
		$data['label'] = ($staYear == $endYear) ? $staYear : $staYear . '-' . $endYear;

		return $data;
	}

	// Data HS
	private function GetDataHs($id, $sta, $end)
	{
		$sql = "
			SELECT
				c.id,
				c.kode label,
				SUM(a.jml_pib) jml_pib,
				SUM(a.nilai_pabean_idr) nilai,
				SUM(a.bm) bm,
				SUM(a.ppn) ppn,
				SUM(a.pph) pph,
				SUM(a.ppnbm) ppnbm,
				SUM(a.bm_dp) bm_dp,
				SUM(a.ppn_dp) ppn_dp,
				SUM(a.pph_dp) pph_dp,
				SUM(a.ppnbm_dp) ppnbm_dp,
				SUM(a.bm_tangguh) bm_tangguh,
				SUM(a.ppn_tangguh) ppn_tangguh,
				SUM(a.pph_tangguh) pph_tangguh,
				SUM(a.ppnbm_tangguh) ppnbm_tangguh,
				SUM(a.bm_bebas) bm_bebas,
				SUM(a.ppn_bebas) ppn_bebas,
				SUM(a.pph_bebas) pph_bebas,
				SUM(a.ppnbm_bebas) ppnbm_bebas
			FROM db_semesta.fact_pib_importir_hs a
			INNER JOIN db_semesta.dim_date b ON
				a.tgl_pib = b.id
			INNER JOIN db_patops.hs_code c ON
				a.hs = c.id
			WHERE
				b.date BETWEEN '$sta' AND '$end' and
				a.importir = $id
			GROUP BY
				c.id
		";

		$query = $this->db->query($sql);

		$result = $query->result();
		return $result;
	}

	// Data jalur
	private function GetDataJalur($id, $sta, $end)
	{
		$sql = "
			SELECT
				c.id,
				c.jalur,
				c.grup_jalur,
				SUM(a.jml_pib) jml_pib,
				SUM(a.nilai_pabean_idr) nilai
			FROM db_semesta.fact_pib_jalur_importir a
			INNER JOIN db_semesta.dim_date b ON
				a.tgl_pib = b.id
			INNER JOIN db_semesta.dim_pib_jalur c ON
				a.jalur = c.id
			WHERE
				b.date BETWEEN '$sta' AND '$end' AND
				a.importir = $id
			GROUP BY
				c.id
		";

		$query = $this->db->query($sql);

		$result = $query->result();
		return $result;
	}

	private function GetDataJalurBulan($id, $sta, $end)
	{
		$sql = "
			SELECT
				b.year,
				b.month,
				c.grup_jalur,
				SUM(a.jml_pib) jml_pib,
				SUM(a.nilai_pabean_idr) nilai
			FROM db_semesta.fact_pib_jalur_importir a
			INNER JOIN db_semesta.dim_date b ON
				a.tgl_pib = b.id
			INNER JOIN db_semesta.dim_pib_jalur c ON
				a.jalur = c.id
			WHERE
				b.date BETWEEN '$sta' AND '$end' AND
				a.importir = $id
			GROUP BY
				1,2,3
		";

		$query = $this->db->query($sql);

		$result = $query->result();
		return $result;
	}

	// Data fasilitas
	private function GetDataFasilitas($id, $sta, $end)
	{
		$sql = "
			SELECT
				c.id,
				c.ur_fasilitas label,
				SUM(a.jml_pib) jml_pib,
				SUM(a.nilai_pabean_idr) nilai,
				SUM(a.bm) bm,
				SUM(a.ppn) ppn,
				SUM(a.pph) pph,
				SUM(a.ppnbm) ppnbm,
				SUM(a.bm_dp) bm_dp,
				SUM(a.ppn_dp) ppn_dp,
				SUM(a.pph_dp) pph_dp,
				SUM(a.ppnbm_dp) ppnbm_dp,
				SUM(a.bm_tangguh) bm_tangguh,
				SUM(a.ppn_tangguh) ppn_tangguh,
				SUM(a.pph_tangguh) pph_tangguh,
				SUM(a.ppnbm_tangguh) ppnbm_tangguh,
				SUM(a.bm_bebas) bm_bebas,
				SUM(a.ppn_bebas) ppn_bebas,
				SUM(a.pph_bebas) pph_bebas,
				SUM(a.ppnbm_bebas) ppnbm_bebas
			FROM db_semesta.fact_pib_importir_fasilitas a
			INNER JOIN db_semesta.dim_date b ON
				a.tgl_pib = b.id
			INNER JOIN db_semesta.dim_pib_fasilitas c ON
				a.fasilitas = c.id
			WHERE
				b.date BETWEEN '$sta' AND '$end' and
				a.importir = $id
			GROUP BY
				c.id
		";

		$query = $this->db->query($sql);

		$result = $query->result();
		return $result;
	}

	// Data negara
	private function GetDataNegara($id, $sta, $end)
	{
		$sql = "
			SELECT
				c.id,
				c.nm_echarts label,
				SUM(a.jml_pib) jml_pib,
				SUM(a.nilai_pabean_idr) nilai
			FROM db_semesta.fact_pib_importir_negara_pemasok a
			INNER JOIN db_semesta.dim_date b ON
				a.tgl_pib = b.id
			INNER JOIN db_semesta.dim_negara c ON
				a.negara_pemasok = c.id
			WHERE
				b.date BETWEEN '$sta' AND '$end' and
				a.importir = $id
			GROUP BY
				c.id
		";

		$query = $this->db->query($sql);

		$result = $query->result();
		return $result;
	}

	private function PreparePieChart($data, $dataType, $chartType='total')
	{
		if ($dataType == 'nilai') {
			$chartName = "Nilai Pabean";
		} else if ($dataType == 'bm') {
			$chartName = "Bea Masuk";
		} else if ($dataType == "pungutan") {
			$chartName = "Pungutan";
		} else if ($dataType == "jml_pib") {
			$chartName = "Jml PIB";
		}

		if ($chartType == 'total') {
			$dataChart = $this->PreparePieData($data, $dataType);
			$dataAggregate = [
				'name' => 'Total ' . $chartName,
				'type' => 'pie',
				'top' => 20,
				'radius' => [0, '40%'],
				'label' => [
					'formatter' => '{c}',
					'position' => 'inner'
				],
				'labelLine' => [
					'show' => false
				],
				'data' => [
					[
						'value' => $dataChart['total'],
						'name' => 'total'
					]
				]
			];
		} else if ($chartType == 'aggregate') {
			if ($dataType == 'pungutan') {
				$dataChart = $this->PreparePieDataPungutan($data);
			} else if ($dataType == 'jml_pib') {
				$dataChart = $this->PreparePieDataJalur($data);
			}

			$dataAggregate = [
				'name' => 'Agregat ' . $chartName,
				'type' => 'pie',
				'top' => 20,
				'selectedMode' => 'single',
				'radius' => [0, '40%'],
				'startAngle' => 180,
				'data' => $dataChart['aggregate']
			];
		}

		$chartOptions = [
			'tooltip' => [
				'trigger' => 'item',
				'formatter' => '{a} <br/>{b} : {c} ({d}%)'
			],
			'legend' => [
				'show' => false,
				'bottom' => 0,
				'data' => $dataChart['labels'],
				'textStyle' => [
					'fontSize' => 10
				]
			],
			'series' => [
				[
					'name' => $chartName,
					'type' => 'pie',
					'top' => 20,
					'selectedMode' => 'single',
					'radius' => ['50%', '75%'],
					'startAngle' => 180,
					'data' => $dataChart['values']
				],
				$dataAggregate
			]
		];

		return $chartOptions;
	}

	private function PreparePieData($data, $dataType)
	{
		$sumAll = 0;
		$sumOther = 0;
		$dataChart = [
			'values' => [],
			'labels' => []
		];
		$dataLabels = [];

		foreach ($data as $key => $value) {
			$sumAll += (float)$value->$dataType;
		}
		$dataChart['total'] = round($sumAll / 1000000000,2,PHP_ROUND_HALF_UP);

		if ($sumAll > 0) {
			foreach ($data as $key => $value) {
				$dataValue = round((float)$value->$dataType / 1000000000,2,PHP_ROUND_HALF_UP);
				$part = $dataValue / ($sumAll / 1000000000);
				if ($part > 0.01) {
					$dataValues[(string)$value->label] = $dataValue;
				} else {
					$sumOther += $dataValue;
				}
			}
			arsort($dataValues);
			$dataValues['lainnya'] = round($sumOther,2,PHP_ROUND_HALF_UP);

			foreach ($dataValues as $key => $value) {
				$dataChartValue = [
					"value" => $value,
					"name" => $key
				];
				array_push($dataChart['values'], $dataChartValue);
				array_push($dataChart['labels'], $key);
			}
		}

		return $dataChart;
	}

	private function PreparePieDataPungutan($data)
	{
		$sumPungutan = [];
		$sumJnsPungutan = [];

		foreach ($data as $d) {
			foreach ($d as $key => $value) {
				if (!in_array($key, ['id', 'label', 'jml_pib', 'nilai'])) {
					if ($value > 0) {
						if (array_key_exists($key, $sumPungutan)) {
							$sumPungutan[$key] += $value;
						} else {
							$sumPungutan[$key] = $value;
						}
						
						$pungutanExplode = explode("_", $key);
						if (count($pungutanExplode) > 1) {
							if (array_key_exists($pungutanExplode[1], $sumJnsPungutan)) {
								$sumJnsPungutan[$pungutanExplode[1]] += $value;
							} else {
								$sumJnsPungutan[$pungutanExplode[1]] = $value;
							}
						} else {
							if (array_key_exists("bayar", $sumJnsPungutan)) {
								$sumJnsPungutan["bayar"] += $value;
							} else {
								$sumJnsPungutan["bayar"] = $value;
							}
						}
					}
				}
			}
		}

		$dataChart = [
			"values" => [],
			"aggregate" => [],
			"labels" => []
		];
		foreach ($sumPungutan as $key => $value) {
			$dataChartValue = [
				"value" => round((float)$value / 1000000000,2,PHP_ROUND_HALF_UP),
				"name" => $key
			];
			array_push($dataChart["values"], $dataChartValue);
			array_push($dataChart["labels"], $key);
		}
		foreach ($sumJnsPungutan as $key => $value) {
			$dataChartValue = [
				"value" => round((float)$value / 1000000000,2,PHP_ROUND_HALF_UP),
				"name" => $key
			];
			array_push($dataChart["aggregate"], $dataChartValue);
			array_push($dataChart["labels"], $key);
		}

		return $dataChart;
	}

	private function PreparePieDataJalur($data)
	{
		$dataChart = [
			"values" => [],
			"aggregate" => [],
			"labels" => []
		];

		$dataChartAggregates = [];

		foreach ($data as $key => $value) {
			$jml_pib = (int)$value->jml_pib;
			$jalur = $value->jalur;
			$grup_jalur = $value->grup_jalur;

			$dataChartValue = [
				"value" => $jml_pib,
				"name" => $jalur
			];
			array_push($dataChart["values"], $dataChartValue);
			array_push($dataChart["labels"], $jalur);

			if (array_key_exists($grup_jalur, $dataChartAggregates)) {
				$dataChartAggregates[$grup_jalur] += $jml_pib;
			} else {
				$dataChartAggregates[$grup_jalur] = $jml_pib;
			}
		}

		foreach ($dataChartAggregates as $key => $value) {
			$dataChartAggregate = [
				"value" => $value,
				"name" => $key
			];
			array_push($dataChart["aggregate"], $dataChartAggregate);
			array_push($dataChart["labels"], $key);
		}

		return $dataChart;
	}

	private function PrepareMapChart($data, $dataType)
	{
		$chartData = $this->PrepareMapData($data, $dataType);

		$chartOptions = [
			"tooltip" => [
				"trigger" => 'item'
			],
			"dataRange" => [
				"min" => 0,
				"max" => $chartData["maxValue"],
				"text" => ['High','Low'],
				"realtime" => false,
				"calculable" => true,
				"color" => ['orangered','yellow','lightskyblue']
			],
			"series" => [
				[
					"name" => 'Negara Pemasok',
					"type" => 'map',
					"mapType" => 'world',
					"roam" => true,
					"itemStyle" => [
						"emphasis" => [
							"label" => [
								"show" => true
							]
						]
					],
					"data" => $chartData["values"]
				]
			]
		];

		return $chartOptions;
	}

	private function PrepareMapData($data, $dataType)
	{
		$dataChart = [
			"values" => [],
			"maxValue" => 0
		];

		foreach ($data as $d) {
			$value = round((float)$d->$dataType / 1000000,2,PHP_ROUND_HALF_UP);
			$dataChartValue = [
				"name" => $d->label,
				"value" => $value
			];
			array_push($dataChart["values"], $dataChartValue);

			if ($value > $dataChart["maxValue"]) {
				$dataChart["maxValue"] = round($value,-3,PHP_ROUND_HALF_UP);
			}
		}

		return $dataChart;
	}

	private function PrepareBarChartJalur($data, $periods)
	{
		$chartData = $this->PrepareBarDataJalur($data, $periods);

		$chartOptions = [
			'tooltip' => [
				'trigger' => 'axis',
				'axisPointer' => [
					'type' => 'cross',
					'label' => [
						'backgroundColor' => '#6a7985'
					]
				]
			],
			"legend" => [
				"data" => $chartData["labels"]
			],
			"xAxis" => [
				'name' => 'Bulan',
				'nameLocation' => 'center',
				'nameGap' => 30,
				"type" => 'category',
				"data" => $chartData["xLabels"]
			],
			"yAxis" => [
				'name' => "Jumlah PIB",
				'nameLocation' => 'center',
				'nameGap' => 40,
				"type" => 'value'
			],
			"series" => $chartData["series"]
		];

		return $chartOptions;
	}

	private function PrepareBarDataJalur($data, $periods)
	{
		$dataCharts = [
			"series" => [],
			"labels" => [],
			"xLabels" => []
		];
		$dataSeries = [];

		foreach ($data as $key => $value) {
			// Prepare data series
			$grup_jalur = $value->grup_jalur;
			if (!array_key_exists($grup_jalur, $dataSeries)) {
				$dataSeries[$grup_jalur] = array_fill(0, count($periods), 0);
			}
			$monthIdx = array_search([$value->year, $value->month], $periods);
			$dataSeries[$grup_jalur][$monthIdx] = (int)$value->jml_pib;

			// Prepare data label
			if (!in_array($grup_jalur, $dataCharts["labels"])) {
				array_push($dataCharts["labels"], $grup_jalur);
			}
		}

		foreach ($dataSeries as $key => $value) {
			$series = [
				"name" => $key,
				"type" => 'bar',
				"stack" => 'jalur',
				"data" => $value
			];

			array_push($dataCharts["series"], $series);
		}

		foreach ($periods as $key => $value) {
			$xLabel = implode('-', $value);
			array_push($dataCharts["xLabels"], $xLabel);
		}

		return $dataCharts;

	}

}