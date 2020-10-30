<?php

class Pib_komoditi_model extends CI_Model {

	private function GetDataHs($sta, $end)
	{
		$query = $this->db->query("
			SELECT
				c.kode,
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

		$periods = $this->ListMonth($sta, $end);
		$sumHs = $this->GetDataHs($sta, $end);
		$sumHsMonth = $this->GetDataHsMonthly($sta, $end);

		$pieHsNilai = $this->PreparePieHsNilai($sumHs);
		$explicitHs = $pieHsNilai["legend"]["data"];
		if (($key = array_search("lainnya", $explicitHs)) !== false) {
			unset($explicitHs[$key]);
		}
		$stackHsNilai = $this->PrepareStackHsNilai($sumHsMonth, $periods, $explicitHs);

		$chartOptions["pieHsNilai"] = $pieHsNilai;
		$chartOptions["stackHsNilai"] = $stackHsNilai;

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

	private function PreparePieHsNilai($sumHs)
	{
		$sum_nilai = 0;
		$sum_other = 0;
		$dataValues = [];
		$dataLabels = [];

		foreach ($sumHs as $key => $value) {
			$sum_nilai += (float)$value->nilai;
		}

		foreach ($sumHs as $key => $value) {
			$nilai = round((float)$value->nilai / 1000000000,2,PHP_ROUND_HALF_UP);
			$part = $nilai / ($sum_nilai / 1000000000);
			if ($part > 0.01) {
				$nilai_hs[(string)$value->kode] = $nilai;
			} else {
				$sum_other += $nilai;
			}
		}
		arsort($nilai_hs);
		$nilai_hs['lainnya'] = round($sum_other,2,PHP_ROUND_HALF_UP);

		foreach ($nilai_hs as $key => $value) {
			$dataValue = [
				"value" => $value,
				"name" => $key
			];
			array_push($dataValues, $dataValue);
			array_push($dataLabels, $key);
		}

		$chartOptions = $this->PreparePieChart("Nilai Pabean", $dataLabels, $dataValues);

		return $chartOptions;
	}

	private function PrepareStackHsNilai($sumHsMonth, $periods, $explicitHs)
	{
		$data = [];
		foreach ($explicitHs as $hs) {
			$data[$hs] = array_fill(0, count($periods), 0);
		}
		$data["lainnya"] = array_fill(0, count($periods), 0);

		foreach ($sumHsMonth as $key => $value) {
			$monthIdx = array_search([$value->year, $value->month], $periods);
			if (in_array($value->kode, $explicitHs)) {
				$data[$value->kode][$monthIdx] = round((float)$value->nilai / 1000000000,2,PHP_ROUND_HALF_UP);
			} else {
				$data["lainnya"][$monthIdx] += (float)$value->nilai / 1000000000;
			}
		}

		foreach ($data["lainnya"] as $key => $value) {
			$data["lainnya"][$key] = round($value,2,PHP_ROUND_HALF_UP);
		}

		$chartOptions = $this->PrepareStackChart($periods, $data, 'Nilai Pabean (miliar Rp)');

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

}