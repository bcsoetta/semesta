<?php

class Perbend_model extends CI_Model {

	private function prep_date($start, $end)
	{
		$date = [];

		if ($start == null) {
			$date['start'] = date('Y-01-01');
		} else {
			$start = str_replace('/', '-', $start);
			$date['start'] = date('Y-m-d', strtotime($start));
		}

		if ($end == null) {
			$date['end'] = date('Y-m-d');
		} else {
			$end = str_replace('/', '-', $end);
			$date['end'] = date('Y-m-d', strtotime($end));
		}

		return $date;
	}

	private function PiutangTotal($date)
	{

		$query = $this->db->select("
				c.nm_par,
				SUM(a.jumlah_dok) 'jml dok',
				SUM(a.total_bm) bm,
				SUM(a.total_ppn) ppn,
				SUM(a.total_pph) pph,
				SUM(a.total_ppnbm) ppnbm,
				SUM(a.total_denda) denda,
				(
					ifnull(SUM(a.total_bm),0) +
					ifnull(SUM(a.total_ppn),0) +
					ifnull(SUM(a.total_pph),0) +
					ifnull(SUM(a.total_ppnbm),0) +
					ifnull(SUM(a.total_denda),0)
				) 'total tagihan'
			")
			->from("db_semesta.fact_piutang a")
			->join("db_semesta.dim_date b", "a.tgl_dok = b.id")
			->join("data_dt.tr_perbendaharaan c", "c.nm_group = 'jns_dok' AND a.jns_dok = c.kd_par")
			->where("b.date >=", $date['start'])
			->where("b.date <=", $date['end'])
			->group_by("a.jns_dok")
			->get();

		$this->piutang_total = $query->result();
	}

	private function PiutangAll($date)
	{

		$query = $this->db->query("
			SELECT
				dim.year,
				dim.month,
				dim.nm_par,
				ifnull(SUM(a.jumlah_dok),0) freq,
				ifnull(SUM(a.total_bm),0) bm,
				ifnull(SUM(a.total_ppn),0) ppn,
				ifnull(SUM(a.total_pph),0) pph,
				ifnull(SUM(a.total_ppnbm),0) ppnbm,
				ifnull(SUM(a.total_denda),0) denda
			FROM db_semesta.fact_piutang a
			right join(
				select c.id id_date, c.year, c.month, b.kd_par, b.nm_par
					from db_semesta.dim_date c
					left join data_dt.tr_perbendaharaan b
					on 1=1 AND b.nm_group = 'jns_dok' AND b.kd_par IN (1,2,4,5)
					WHERE c.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
				union
				select c.id id_date, c.year, c.month, b.kd_par, b.nm_par
					from db_semesta.dim_date c
					right join data_dt.tr_perbendaharaan b
					on 1=1 AND b.nm_group = 'jns_dok' AND b.kd_par IN (1,2,4,5)
					WHERE c.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
			) dim
			ON dim.id_date = a.tgl_dok AND dim.kd_par = a.jns_dok
			GROUP BY dim.year, dim.month, dim.kd_par
		");

		$this->piutang_all = $query->result();
	}

	private function PiutangBm($date)
	{

		$query = $this->db->query("
			SELECT
				dim.year,
				dim.month,
				ifnull(SUM(a.total_bm),0) BM
			FROM db_semesta.fact_piutang a
			right join(
				select c.id id_date, c.year, c.month
				from db_semesta.dim_date c
				WHERE c.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
			) dim
			ON dim.id_date = a.tgl_dok
			GROUP BY dim.year, dim.month
		");

		$this->piutang_bm = $query->result();
	}

	private function StatusPiutangDetil($date)
	{

		$query = $this->db->query("
			SELECT
				src.status,
				jt_tempo,
				COUNT(1) jml
			FROM (	
				SELECT
					a.jns_dok,
					a.id_dok,
					a.`status`,
					a.tgl_status,
					case
						when DATE(NOW()) > b.date
						then 1
						ELSE 0
					END jt_tempo
				FROM db_semesta.log_piutang_status a
				LEFT JOIN db_semesta.dim_date b ON a.tgl_jt_tempo = b.id
				INNER JOIN (
					SELECT a.jns_dok, a.id_dok, MAX(a.status) stat
					FROM db_semesta.log_piutang_status a
					INNER JOIN db_semesta.dim_date b ON a.tgl_dok = b.id
					WHERE b.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
					GROUP BY a.jns_dok, a.id_dok
				) p 
				ON 
					a.jns_dok = p.jns_dok and 
					a.id_dok = p.id_dok and 
					a.`status` = p.stat
			) src
			GROUP BY src.status, jt_tempo;
		");

		$this->status_piutang_detil = $query->result();
	}

	private function ListPiutang($input='')
	{

		$date = $this->prep_date($input['date']['start_date'], $input['date']['end_date']);
		
		if ($input['status'] != 8) {

			$status = substr($input['status'],0,-1);
			$stat_master = substr($input['status'],0,-2);
			$jt_tempo = substr($input['status'],-1);
			$lunas = substr($status,-1);

			$filter_status = "d.status = " . $status . " AND d.jt_tempo = " . $jt_tempo;

			if ($stat_master == 2) {
				$dok_mutasi = "Srt Teguran";
			} elseif ($stat_master == 3) {
				$dok_mutasi = "Srt Paksa";
			} elseif ($stat_master == 6) {
				$dok_mutasi = "Kep Keberatan";
			}

			if ($status == 10 && $jt_tempo == 0) {

				$order = " ORDER BY 6,2";
				$this->ListSuratPiutang($filter_status, $order, $date);

			} elseif ($status == 10 && $jt_tempo == 1) {

				$order = " ORDER BY 6 DESC, 2";
				$this->ListSuratPiutang($filter_status, $order, $date);

			} elseif ($status == 19) {

				$order = " ORDER BY 7 DESC";
				$this->ListSuratPiutang($filter_status, $order, $date);

			} elseif (in_array($status, array(20,30,60)) && $jt_tempo == 0) {

				$order = " ORDER BY 7,6";
				$this->ListSuratMutasi($filter_status, $order, $dok_mutasi, $date);

			} elseif (in_array($status, array(20,30,60)) && $jt_tempo == 1) {

				$order = " ORDER BY 7 DESC, 6";
				$this->ListSuratMutasi($filter_status, $order, $dok_mutasi, $date);

			} elseif (in_array($status, array(29,39,69))) {

				$order = " ORDER BY 9 DESC";
				$this->ListSuratMutasi($filter_status, $order, $dok_mutasi, $date);

			}

		} else {
			$status = $input['status'] . "0";
			$filter_status = " d.status = " . $status;
			$order = " ORDER BY 7 DESC";
			$dok_mutasi = "Kep Pembatalan";
			$this->ListSuratMutasi($filter_status, $order, $dok_mutasi, $date);
		}

	}

	private function ListSuratPiutang($filter='', $order='', $date='')
	{

		$query_sptnp = "
			SELECT
				'SPTNP' `Dok`,
				CONCAT(e.NO_SPTNP, e.NO_AGENDA) `No Dok`,
				e.TGL_SPTNP `Tgl Dok`,
				e.ID_IMP `NPWP`,
				g.nama `Nama`,
				e.JT_TEMPO_SPTNP `Jt Tempo`,
				f.tgl_ntpn `Tgl Lunas`
			FROM (
				SELECT
					a.jns_dok,
					a.id_dok,
					a.`status`,
					a.tgl_status,
					a.id_billing,
					case
						when DATE(NOW()) > c.date
						then 1
						ELSE 0
					END jt_tempo
				FROM db_semesta.log_piutang_status a
				INNER JOIN (
					SELECT a.jns_dok, a.id_dok, MAX(a.status) stat
					FROM db_semesta.log_piutang_status a
					INNER JOIN db_semesta.dim_date h ON a.tgl_dok = h.id
					WHERE h.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
					GROUP BY a.jns_dok, a.id_dok
				) b
				ON 
					a.jns_dok = b.jns_dok and 
					a.id_dok = b.id_dok and 
					a.`status` = b.stat
				LEFT JOIN db_semesta.dim_date c ON a.tgl_jt_tempo = c.id
			) d
			INNER JOIN data_dt.sptnp e ON d.id_dok = e.id AND d.jns_dok = 1
			LEFT JOIN data_dt.billing f ON d.id_billing = f.id
			LEFT JOIN db_semesta.dim_pengguna_jasa g ON e.ID_IMP = g.npwp
			WHERE " . $filter;

		$query_spktnp = "
			SELECT
				'SPKTNP' `Dok`,
				CONCAT(e.NO_DOK, e.NO_AGENDA) `No Dok`,
				e.TGL_DOK `Tgl Dok`,
				e.ID_PRSH `NPWP`,
				g.nama `Nama`,
				e.TGL_JT_TEMPO `Jt Tempo`,
				f.tgl_ntpn `Tgl Lunas`
			FROM (
				SELECT
					a.jns_dok,
					a.id_dok,
					a.`status`,
					a.tgl_status,
					a.id_billing,
					case
						when DATE(NOW()) > c.date
						then 1
						ELSE 0
					END jt_tempo
				FROM db_semesta.log_piutang_status a
				INNER JOIN (
					SELECT a.jns_dok, a.id_dok, MAX(a.status) stat
					FROM db_semesta.log_piutang_status a
					INNER JOIN db_semesta.dim_date h ON a.tgl_dok = h.id
					WHERE h.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
					GROUP BY a.jns_dok, a.id_dok
				) b
				ON 
					a.jns_dok = b.jns_dok and 
					a.id_dok = b.id_dok and 
					a.`status` = b.stat
				LEFT JOIN db_semesta.dim_date c ON a.tgl_jt_tempo = c.id
			) d
			INNER JOIN data_dt.spktnp e ON d.id_dok = e.id AND d.jns_dok = 2
			LEFT JOIN data_dt.billing f ON d.id_billing = f.id
			LEFT JOIN db_semesta.dim_pengguna_jasa g ON e.ID_PRSH = g.npwp
			WHERE " . $filter;

		$query_spp = "
			SELECT
				'SPP' `Dok`,
				CONCAT(e.NO_SPP, e.NO_AGENDA) `No Dok`,
				e.TGL_SPP `Tgl Dok`,
				e.NPWP `NPWP`,
				g.nama `Nama`,
				e.TGL_JT_TEMPO `Jt Tempo`,
				f.tgl_ntpn `Tgl Lunas`
			FROM (
				SELECT
					a.jns_dok,
					a.id_dok,
					a.`status`,
					a.tgl_status,
					a.id_billing,
					case
						when DATE(NOW()) > c.date
						then 1
						ELSE 0
					END jt_tempo
				FROM db_semesta.log_piutang_status a
				INNER JOIN (
					SELECT a.jns_dok, a.id_dok, MAX(a.status) stat
					FROM db_semesta.log_piutang_status a
					INNER JOIN db_semesta.dim_date h ON a.tgl_dok = h.id
					WHERE h.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
					GROUP BY a.jns_dok, a.id_dok
				) b
				ON 
					a.jns_dok = b.jns_dok and 
					a.id_dok = b.id_dok and 
					a.`status` = b.stat
				LEFT JOIN db_semesta.dim_date c ON a.tgl_jt_tempo = c.id
			) d
			INNER JOIN data_dt.spp e ON d.id_dok = e.id AND d.jns_dok = 4
			LEFT JOIN data_dt.billing f ON d.id_billing = f.id
			LEFT JOIN db_semesta.dim_pengguna_jasa g ON e.NPWP = g.npwp
			WHERE " . $filter;

		$query_spsa = "
			SELECT
				'SPSA' `Dok`,
				CONCAT(e.NO_SPSA, e.NO_AGENDA) `No Dok`,
				e.TGL_SPSA `Tgl Dok`,
				e.NPWP `NPWP`,
				g.nama `Nama`,
				e.TGL_JT_TEMPO `Jt Tempo`,
				f.tgl_ntpn `Tgl Lunas`
			FROM (
				SELECT
					a.jns_dok,
					a.id_dok,
					a.`status`,
					a.tgl_status,
					a.id_billing,
					case
						when DATE(NOW()) > c.date
						then 1
						ELSE 0
					END jt_tempo
				FROM db_semesta.log_piutang_status a
				INNER JOIN (
					SELECT a.jns_dok, a.id_dok, MAX(a.status) stat
					FROM db_semesta.log_piutang_status a
					INNER JOIN db_semesta.dim_date h ON a.tgl_dok = h.id
					WHERE h.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
					GROUP BY a.jns_dok, a.id_dok
				) b
				ON 
					a.jns_dok = b.jns_dok and 
					a.id_dok = b.id_dok and 
					a.`status` = b.stat
				LEFT JOIN db_semesta.dim_date c ON a.tgl_jt_tempo = c.id
			) d
			INNER JOIN data_dt.spsa e ON d.id_dok = e.id AND d.jns_dok = 5
			LEFT JOIN data_dt.billing f ON d.id_billing = f.id
			LEFT JOIN db_semesta.dim_pengguna_jasa g ON e.NPWP = g.npwp
			WHERE " . $filter;

		$query = $this->db->query($query_sptnp . " UNION " . $query_spktnp . " UNION " . $query_spp . " UNION " . $query_spsa . $order);

		$this->list_piutang = $query->result();
	}

	private function ListSuratMutasi($filter='', $order='', $dok_mutasi='', $date='')
	{

		$query_sptnp = "
			SELECT
				'SPTNP' `Dok`,
				CONCAT(e.no_sptnp, e.NO_AGENDA) `No Dok`,
				e.tgl_sptnp `Tgl Dok`,
				e.id_imp `NPWP`,
				h.nama `Nama`,
				CONCAT(f.no_status, f.no_agenda) `" . $dok_mutasi . "`,	
				f.tgl_status `Tgl Surat`, 
				e.jt_tempo_sptnp `Jt Tempo`,
				g.tgl_ntpn `Tgl Lunas`
			FROM (
				SELECT
					a.jns_dok,
					a.id_dok,
					a.`status`,
					a.tgl_status,
					a.id_billing,
					a.id_status,
					case
						when DATE(NOW()) > c.date
						then 1
						ELSE 0
					END jt_tempo
				FROM db_semesta.log_piutang_status a
				INNER JOIN (
					SELECT a.jns_dok, a.id_dok, MAX(a.status) stat
					FROM db_semesta.log_piutang_status a
					INNER JOIN db_semesta.dim_date h ON a.tgl_dok = h.id
					WHERE h.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
					GROUP BY a.jns_dok, a.id_dok
				) b
				ON 
					a.jns_dok = b.jns_dok and 
					a.id_dok = b.id_dok and 
					a.`status` = b.stat
				LEFT JOIN db_semesta.dim_date c ON a.tgl_jt_tempo = c.id
			) d
			INNER JOIN data_dt.sptnp e ON d.id_dok = e.id AND d.jns_dok = 1
			INNER JOIN data_dt.piutang_status f ON d.id_status = f.id
			LEFT JOIN data_dt.billing g ON d.id_billing = g.id
			LEFT JOIN db_semesta.dim_pengguna_jasa h on e.id_imp = h.npwp
			WHERE " . $filter;

		$query_spktnp = "
			SELECT
				'SPKTNP' `Dok`,
				CONCAT(e.NO_DOK, e.NO_AGENDA) `No Dok`,
				e.TGL_DOK `Tgl Dok`,
				e.ID_PRSH `NPWP`,
				h.nama `Nama`,
				CONCAT(f.no_status, f.no_agenda) `" . $dok_mutasi . "`,	
				f.tgl_status `Tgl Surat`, 
				e.TGL_JT_TEMPO `Jt Tempo`,
				g.tgl_ntpn `Tgl Lunas`
			FROM (
				SELECT
					a.jns_dok,
					a.id_dok,
					a.`status`,
					a.tgl_status,
					a.id_billing,
					a.id_status,
					case
						when DATE(NOW()) > c.date
						then 1
						ELSE 0
					END jt_tempo
				FROM db_semesta.log_piutang_status a
				INNER JOIN (
					SELECT a.jns_dok, a.id_dok, MAX(a.status) stat
					FROM db_semesta.log_piutang_status a
					INNER JOIN db_semesta.dim_date h ON a.tgl_dok = h.id
					WHERE h.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
					GROUP BY a.jns_dok, a.id_dok
				) b
				ON 
					a.jns_dok = b.jns_dok and 
					a.id_dok = b.id_dok and 
					a.`status` = b.stat
				LEFT JOIN db_semesta.dim_date c ON a.tgl_jt_tempo = c.id
			) d
			INNER JOIN data_dt.spktnp e ON d.id_dok = e.id AND d.jns_dok = 2
			INNER JOIN data_dt.piutang_status f ON d.id_status = f.id
			LEFT JOIN data_dt.billing g ON d.id_billing = g.id
			LEFT JOIN db_semesta.dim_pengguna_jasa h on e.ID_PRSH = h.npwp
			WHERE " . $filter;

		$query_spp = "
			SELECT
				'SPP' `Dok`,
				CONCAT(e.NO_SPP, e.NO_AGENDA) `No Dok`,
				e.TGL_SPP `Tgl Dok`,
				e.NPWP `NPWP`,
				h.nama `Nama`,
				CONCAT(f.no_status, f.no_agenda) `" . $dok_mutasi . "`,	
				f.tgl_status `Tgl Surat`, 
				e.TGL_JT_TEMPO `Jt Tempo`,
				g.tgl_ntpn `Tgl Lunas`
			FROM (
				SELECT
					a.jns_dok,
					a.id_dok,
					a.`status`,
					a.tgl_status,
					a.id_billing,
					a.id_status,
					case
						when DATE(NOW()) > c.date
						then 1
						ELSE 0
					END jt_tempo
				FROM db_semesta.log_piutang_status a
				INNER JOIN (
					SELECT a.jns_dok, a.id_dok, MAX(a.status) stat
					FROM db_semesta.log_piutang_status a
					INNER JOIN db_semesta.dim_date h ON a.tgl_dok = h.id
					WHERE h.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
					GROUP BY a.jns_dok, a.id_dok
				) b
				ON 
					a.jns_dok = b.jns_dok and 
					a.id_dok = b.id_dok and 
					a.`status` = b.stat
				LEFT JOIN db_semesta.dim_date c ON a.tgl_jt_tempo = c.id
			) d
			INNER JOIN data_dt.spp e ON d.id_dok = e.id AND d.jns_dok = 4
			INNER JOIN data_dt.piutang_status f ON d.id_status = f.id
			LEFT JOIN data_dt.billing g ON d.id_billing = g.id
			LEFT JOIN db_semesta.dim_pengguna_jasa h on e.NPWP = h.npwp
			WHERE " . $filter;

		$query_spsa = "
			SELECT
				'SPSA' `Dok`,
				CONCAT(e.NO_SPSA, e.NO_AGENDA) `No Dok`,
				e.TGL_SPSA `Tgl Dok`,
				e.NPWP `NPWP`,
				h.nama `Nama`,
				CONCAT(f.no_status, f.no_agenda) `" . $dok_mutasi . "`,	
				f.tgl_status `Tgl Surat`, 
				e.TGL_JT_TEMPO `Jt Tempo`,
				g.tgl_ntpn `Tgl Lunas`
			FROM (
				SELECT
					a.jns_dok,
					a.id_dok,
					a.`status`,
					a.tgl_status,
					a.id_billing,
					a.id_status,
					case
						when DATE(NOW()) > c.date
						then 1
						ELSE 0
					END jt_tempo
				FROM db_semesta.log_piutang_status a
				INNER JOIN (
					SELECT a.jns_dok, a.id_dok, MAX(a.status) stat
					FROM db_semesta.log_piutang_status a
					INNER JOIN db_semesta.dim_date h ON a.tgl_dok = h.id
					WHERE h.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
					GROUP BY a.jns_dok, a.id_dok
				) b
				ON 
					a.jns_dok = b.jns_dok and 
					a.id_dok = b.id_dok and 
					a.`status` = b.stat
				LEFT JOIN db_semesta.dim_date c ON a.tgl_jt_tempo = c.id
			) d
			INNER JOIN data_dt.spsa e ON d.id_dok = e.id AND d.jns_dok = 5
			INNER JOIN data_dt.piutang_status f ON d.id_status = f.id
			LEFT JOIN data_dt.billing g ON d.id_billing = g.id
			LEFT JOIN db_semesta.dim_pengguna_jasa h on e.NPWP = h.npwp
			WHERE " . $filter;

		$query = $this->db->query($query_sptnp . " UNION " . $query_spktnp . " UNION " . $query_spp . " UNION " . $query_spsa . $order);

		$this->list_piutang = $query->result();
	}

	public function PiutangTotalTable($start_date, $end_date)
	{
		$date = $this->prep_date($start_date, $end_date);

		$this->PiutangTotal($date);

		$data = $this->piutang_total;

		$table = [];
		$columns = [];
		$rows = [];

		$table = [
			'paging' => [
				'enabled' => false
			],
			'sorting' => [
				'enabled' => true
			]
		];

		foreach ($data[0] as $key => $value) {
			if ($key == 'nm_par') {
				$columns[] = [
					'name' => $key,
					'title' => 'dokumen',
					'type' => 'text'
				];
			} elseif ($key == 'total tagihan') {
				$columns[] = [
					'name' => $key,
					'title' => $key,
					'type' => 'number',
					'style' => [
						'text-align' => 'right'
					]
				];
			} elseif ($key == 'jml dok') {
				$columns[] = [
					'name' => $key,
					'title' => $key,
					'type' => 'number',
					'breakpoints' => 'xs',
					'style' => [
						'text-align' => 'right'
					]
				];
			} else {
				$columns[] = [
					'name' => $key,
					'title' => $key,
					'type' => 'number',
					'breakpoints' => 'all'
				];	
			}
		}

		$rows = $data;

		$table['columns'] = $columns;
		$table['rows'] = $rows;
		return $table;
	}

	public function PiutangAllChart($start_date, $end_date)
	{
		$date = $this->prep_date($start_date, $end_date);

		$this->PiutangAll($date);
		$this->PiutangBm($date);

		$query_res = $this->piutang_all;
		$query_bm = $this->piutang_bm;

		foreach ($query_res as $row) {
			$dok = $row->nm_par;
			$list_dok[] = $dok;

			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$data[$dok]['freq'][] = (int)$row->freq;
			// $data[$dok]['bm'][] = (int)$row->bm;
			// $data[$dok]['ppn'][] = (int)$row->ppn;
			// $data[$dok]['pph'][] = (int)$row->pph;
			// $data[$dok]['ppnbm'][] = (int)$row->ppnbm;
			// $data[$dok]['denda'][] = (int)$row->denda;
		}
		$data['dokumen'] = array_unique($list_dok);
		$data['tgl'] = array_values(array_unique($list_tgl));

		foreach ($query_bm as $key => $value) {
			$data['bm'][] = $value->BM/1000000;
		}

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				'data' => $data['dokumen']
			],
			'calculable' => false,
			'grid' => [
				'left' => 75,
				'top' => 45,
				'right' => 75,
				'bottom' => 45
			],
			'xAxis' => [
				[
					'type' => 'category',
					// 'boundaryGap' => false,
					'data' => $data['tgl']
				]
			],
			'yAxis' => [
				[
					'type' => 'value',
					'name' => 'Jumlah Dokumen',
					'nameLocation' => 'center',
					'nameGap' => 55,
					'splitNumber' => 4
				],
				[
					'type' => 'value',
					'name' => 'Bea Masuk (Jutaan Rp)',
					'nameLocation' => 'center',
					'nameGap' => 55,
					'splitNumber' => 4
				]
			],
			// 'color' => ['#78909c', '#ce93d8', '#8e24aa', '#a5d6a7', '#4caf50', '#2e7d32', '#ffeb3b', '#ef9a9a', '#f44336', '#c62828'],
			'series' => [

			]
		];

		foreach ($data['dokumen'] as $dok) {
			$series_freq = [
				'name' => $dok,
				'type' => 'bar',
				'stack' => 'freq',
				'data' => $data[$dok]['freq']	
			];

			$jsonObject['series'][] = $series_freq;

		}

		$series_bm = [
			'name' => 'BM',
			'type' => 'line',
			'smooth' => true,
			'yAxisIndex' => 1,
			'data' => $data['bm']
		];
		$jsonObject['legend']['data'][4] = 'BM';

		$jsonObject['series'][] = $series_bm;

		return $jsonObject;
	}

	public function StatusPiutangList($start_date, $end_date)
	{
		$date = $this->prep_date($start_date, $end_date);

		$this->StatusPiutangDetil($date);

		foreach ($this->status_piutang_detil as $key => $value) {
			if (!isset($data[substr($value->status,0,-1)])) {
				$data[substr($value->status,0,-1)] = $value->jml;
			} else {
				$data[substr($value->status,0,-1)] = $data[substr($value->status,0,-1)] + $value->jml;
			}
		}

		foreach ($this->status_piutang_detil as $key => $value) {
			$data[$value->status . $value->jt_tempo] = $value->jml;
		}

		return $data;
	}

	public function ListPiutangTable($input='')
	{
		$this->ListPiutang($input);

		$data = $this->list_piutang;

		$table = [];
		$columns = [];
		$rows = [];

		$table = [
			'paging' => [
				'enabled' => true,
				'limit' => 5,
				'size' => 5
			],
			'sorting' => [
				'enabled' => true
			]
		];

		foreach ($data[0] as $key => $value) {
			$columns[] = [
				'name' => $key,
				'title' => $key,
				'type' => 'text'
			];
		}

		$table['columns'] = $columns;
		$table['rows'] = $data;

		return $table;
	}
}