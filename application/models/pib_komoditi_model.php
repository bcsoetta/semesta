<?php

class Pib_komoditi_model extends CI_Model {

	private function GetDataHs()
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
				b.date BETWEEN '2020-01-01' AND '2020-12-31'
			GROUP BY
				a.hs
		");

		return $query->result();
	}

	public function ChartHsNilai()
	{
		// $nilai_hs = [];
		$sum_nilai = 0;
		$sum_other = 0;
		// $part_other = 0;
		$dataValues = [];
		$dataLabels = [];
		$summary_hs = $this->GetDataHs();

		foreach ($summary_hs as $key => $value) {
			$sum_nilai += (float)$value->nilai;
		}

		foreach ($summary_hs as $key => $value) {
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

	private function PreparePieChart($chartName, $dataLabels, $dataValues)
	{
		$chartOptions = [
			'legend' => [
				'top' => -10,
				'height' => '50%',
				'data' => $dataLabels
			],
			'series' => [
				[
					'name' => $chartName,
					'type' => 'pie',
					'top' => 20,
					'selectedMode' => 'single',
					'label' => [
						'formatter' => '{b}, {c} ({d}%)'
					],
					'data' => $dataValues,
					'height' => 10,
				]
			]
		];

		return $chartOptions;
	}

	public function test()
	{
		$testData = [
			'xAxis' => [
				'type' => 'category',
				'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
			],
			'yAxis' => [
				'type' => 'value'
			],
			'series' => [
				[
					'data' => [820, 932, 901, 934, 1290, 1330, 1320],
					'type' => 'line'
				]
			]
		];

		return $testData;
	}

	public function test2()
	{
		$testData = [
			'tooltip' => [
				'trigger' => 'item',
				'formatter' => '{a} <br/>{b}: {c} ({d}%)'
			],
			'legend' => [
				'orient' => 'vertical',
				'left' => 10,
				'data' => ['直接访问', '邮件营销', '联盟广告', '视频广告', '搜索引擎']
			],
			'series' => [
				[
					'name' => '访问来源',
					'type' => 'pie',
					'radius' => ['50%', '70%'],
					'avoidLabelOverlap' => false,
					'label' => [
						'show' => false,
						'position' => 'center'
					],
					'emphasis' => [
						'label' => [
							'show' => true,
							'fontSize' => '30',
							'fontWeight' => 'bold'
						]
					],
					'labelLine' => [
						'show' => false
					],
					'data' => [
						['value' => 335, 'name' => '直接访问'],
						['value' => 310, 'name' => '邮件营销'],
						['value' => 234, 'name' => '联盟广告'],
						['value' => 135, 'name' => '视频广告'],
						['value' => 1548, 'name' => '搜索引擎']
					]
				]
			]
		];

		return $testData;
	}
}