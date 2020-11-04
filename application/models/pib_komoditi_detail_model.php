<?php

class Pib_komoditi_detail_model extends CI_Model {

	public function GetHsDescription($hsid)
	{
		$reachParent = false;
		$hsDesc = [];

		$searchHsId = $hsid;
		while ($reachParent == false) {
			$query = $this->db->query("
				SELECT
					a.id,
					a.parent_id,
					a.takik,
					a.kode,
					a.uraian,
					a.uraian_english
				FROM db_patops.hs_code a
				WHERE
					a.id = $searchHsId
			");

			$result = $query->row_array();
			$searchHsId = $result['parent_id'];
			if ($result['parent_id'] == null) {
				$reachParent = true;
			}
			array_unshift($hsDesc, $result);
		}

		return $hsDesc;
	}

	public function GetDataHs($hsid, $sta='2020-01-01', $end='2020-12-31')
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

		$dataMonthCurrent = $this->GetDataHsMonthly($hsid, $sta, $end);
		$dataMonthBefore = $this->GetDataHsMonthly($hsid, $datesBefore['sta'], $datesBefore['end']);
		$data['barHsNilai'] = $this->PrepareBarChart($dataMonthCurrent, $dataMonthBefore, $periods, 'nilai');
		$data['barHsBm'] = $this->PrepareBarChart($dataMonthCurrent, $dataMonthBefore, $periods, 'bm');
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

	private function GetDataHsMonthly($hsid, $sta, $end)
	{
		$query = $this->db->query("
			SELECT
				b.year,
				b.month,
				SUM(a.nilai_pabean_idr) nilai,
				SUM(a.bm) bm
			FROM db_semesta.fact_pib_hs a
			INNER JOIN db_semesta.dim_date b ON
				a.tgl_pib = b.id
			WHERE
				a.hs = $hsid and
				b.date BETWEEN '$sta' AND '$end'
			GROUP BY
				1,2
		");

		$result = $query->result_array();
		return $result;
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

}
