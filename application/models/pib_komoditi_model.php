<?php

class Pib_komoditi_model extends CI_Model {

	private function GetDataHs($sta, $end)
	{
		$query = $this->db->query("
			SELECT
				c.kode,
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
			FROM db_semesta.fact_pib_hs a
			INNER JOIN db_semesta.dim_date b ON
				a.tgl_pib = b.id
			INNER JOIN db_patops.hs_code c ON
				a.hs = c.id
			WHERE
				b.date BETWEEN '$sta' AND '$end'
			GROUP BY
				a.hs
		");

		return $query->result();
	}

	private function GetDataHsMonthly($sta, $end)
	{
		$query = $this->db->query("
			SELECT
				c.kode,
				b.year,
				b.month,
				SUM(a.nilai_pabean_idr) nilai,
				SUM(a.bm) bm,
				SUM(a.ppn) ppn,
				SUM(a.pph) pph,
				SUM(a.ppnbm) ppnbm
			FROM db_semesta.fact_pib_hs a
			INNER JOIN db_semesta.dim_date b ON
				a.tgl_pib = b.id
			INNER JOIN db_patops.hs_code c ON
				a.hs = c.id
			WHERE
				b.date BETWEEN '$sta' AND '$end'
			GROUP BY
				a.hs,
				b.year,
				b.month
		");

		return $query->result();
	}

	public function ChartsHs($sta='2020-01-01', $end='2020-12-31')
	{
		$chartOptions = [];

		// Get data
		$periods = $this->ListMonth($sta, $end);
		$sumHs = $this->GetDataHs($sta, $end);
		$sumHsMonth = $this->GetDataHsMonthly($sta, $end);

		// Prepare nilai pabean HS chart options
		$pieHsNilai = $this->PreparePieData($sumHs, "nilai");
		$explicitHsNilai = $pieHsNilai["legend"]["data"];
		if (($key = array_search("lainnya", $explicitHsNilai)) !== false) {
			unset($explicitHsNilai[$key]);
		}
		$stackHsNilai = $this->PrepareStackHsNilai($sumHsMonth, "nilai", $periods, $explicitHsNilai);

		// Prepare bea masuk HS chart options
		$pieHsBm = $this->PreparePieData($sumHs, "bm");
		$explicitHsBm = $pieHsBm["legend"]["data"];
		if (($key = array_search("lainnya", $explicitHsBm)) !== false) {
			unset($explicitHsBm[$key]);
		}
		$stackHsBm = $this->PrepareStackHsNilai($sumHsMonth, "bm", $periods, $explicitHsBm);

		// Prepare HS table data
		$tableHs = $this->PrepareHsTable($sumHs);

		$chartOptions["pieHsNilai"] = $pieHsNilai;
		$chartOptions["stackHsNilai"] = $stackHsNilai;
		$chartOptions["pieHsBm"] = $pieHsBm;
		$chartOptions["stackHsBm"] = $stackHsBm;
		$chartOptions["tableHs"] = $tableHs;

		return $chartOptions;
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

	private function PreparePieData($sumHs, $dataType)
	{
		if ($dataType == 'nilai') {
			$chartName = "Nilai Pabean";
		} else if ($dataType == 'bm') {
			$chartName = "Bea Masuk";
		}

		$sumAll = 0;
		$sumOther = 0;
		$dataValues = [];
		$dataLabels = [];

		foreach ($sumHs as $key => $value) {
			$sumAll += (float)$value->$dataType;
		}

		foreach ($sumHs as $key => $value) {
			$hsValue = round((float)$value->$dataType / 1000000000,2,PHP_ROUND_HALF_UP);
			$part = $hsValue / ($sumAll / 1000000000);
			if ($part > 0.01) {
				$hsValues[(string)$value->kode] = $hsValue;
			} else {
				$sumOther += $hsValue;
			}
		}
		arsort($hsValues);
		$hsValues['lainnya'] = round($sumOther,2,PHP_ROUND_HALF_UP);

		foreach ($hsValues as $key => $value) {
			$dataValue = [
				"value" => $value,
				"name" => $key
			];
			array_push($dataValues, $dataValue);
			array_push($dataLabels, $key);
		}

		$chartOptions = $this->PreparePieChart($chartName, $dataLabels, $dataValues);

		return $chartOptions;
	}

	private function PrepareStackHsNilai($sumHsMonth, $dataType, $periods, $explicitHs)
	{
		if ($dataType == "nilai") {
			$yAxisName = "Nilai Pabean (miliar Rp)";
		} else if ($dataType == "bm") {
			$yAxisName = "Bea Masuk (miliar Rp)";
		}
		
		$data = [];
		foreach ($explicitHs as $hs) {
			$data[$hs] = array_fill(0, count($periods), 0);
		}
		$data["lainnya"] = array_fill(0, count($periods), 0);

		foreach ($sumHsMonth as $key => $value) {
			$monthIdx = array_search([$value->year, $value->month], $periods);
			if (in_array($value->kode, $explicitHs)) {
				$data[$value->kode][$monthIdx] = round((float)$value->$dataType / 1000000000,2,PHP_ROUND_HALF_UP);
			} else {
				$data["lainnya"][$monthIdx] += (float)$value->$dataType / 1000000000;
			}
		}

		foreach ($data["lainnya"] as $key => $value) {
			$data["lainnya"][$key] = round($value,2,PHP_ROUND_HALF_UP);
		}

		$chartOptions = $this->PrepareStackChart($periods, $data, $yAxisName);

		return $chartOptions;
	}

	private function PreparePieChart($chartName, $dataLabels, $dataValues)
	{
		$chartOptions = [
			'tooltip' => [
				'trigger' => 'item',
				'formatter' => '{a} <br/>{b} : {c} ({d}%)'
			],
			'grid' => [
				'top' => 0,
				'bottom' => 0
			],
			'legend' => [
				'show' => false,
				'bottom' => 0,
				'data' => $dataLabels,
				'textStyle' => [
					'fontSize' => 10
				]
			],
			'series' => [
				[
					'name' => $chartName,
					'type' => 'pie',
					'bottom' => 30,
					'selectedMode' => 'single',
					'radius' => [0, '75%'],
					'startAngle' => 180,
					'data' => $dataValues
				]
			]
		];

		return $chartOptions;
	}

	private function PrepareStackChart($periods, $dataValues, $yAxisName)
	{
		$xLabels = [];
		foreach ($periods as $key => $value) {
			$label = implode('-', $value);
			array_push($xLabels, $label);
		}

		$dataSeries = [];
		foreach ($dataValues as $key => $value) {
			$data = [
				'name' => $key,
				'type' => 'line',
				'stack' => 'Nilai Pabean',
				'areaStyle' => [],
				'data' => $value
			];

			array_push($dataSeries, $data);
		}

		$dataLabels = [];
		foreach ($dataValues as $key => $value) {
			array_push($dataLabels, (string)$key);
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
			'legend' => [
				'bottom' => 0,
				'show' => true,
				'data' => $dataLabels
			],
			'grid' => [
				'top' => 10,
				'bottom' => '30%',
				'left' => 75
			],
			'xAxis' => [
				[
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 30,
					'type' => 'category',
					'boundaryGap' => false,
					'data' => $xLabels
				]
			],
			'yAxis' => [
				[
					'name' => $yAxisName,
					'nameLocation' => 'center',
					'nameGap' => 60,
					'type' => 'value'
				]
			],
			'series' => $dataSeries
		];

		return $chartOptions;
	}

	private function PrepareHsTable($sumHs)
	{
		$dataTable = [];
		foreach ($sumHs as $key => $value) {
			$nilai = round((float)$value->nilai / 1000000,2,PHP_ROUND_HALF_UP);
			$bm = round((float)$value->bm / 1000000,2,PHP_ROUND_HALF_UP);
			$ppn = round((float)$value->ppn / 1000000,2,PHP_ROUND_HALF_UP);
			$pph = round((float)$value->pph / 1000000,2,PHP_ROUND_HALF_UP);
			$ppnbm = round((float)$value->ppnbm / 1000000,2,PHP_ROUND_HALF_UP);
			$bm_dp = round((float)$value->bm_dp / 1000000,2,PHP_ROUND_HALF_UP);
			$ppn_dp = round((float)$value->ppn_dp / 1000000,2,PHP_ROUND_HALF_UP);
			$pph_dp = round((float)$value->pph_dp / 1000000,2,PHP_ROUND_HALF_UP);
			$ppnbm_dp = round((float)$value->ppnbm_dp / 1000000,2,PHP_ROUND_HALF_UP);
			$bm_tangguh = round((float)$value->bm_tangguh / 1000000,2,PHP_ROUND_HALF_UP);
			$ppn_tangguh = round((float)$value->ppn_tangguh / 1000000,2,PHP_ROUND_HALF_UP);
			$pph_tangguh = round((float)$value->pph_tangguh / 1000000,2,PHP_ROUND_HALF_UP);
			$ppnbm_tangguh = round((float)$value->ppnbm_tangguh / 1000000,2,PHP_ROUND_HALF_UP);
			$bm_bebas = round((float)$value->bm_bebas / 1000000,2,PHP_ROUND_HALF_UP);
			$ppn_bebas = round((float)$value->ppn_bebas / 1000000,2,PHP_ROUND_HALF_UP);
			$pph_bebas = round((float)$value->pph_bebas / 1000000,2,PHP_ROUND_HALF_UP);
			$ppnbm_bebas = round((float)$value->ppnbm_bebas / 1000000,2,PHP_ROUND_HALF_UP);

			$dataHs = [
				"hs" => $value->kode,
				"jml_pib" => $value->jml_pib,
				"nilai" => $nilai,
				"bm" => $bm,
				"ppn" => $ppn,
				"pph" => $pph,
				"ppnbm" => $ppnbm,
				"bm_bebas" => $bm_bebas,
				"ppn_bebas" => $ppn_bebas,
				"pph_bebas" => $pph_bebas,
				"ppnbm_bebas" => $ppnbm_bebas,
				"bm_tangguh" => $bm_tangguh,
				"ppn_tangguh" => $ppn_tangguh,
				"pph_tangguh" => $pph_tangguh,
				"ppnbm_tangguh" => $ppnbm_tangguh,
				"bm_dp" => $bm_dp,
				"ppn_dp" => $ppn_dp,
				"pph_dp" => $pph_dp,
				"ppnbm_dp" => $ppnbm_dp
			];
			array_push($dataTable, $dataHs);
		}

		return $dataTable;
	}

}