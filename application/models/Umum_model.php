<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Umum_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function ppkp_create_process($data) {
		$tema = $data['tema'];
	    $tempat = $data['tempat'];
	    $jum_peserta = $data['jum_peserta'];
	    $tanggal = date('Y-m-d', strtotime($data['tgl_pelaksanaan']));
	    $waktu_mulai = date('Y-m-d H:i:s', strtotime($data['wkt1']));
	    $waktu_selesai = date('Y-m-d H:i:s', strtotime($data['wkt2']));
	    $no_surat = $data['no_surat'];
	    $tanggal_surat = date('Y-m-d', strtotime($data['tgl_surat']));
	    $penyelenggara = $data['penyelenggara'];
	    $status = $data['status'];

	    $arr = array(
			'tema' => $tema,
		    'tempat' => $tempat,
		    'jum_peserta' => $jum_peserta,
		    'tanggal' => $tanggal,
		    'waktu_mulai' => $waktu_mulai,
		    'waktu_selesai' => $waktu_selesai,
		    'nomor_surat' => $no_surat,
		    'tanggal_surat' => $tanggal_surat,
		    'penyelenggara' => $penyelenggara,
		    'creator' => $_SESSION['user_id'],
		    'status' => $status
		);

		$this->db->insert('umum_ppkp', $arr);

		$aff = $this->db->affected_rows();

		if ($aff > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function ppkp_update_process($data) {
		$tema = $data['tema'];
	    $tempat = $data['tempat'];
	    $jum_peserta = $data['jum_peserta'];
	    $tanggal = date('Y-m-d', strtotime($data['tgl_pelaksanaan']));
	    $waktu_mulai = date('Y-m-d H:i:s', strtotime($data['wkt1']));
	    $waktu_selesai = date('Y-m-d H:i:s', strtotime($data['wkt2']));
	    $no_surat = $data['no_surat'];
	    $tanggal_surat = date('Y-m-d', strtotime($data['tgl_surat']));
	    $penyelenggara = $data['penyelenggara'];
	    $status = $data['status'];
	    $id = $data['pid'];

	    $arr = array(
			'tema' => $tema,
		    'tempat' => $tempat,
		    'jum_peserta' => $jum_peserta,
		    'tanggal' => $tanggal,
		    'waktu_mulai' => $waktu_mulai,
		    'waktu_selesai' => $waktu_selesai,
		    'nomor_surat' => $no_surat,
		    'tanggal_surat' => $tanggal_surat,
		    'penyelenggara' => $penyelenggara,
		    'creator' => $_SESSION['user_id'],
		    'status' => $status
		);

	    $this->db->where('id', $id);
		$this->db->update('umum_ppkp', $arr);

		$aff = $this->db->affected_rows();

		if ($aff > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function get_all_ppkp() {
		$query = $this->db->get('umum_ppkp');
		if($query->num_rows() > 0){
			$data = $query->result_array();
		}
		else{
			$data = NULL;
		}
		return $data;
	}

	public function get_jum_ppkp() {
		$this->db->select('count(*) as jum_ppkp');
		$this->db->from('umum_ppkp');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$data = $query->result_array();
		}
		else{
			$data = NULL;
		}
		return $data;
	}

	public function get_ppkp_for_paginate_count($search, $tglawal, $tglakhir) {
		$this->db->select('count(*) as allcount');
		$this->db->from('umum_ppkp');
		if ($tglawal != ''){
			$this->db->where('tanggal_surat >=', $tglawal);
		}
		if ($tglakhir != ''){
			$this->db->where('tanggal_surat <=', $tglakhir);
		}
		if ($search != ''){
			$this->db->like('tema', $search);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	public function get_ppkp_for_paginate($rowno, $rowperpage, $search, $tglawal, $tglakhir) {
		$this->db->select('umum_ppkp.id ppkp_id, umum_ppkp.tema, umum_ppkp.tempat, DATE_FORMAT(umum_ppkp.tanggal, "%d/%m/%Y") tanggal, umum_ppkp.waktu_mulai, umum_ppkp.waktu_selesai, umum_ppkp.jum_peserta, umum_ppkp.nomor_surat, DATE_FORMAT(umum_ppkp.tanggal_surat, "%d/%m/%Y") tanggal_surat, umum_ppkp.penyelenggara, umum_ppkp.`status`, SUM(umum_ppkp_peserta.pre_test) pre_test, SUM(umum_ppkp_peserta.post_test) post_test');
		$this->db->from('umum_ppkp_peserta');
		$this->db->join('umum_ppkp', 'umum_ppkp_peserta.ppkp_id = umum_ppkp.id', 'right');
		if ($tglawal != ''){
			$this->db->where('umum_ppkp.tanggal_surat >=', $tglawal);
		}
		if ($tglakhir != ''){
			$this->db->where('umum_ppkp.tanggal_surat <=', $tglakhir);
		}
		if ($search != '') {
			$this->db->like('umum_ppkp.tema', $search);
		}
		$this->db->group_by('umum_ppkp.id');
		$this->db->order_by('umum_ppkp.tanggal_surat', 'ASC');
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function ppkp_score_by_ppkp_id() {
		$query = $this->db->query("SELECT b.id ppkp_id, a.pre_test, a.post_test FROM umum_ppkp_peserta a RIGHT JOIN umum_ppkp b ON a.ppkp_id = b.id GROUP BY a.id");
		if($query->num_rows() > 0){
			$data = $query->result_array();
			$datax = $data;
			$dataf = [];
			foreach ($data as $key => $value) {
				$datax[$key]['selisih'] = $value['post_test'] - $value['pre_test'];
				$f = $value['post_test'] - $value['pre_test'];
				if ($value['post_test'] >= 7) {
					$datax[$key]['score'] = 'E';
				} elseif ($value['post_test'] == 6) {
					if ($f >= 2) {
						$datax[$key]['score'] = 'E';
					} else {
						$datax[$key]['score'] = 'TE';
					}
				} elseif ($value['post_test'] == 5) {
					if ($f >= 3) {
						$datax[$key]['score'] = 'E';
					} else {
						$datax[$key]['score'] = 'TE';
					}
				} else {
					$datax[$key]['score'] = 'TE';
				}
			}

			function groupArray($arr, $group, $preserveGroupKey = false, $preserveSubArrays = false) {
			    $temp = array();
			    foreach($arr as $key => $value) {
			        $groupValue = $value[$group];
			        if(!$preserveGroupKey)
			        {
			            unset($arr[$key][$group]);
			        }
			        if(!array_key_exists($groupValue, $temp)) {
			            $temp[$groupValue] = array();
			        }

			        if(!$preserveSubArrays){
			            $data = count($arr[$key]) == 1? array_pop($arr[$key]) : $arr[$key];
			        } else {
			            $data = $arr[$key];
			        }
			        $temp[$groupValue][] = $data;
			    }
			    return $temp;
			}

			$arr = groupArray($datax, "ppkp_id");

			foreach ($arr as $key => $value) {
				$e = 0;
				$te = 0;
				$vv = 0;
				foreach ($value as $item) {
					if ($item['score'] == 'E') {
						$e += 1;
					}
					if ($item['score'] == 'TE') {
						$te += 1;
					}
					$vv += $item['post_test'];
				}
				$arr[$key]['Rerata post test semua peserta'] = $vv / count($value);
				$arr[$key]['Jumlah semua peserta'] = count($value);
				$arr[$key]['Peserta efektif'] = $e;
				$arr[$key]['Peserta tidak efektif'] = $te;
				$arr[$key]['Score per pppkp'] = (((50/100 * $e) / count($value)) + ((50/100 * $vv / count($value)) / 10));
			}

			$jum_score = 0;
			$jum_ppkp = 0;
			foreach ($arr as $key => $value) {
				$jum_score += $value['Score per pppkp'];
				$jum_ppkp += 1;
			}
			

			$dataf['jum_score'] = $jum_score * 100;
			$dataf['jum_ppkp'] = $jum_ppkp;
			$dataf['score'] = $jum_score / $jum_ppkp * 100;
			
		}
		else{
			return $data = NULL;
		}
		return $dataf;
	}

	public function get_ppkp_by_id($ppkp_id = null) {
		$query = $this->db->query("SELECT  a.id, a.tema, a.tempat, a.tanggal, a.waktu_mulai, a.waktu_selesai, a.jum_peserta, a.nomor_surat, a.tanggal_surat, a.penyelenggara, a.`status`, (SELECT COUNT(I1.id) FROM umum_ppkp_peserta I1 WHERE I1.kehadiran = 'Y' AND I1.ppkp_id = '$ppkp_id') as hadir, (SELECT COUNT(I2.id) FROM umum_ppkp_peserta I2 WHERE I2.kehadiran = 'N' AND I2.ppkp_id = '$ppkp_id') AS tidak_hadir FROM umum_ppkp a WHERE a.id = '$ppkp_id'");

		if ($query->num_rows() > 0) {
			$data = $query->result_array();
		}
		else {
			$data = NULL;
		}
		return $data;
	}

	public function get_user_detail_for_paginate_count($search, $pid) {
		$this->db->select('count(*) as allcount');
		$this->db->from('umum_ppkp_peserta');
		$this->db->where('ppkp_id', $pid); 
		if ($search != ''){
			$this->db->like('nama', $search);
			// $this->db->or_like('role', $search);
		}
		$query = $this->db->get();
		$result = $query->result_array();

		return $result[0]['allcount'];
	}

	public function get_user_detail_for_paginate($rowno, $rowperpage, $search, $pid) {
		$this->db->select('id, nama, nip, kehadiran, pre_test, post_test');
		$this->db->from('umum_ppkp_peserta');
		$this->db->where('ppkp_id', $pid); 
		if ($search != ''){
			$this->db->like('nama', $search);
			// $this->db->or_like('role', $search);
		}
		$this->db->order_by('nama', 'ASC');
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_privils_ref_detail_for_paginate_count($search) {
		$query = $this->db->query("SELECT COUNT(*) AS allcount FROM profile WHERE nama LIKE '%$search%'");
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	public function get_privils_ref_detail_for_paginate($rowno, $rowperpage, $search, $pid) {
		$query = $this->db->query("SELECT id, nama, nip, kehadiran FROM (SELECT a.id, a.nip, a.nama, b.kehadiran FROM profile a INNER JOIN umum_ppkp_peserta b ON a.nip = b.nip WHERE b.ppkp_id = '$pid' UNION SELECT r.id, r.nip, r.nama, 'nan' FROM profile r WHERE r.nama NOT IN (SELECT t.nama FROM umum_ppkp_peserta t WHERE t.ppkp_id = '$pid')) a WHERE a.nama LIKE '%$search%' ORDER BY a.nama ASC LIMIT $rowno, $rowperpage");
		return $query->result_array();
	}

	public function tambah_peserta_ppkp($pid, $nama, $nip) {
		$this->db->from('umum_ppkp_peserta');
		$this->db->where('nip', $nip);
		$this->db->where('ppkp_id', $pid);
		$r = $this->db->get()->num_rows();
		if ($r > 0) {
			echo "Sudah terdaftar";
		} else {
			$arr = array(
				'nama' => $nama,
				'nip' => $nip,
				'ppkp_id' => $pid
			);

			$this->db->insert('umum_ppkp_peserta', $arr);

			$aff = $this->db->affected_rows();

			if ($aff > 0) {

				return true;
			} else {
				return false;
			}
		}
	}

	public function hapus_peserta_ppkp($pid, $nama, $nip) {

		$this->db->from('umum_ppkp_peserta');
		$this->db->where('nip', $nip);
		$this->db->where('ppkp_id', $pid);
		$r = $this->db->get()->num_rows();

		if ($r > 0) {

			$q = $this->db->query("SELECT id, nama, nip FROM umum_ppkp_peserta WHERE nip = '$nip' AND ppkp_id = '$pid'");
			$qresult = $q->result_array();
			$tbid = $qresult[0]['id'];

			$arr = array(
				'table_name' => 'umum_ppkp_peserta',
				'table_id' => $tbid,
				'user_action' => 'Hapus peserta PPKP, nama ' . $qresult[0]['nama'] . ', nip ' . $qresult[0]['nip'],
				'user_id' => $pid
			);

			$this->db->insert('user_logs', $arr);

			$this->db->where('nip', $nip);
			$this->db->where('ppkp_id', $pid);

			$this->db->delete('umum_ppkp_peserta');
		
			$aff = $this->db->affected_rows();

			if ($aff > 0) {
				return true;
			} else {
				return false;
			}

		} else {
			echo "Nothing to delete";
		}
	}

	public function absen_tidak_hadir($tbid) {
		$this->db->from('umum_ppkp_peserta');
		$this->db->where('id', $tbid);
		$this->db->where('kehadiran', 'Y');
		$r = $this->db->get()->num_rows();
		if ($r > 0) {
			$this->db->where('id', $tbid);

			$arr = array(
				"kehadiran" => 'N',
				"pre_test" => '',
				"post_test" => ''
			); 

			$this->db->update('umum_ppkp_peserta', $arr);

			$aff = $this->db->affected_rows();

			if ($aff > 0) {
				return true;
			} else {
				return false;
			}

		} else {
			echo "Nothing to update";
		}
	}

	public function absen_hadir($tbid) {
		$this->db->from('umum_ppkp_peserta');
		$this->db->where('id', $tbid);
		$this->db->where('kehadiran', 'N');
	
		$r = $this->db->get()->num_rows();
		if ($r > 0) {

			$arr = array(
				"kehadiran" => 'Y'
			); 

			$this->db->where('id', $tbid);
			$this->db->update('umum_ppkp_peserta', $arr);

			$aff = $this->db->affected_rows();

			if ($aff > 0) {
				return true;
			} else {
				return false;
			}

		} else {
			echo "Nothing to update";
		}
	}

	public function scoring($tbid) {
		$query = $this->db->query("SELECT * FROM umum_ppkp_peserta WHERE id = '$tbid'");
		return json_encode($query->result_array()[0]);
	}

	public function scoring_($tbid, $pre_test, $post_test) {
		$this->db->from('umum_ppkp_peserta');
		$this->db->where('id', $tbid);
		$this->db->where('kehadiran', 'Y');
		$r = $this->db->get()->num_rows();

		if ($r > 0) {

			$arr = array(
				'pre_test' => $pre_test,
				'post_test' => $post_test
			);

			$this->db->where('id', $tbid);
			$this->db->update('umum_ppkp_peserta', $arr);
		
			$aff = $this->db->affected_rows();

			if ($aff > 0) {
				return true;
			} else {
				return false;
			}

		} else {
			echo "Nothing to update";
		}
	}
}