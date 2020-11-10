<?php

class Pib_importir_model extends CI_Model {

	public function GetImportirAll($value='')
	{
		$query = $this->db->query("
			SELECT
				imp.npwp,
				imp.nama,
				sum(d.jumlah_dok) jml_dok
			FROM (
				SELECT
					a.id,
					a.npwp,
					a.nama
				FROM db_semesta.dim_pengguna_jasa a
				INNER JOIN db_semesta.ref_pengguna_jasa b ON a.id = b.id_pengguna_jasa
				INNER JOIN db_semesta.dim_grup_pengguna_jasa c ON b.id_group = c.id
				WHERE c.grup = 'importir'
				GROUP BY a.id
			) imp
			LEFT JOIN db_semesta.fact_pib d ON imp.id = d.wp_imp
			GROUP BY imp.id
		");

		return $query->result();
	}

	public function GetDataImportir($sta, $end)
	{
		$sql = "
			SELECT
				c.id,
				c.nama,
				SUM(a.jml_pib) jml_pib,
				SUM(a.netto) netto,
				SUM(a.bruto) bruto,
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
			FROM db_semesta.fact_pib_importir a
			INNER JOIN db_semesta.dim_date b ON
				a.tgl_pib = b.id
			INNER JOIN db_semesta.dim_pengguna_jasa c ON
				a.importir = c.id
			WHERE
				b.date BETWEEN '$sta' AND '$end'
			GROUP BY
				a.importir
		";

		$query = $this->db->query($sql);
		return $query->result();
	}

	private function GetDataImportirMonthly($sta, $end)
	{
		$sql = "
			SELECT
				c.nama,
				b.year,
				b.month,
				SUM(a.netto) netto,
				SUM(a.nilai_pabean_idr) nilai,
				SUM(a.bm) bm,
				SUM(a.ppn) ppn,
				SUM(a.pph) pph,
				SUM(a.ppnbm) ppnbm
			FROM db_semesta.fact_pib_importir a
			INNER JOIN db_semesta.dim_date b ON
				a.tgl_pib = b.id
			INNER JOIN db_semesta.dim_pengguna_jasa c ON
				a.importir = c.id
			WHERE
				b.date BETWEEN '$sta' AND '$end'
			GROUP BY
				a.importir,
				b.year,
				b.month
		";

		$query = $this->db->query($sql);
		return $query->result();
	}

	public function GetChartData($sta, $end)
	{
		$chartOptions = [];

		// Get data
		$periods = $this->ListMonth($sta, $end);
		$dataSummary = $this->GetDataImportir($sta, $end);
		$monthDataSummary = $this->GetDataImportirMonthly($sta, $end);

		// Prepare nilai pabean chart options
		$pieNilai = $this->PreparePieData($dataSummary, "nilai");
		$explicitLabelNilai = $pieNilai["legend"]["data"];
		if (($key = array_search("lainnya", $explicitLabelNilai)) !== false) {
			unset($explicitLabelNilai[$key]);
		}
		$stackNilai = $this->PrepareStackData($monthDataSummary, "nilai", $periods, $explicitLabelNilai);

		// Prepare bea masuk chart options
		$pieBm = $this->PreparePieData($dataSummary, "bm");
		$explicitLabelBm = $pieBm["legend"]["data"];
		if (($key = array_search("lainnya", $explicitLabelBm)) !== false) {
			unset($explicitLabelBm[$key]);
		}
		$stackBm = $this->PrepareStackData($monthDataSummary, "bm", $periods, $explicitLabelBm);

		// Prepare netto chart options
		$pieNetto = $this->PreparePieData($dataSummary, "netto");
		$explicitLabelNetto = $pieNetto["legend"]["data"];
		if (($key = array_search("lainnya", $explicitLabelNetto)) !== false) {
			unset($explicitLabelNetto[$key]);
		}
		$stackNetto = $this->PrepareStackData($monthDataSummary, "netto", $periods, $explicitLabelNetto);

		// Prepare table data
		$tableData = $this->PrepareHsTable($dataSummary);

		$chartOptions["pieNilai"] = $pieNilai;
		$chartOptions["stackNilai"] = $stackNilai;
		$chartOptions["pieBm"] = $pieBm;
		$chartOptions["stackBm"] = $stackBm;
		$chartOptions["pieNetto"] = $pieNetto;
		$chartOptions["pieNetto"] = $pieNetto;
		$chartOptions["table"] = $tableData;

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
			$divisor = 1000000000;
		} else if ($dataType == 'bm') {
			$chartName = "Bea Masuk";
			$divisor = 1000000000;
		} else if ($dataType == 'netto') {
			$chartName = "Netto";
			$divisor = 1;
		}

		$sumAll = 0;
		$sumOther = 0;
		$dataValues = [];
		$dataLabels = [];

		foreach ($sumHs as $key => $value) {
			$sumAll += (float)$value->$dataType;
		}

		foreach ($sumHs as $key => $value) {
			$hsValue = round((float)$value->$dataType / $divisor,2,PHP_ROUND_HALF_UP);
			$part = $hsValue / ($sumAll / $divisor);
			if ($part > 0.01) {
				$hsValues[(string)$value->nama] = $hsValue;
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

	private function PrepareStackData($summaryMonth, $dataType, $periods, $explicitLabel)
	{
		if ($dataType == "nilai") {
			$yAxisName = "Nilai Pabean (miliar Rp)";
			$divisor = 1000000000;
		} else if ($dataType == "bm") {
			$yAxisName = "Bea Masuk (miliar Rp)";
			$divisor = 1000000000;
		} else if ($dataType == "netto") {
			$yAxisName = "Netto (kg)";
			$divisor = 1;
		}
		
		$data = [];
		foreach ($explicitLabel as $label) {
			$data[$label] = array_fill(0, count($periods), 0);
		}
		$data["lainnya"] = array_fill(0, count($periods), 0);

		foreach ($summaryMonth as $key => $value) {
			$monthIdx = array_search([$value->year, $value->month], $periods);
			if (in_array($value->nama, $explicitLabel)) {
				$data[$value->nama][$monthIdx] = round((float)$value->$dataType / $divisor,2,PHP_ROUND_HALF_UP);
			} else {
				$data["lainnya"][$monthIdx] += (float)$value->$dataType / $divisor;
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
				'textStyle' => [
					'fontSize' => 10
				],
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
			$netto = round((float)$value->netto,2,PHP_ROUND_HALF_UP);
			$bruto = round((float)$value->bruto,2,PHP_ROUND_HALF_UP);
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
				"id" => $value->id,
				"nama" => $value->nama,
				"jml_pib" => $value->jml_pib,
				"netto" => $netto,
				"bruto" => $bruto,
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