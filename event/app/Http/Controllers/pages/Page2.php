<?php

namespace App\Http\Controllers\pages;

use App\Models\Cabang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PDF;
use App\Helpers\Helpers as Helper;
use App\Exports\ListEventExport;
use Maatwebsite\Excel\Facades\Excel;

class Page2 extends Controller
{
  public function index()
  {
    //$cabang = Cabang::where('caktif', '1')
    //           ->orderBy('cnama')
    //           ->get();

    $cloc = session('cloc', '');
    $cjab = session('cjab', '');

    $protek_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/cek_unverified_event', [
      'json' => ['cloc' => $cloc, 'cjab' => $cjab],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    $cabang_res = Http::get('http://bbm-bams.co.id/sparepart_api/v1/region', [
      'json' => ['cloc' => $cloc, 'cjab' => $cjab],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    $no_event_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_no_event', [
      'json' => ['cloc' => $cloc],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    $alokasi_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_lokasi', [
      'json' => [],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    $kota_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_kota', [
      'json' => [],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    $kota  = $kota_res->json()['result'];

    $cabang  = $cabang_res->json()['result'];
    $nm_spv = session('cnm_lengkap', '');
    $kd_spv = session('kode_peg', '');
    $no_event = $no_event_res->json()['result']['no_event'];
    $lokasi  = $alokasi_res->json()['result'];

    //var_dump($no_event_res->json()['result']['no_event']);

    if (session()->has('username')) {

      // if($protek_res->json()['status'] == 'OK'){
      if (TRUE) {

        return view('content.pages.pages-page2', ['cabang' => $cabang, 'nm_spv' => $nm_spv, 'kd_spv' => $kd_spv, 'no_event' => $no_event, 'lokasi' => $lokasi, 'kota' => $kota]);
      } else {

        $err_msg = "";
        foreach ($protek_res->json()['result'] as $event_no_ver) {

          if ($err_msg == '') {
            $err_msg = $event_no_ver['cnmr_event'];
          } else {
            $err_msg = $err_msg . ',' . $event_no_ver['cnmr_event'];
          }
        }

        if ($err_msg != '') {
          $err_msg1 = 'Report Nomor Event ' . $err_msg . ' belum di verifikasi.';
        } else {
          $err_msg1 = 'Gagal mengecek event yang reportnya belum di verifikasi.';
        }

        redirect()->route('auth-notif', ['msg' => $err_msg1, 'type' => 'warning', 'redir' => route('event-list')])->send();
      }
    } else {

      $err_msg = 'Anda belum login.';
      redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
    }
  }

  public function save_event_proses(Request $request)
  {
    $no_event = $request->input('no_event');
    $tgl_pengajuan = $request->input('tgl_pengajuan');
    $kategori = $request->input('kategori');
    $tipe_kegiatan = $request->input('tipe_kegiatan');
    $cabang = $request->input('cabang');
    $nm_spv = $request->input('nm_spv');
    $ckode_spv = $request->input('ckode_spv');
    $tgl_mulai = $request->input('tgl_mulai');
    $tgl_selesai = $request->input('tgl_selesai');
    $lokasi = $request->input('lokasi');

    if ($request->has('tipe_xforce')) {
      $tipe_xforce = $request->input('tipe_xforce');
    } else {
      $tipe_xforce = '';
    }

    if ($request->has('tipe_xpander')) {
      $tipe_xpander = $request->input('tipe_xpander');
    } else {
      $tipe_xpander = '';
    }

    if ($request->has('tipe_xpander_cross')) {
      $tipe_xpander_cross = $request->input('tipe_xpander_cross');
    } else {
      $tipe_xpander_cross = '';
    }

    if ($request->has('tipe_pajero_sport')) {
      $tipe_pajero_sport = $request->input('tipe_pajero_sport');
    } else {
      $tipe_pajero_sport = '';
    }

    if ($request->has('tipe_l300')) {
      $tipe_l300 = $request->input('tipe_l300');
    } else {
      $tipe_l300 = '';
    }

    if ($request->has('tipe_colt_diesel')) {
      $tipe_colt_diesel = $request->input('tipe_colt_diesel');
    } else {
      $tipe_colt_diesel = '';
    }

    if ($request->has('tipe_fuso')) {
      $tipe_fuso = $request->input('tipe_fuso');
    } else {
      $tipe_fuso = '';
    }

    if ($request->has('eclipse_cross')) {
      $eclipse_cross = $request->input('eclipse_cross');
    } else {
      $eclipse_cross = '';
    }

    if ($request->has('triton_dc')) {
      $triton_dc = $request->input('triton_dc');
    } else {
      $triton_dc = '';
    }

    if ($request->has('triton_sc')) {
      $triton_sc = $request->input('triton_sc');
    } else {
      $triton_sc = '';
    }

    $target_database = $request->input('target_database');
    $target_prospek = $request->input('target_prospek');
    $target_spk_ots = $request->input('target_spk_ots');
    $target_spk_fu = $request->input('target_spk_fu');
    $total = $request->input('total');
    $per_prspk = $request->input('per_prspk');
    $per_spk = $request->input('per_spk');
    $area_display = $request->file('area_display');
    $area_display2 = $request->file('area_display2');
    $lokasi_pameran = $request->file('lokasi_pameran');
    $surat_penawaran = $request->file('surat_penawaran');
    $tampak_luar = $request->file('tampak_luar');
    $lokasi_gmaps = $request->file('lokasi_gmaps');
    $user_create = session('username', '');
    $status = $request->input('status');
    $note_spv = $request->input('note_spv');

    //Detail Biaya
    $nama_biaya = $request->input('nama_biaya');
    $qty = $request->input('qty');
    $uom = $request->input('uom');
    $harga = $request->input('harga');
    $keterangan = $request->input('keterangan');

    //var_dump($request->input('nama_biaya'));
    $area_display_nm = "";
    $area_display_src = "";
    $area_display2_nm = "";
    $area_display2_src = "";
    $lokasi_pameran_nm = "";
    $lokasi_pameran_src = "";
    $surat_penawaran_nm = "";
    $surat_penawaran_src = "";
    $tampak_luar_nm = "";
    $tampak_luar_src = "";
    $lokasi_gmaps_nm = "";
    $lokasi_gmaps_src = "";

    $tujuan_upload = 'event_file';
    $err_msg_upl = "";

    $nama_file1 = "";
    $nama_file2 = "";
    $nama_file3 = "";
    $nama_file4 = "";
    $nama_file5 = "";
    $nama_file6 = "";

    if ($request->hasFile('area_display') && $request->file('area_display')->isValid()) {

      $area_display_nm = $area_display->getClientOriginalExtension();
      $nama_file1 = 'area_display_' . time() . '.' . $area_display_nm;

      if (!$area_display->move($tujuan_upload, $nama_file1)) {
        $nama_file1 = "";
        $err_msg_upl = "Gagal Upload file Area Display, ";
      }
    }

    if ($request->hasFile('area_display2') && $request->file('area_display2')->isValid()) {

      $area_display2_nm = $area_display2->getClientOriginalExtension();
      $nama_file2 = 'area_display2_' . time() . '.' . $area_display2_nm;

      if (!$area_display2->move($tujuan_upload, $nama_file2)) {
        $nama_file2 = "";
        if ($err_msg_upl == "") {
          $err_msg_upl = "Gagal Upload file Area Display2, ";
        } else {
          $err_msg_upl = $err_msg_upl . "Gagal Upload file Area Display2, ";
        }
      }
    }

    if ($request->hasFile('lokasi_pameran') && $request->file('lokasi_pameran')->isValid()) {

      $lokasi_pameran_nm = $lokasi_pameran->getClientOriginalExtension();
      $nama_file3 = 'lokasi_pameran_' . time() . '.' . $lokasi_pameran_nm;

      if (!$lokasi_pameran->move($tujuan_upload, $nama_file3)) {
        $nama_file3 = "";
        if ($err_msg_upl == "") {
          $err_msg_upl = "Gagal Upload file Lokasi Pameran, ";
        } else {
          $err_msg_upl = $err_msg_upl . "Gagal Upload file Lokasi Pameran, ";
        }
      }
    }

    if ($request->hasFile('surat_penawaran') && $request->file('surat_penawaran')->isValid()) {

      $surat_penawaran_nm = $surat_penawaran->getClientOriginalExtension();
      $nama_file4 = 'surat_penawaran_' . time() . '.' . $surat_penawaran_nm;

      if (!$surat_penawaran->move($tujuan_upload, $nama_file4)) {
        $nama_file4 = "";
        if ($err_msg_upl == "") {
          $err_msg_upl = "Gagal Upload file Surat Penawaran.";
        } else {
          $err_msg_upl = $err_msg_upl . "Gagal Upload file Surat Penawaran, ";
        }
      }
    }

    if ($request->hasFile('tampak_luar') && $request->file('tampak_luar')->isValid()) {

      $tampak_luar_nm = $tampak_luar->getClientOriginalExtension();
      $nama_file5 = 'tampak_luar_' . time() . '.' . $tampak_luar_nm;

      if (!$tampak_luar->move($tujuan_upload, $nama_file5)) {
        $nama_file5 = "";
        if ($err_msg_upl == "") {
          $err_msg_upl = "Gagal Upload file Tampak Luar Gedung/Area Pameran.";
        } else {
          $err_msg_upl = $err_msg_upl . "Gagal Upload file Tampak Luar Gedung/Area Pameran, ";
        }
      }
    }

    if ($request->hasFile('lokasi_gmaps') && $request->file('lokasi_gmaps')->isValid()) {

      $lokasi_gmaps_nm = $lokasi_gmaps->getClientOriginalExtension();
      $nama_file6 = 'lokasi_gmaps_' . time() . '.' . $lokasi_gmaps_nm;

      if (!$lokasi_gmaps->move($tujuan_upload, $nama_file6)) {
        $nama_file6 = "";
        if ($err_msg_upl == "") {
          $err_msg_upl = "Gagal Upload file Screenshot Lokasi Pameran di GMaps.";
        } else {
          $err_msg_upl = $err_msg_upl . "Gagal Upload file Screenshot Lokasi Pameran di GMaps.";
        }
      }
    }
	
	/*dd([
        'status' => $status,
        'no_event' => $no_event,
        'tgl_pengajuan' => $tgl_pengajuan,
        'kategori' => $kategori,
        'tipe_kegiatan' => $tipe_kegiatan,
        'cabang' => $cabang,
        'nm_spv' => $nm_spv,
        'ckode_spv' => $ckode_spv,
        'tgl_mulai' => $tgl_mulai,
        'tgl_selesai' => $tgl_selesai,
        'lokasi' => $lokasi,
        'tipe_xforce' => $tipe_xforce,
        'tipe_xpander' => $tipe_xpander,
        'tipe_xpander_cross' => $tipe_xpander_cross,
        'tipe_pajero_sport' => $tipe_pajero_sport,
        'tipe_l300' => $tipe_l300,
        'tipe_colt_diesel' => $tipe_colt_diesel,
        'tipe_fuso' => $tipe_fuso,
        'eclipse_cross' => $eclipse_cross,
        'triton_dc' => $triton_dc,
        'triton_sc' => $triton_sc,
        'target_database' => $target_database,
        'target_prospek' => $target_prospek,
        'target_spk_ots' => $target_spk_ots,
        'target_spk_fu' => $target_spk_fu,
        'total' => $total,
        'per_prspk' => $per_prspk,
        'per_spk' => $per_spk,
        'nama_biaya' => $nama_biaya,
        'qty' => $qty,
        'uom' => $uom,
        'harga' => $harga,
        'keterangan' => $keterangan,
        'user_create' => $user_create,
        'area_display_nm' => $nama_file1,
        'area_display2_nm' => $nama_file2,
        'lokasi_pameran_nm' => $nama_file3,
        'surat_penawaran_nm' => $nama_file4,
        'foto_tampak_luar_nm' => $nama_file5,
        'foto_lokasi_gmaps_nm' => $nama_file6,
        'note_spv' => $note_spv
      ]);*/
	
    $response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/simpan_event_sales', [
      'json' => [
        'status' => $status,
        'no_event' => $no_event,
        'tgl_pengajuan' => $tgl_pengajuan,
        'kategori' => $kategori,
        'tipe_kegiatan' => $tipe_kegiatan,
        'cabang' => $cabang,
        'nm_spv' => $nm_spv,
        'ckode_spv' => $ckode_spv,
        'tgl_mulai' => $tgl_mulai,
        'tgl_selesai' => $tgl_selesai,
        'lokasi' => $lokasi,
        'tipe_xforce' => $tipe_xforce,
        'tipe_xpander' => $tipe_xpander,
        'tipe_xpander_cross' => $tipe_xpander_cross,
        'tipe_pajero_sport' => $tipe_pajero_sport,
        'tipe_l300' => $tipe_l300,
        'tipe_colt_diesel' => $tipe_colt_diesel,
        'tipe_fuso' => $tipe_fuso,
        'eclipse_cross' => $eclipse_cross,
        'triton_dc' => $triton_dc,
        'triton_sc' => $triton_sc,
        'target_database' => $target_database,
        'target_prospek' => $target_prospek,
        'target_spk_ots' => $target_spk_ots,
        'target_spk_fu' => $target_spk_fu,
        'total' => $total,
        'per_prspk' => $per_prspk,
        'per_spk' => $per_spk,
        'nama_biaya' => $nama_biaya,
        'qty' => $qty,
        'uom' => $uom,
        'harga' => $harga,
        'keterangan' => $keterangan,
        'user_create' => $user_create,
        'area_display_nm' => $nama_file1,
        'area_display2_nm' => $nama_file2,
        'lokasi_pameran_nm' => $nama_file3,
        'surat_penawaran_nm' => $nama_file4,
        'foto_tampak_luar_nm' => $nama_file5,
        'foto_lokasi_gmaps_nm' => $nama_file6,
        'note_spv' => $note_spv
      ],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    /*$array_cek = array('json' => [
				'status' => $status,
                'no_event' => $no_event,
                'tgl_pengajuan' => $tgl_pengajuan,
				'kategori' => $kategori,
				'tipe_kegiatan' => $tipe_kegiatan,
				'cabang' => $cabang,
				'nm_spv' => $nm_spv,
				'ckode_spv' => $ckode_spv,
				'tgl_mulai' => $tgl_mulai,
				'tgl_selesai' => $tgl_selesai,
				'lokasi' => $lokasi,
				'tipe_xpander' => $tipe_xpander,
				'tipe_xpander_cross' => $tipe_xpander_cross,
				'tipe_pajero_sport' => $tipe_pajero_sport,
				'tipe_l300' => $tipe_l300,
				'tipe_colt_diesel' => $tipe_colt_diesel,
				'tipe_fuso' => $tipe_fuso,
				'target_database' => $target_database,
				'target_prospek' => $target_prospek,
				'target_spk_ots' => $target_spk_ots,
				'target_spk_fu' => $target_spk_fu,
				'total' => $total,
				'per_prspk' => $per_prspk,
				'per_spk' => $per_spk,
				'nama_biaya' => $nama_biaya,
				'qty' => $qty,
				'uom' => $uom,
				'harga' => $harga,
				'keterangan' => $keterangan,
				'user_create' => $user_create,
				'area_display_nm' => $nama_file1,
				'area_display2_nm' => $nama_file2,
				'lokasi_pameran_nm' => $nama_file3,
				'surat_penawaran_nm' => $nama_file4,
                ]);

	echo json_encode($array_cek);*/

    //var_dump($response['result']);
	
    if (!$response->successful()) {

      $err_msg = 'Gagal menyimpan data.';
      // dd($response);
      redirect()->route('auth-notif', ['msg' => 'Gagal menyimpan data.', 'type' => 'error', 'redir' => route('pages-home')])->send();
    } else {

      if ($response['message'] == 'Success') {

        if ($err_msg_upl == "") {

          redirect()->route('auth-notif', ['msg' => 'Berhasil menyimpan data.', 'type' => 'success', 'redir' => route('pages-home')])->send();
        } else {

          $err_msg = "Berhasil menyimpan data event, tetapi " . $err_msg_upl;

          redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('pages-home')])->send();
        }
      } else {

        $err_msg = $response['message'];

        redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('pages-home')])->send();
      }
    }
  }

  public function list_event()
  {
    $cloc = session('cloc', '');

    if (session()->has('username')) {

      return view('content.pages.pages-event-list', ['cloc' => $cloc]);
    } else {

      $err_msg = 'Anda belum login.';
      redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
    }
  }

  public function get_data_list_event(Request $request)
  {
    $cloc = session('cloc', '');
    $username = session('username', '');
    $cjab = session('cjab', '');

    $date_start = $request->input('date_start');
    $date_finish = $request->input('date_finish');
    $search = $request->input('search');

    $list_event_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_list_event', [
      'json' => ['cloc' => $cloc, 'cjab' => $cjab, 'date_start' => $date_start, 'date_finish' => $date_finish, 'search' => $search],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    //var_dump($list_event_res->json()['result']);

    $list_event_  = $list_event_res->json()['result'];
    $list_events = array();

    if (is_array($list_event_)) {
      $count_arr = count($list_event_);
    } else {
      $count_arr = 0;
    }


    if ($count_arr > 0) {

      for ($x = 0; $x < count($list_event_); $x++) {
        $list_events[$x]["cnmr_event"] = $list_event_[$x]["cnmr_event"];
        $list_events[$x]["dtgl_pengajuan"] = date_format(date_create($list_event_[$x]["dtgl_pengajuan"]), "d-m-Y");
        $list_events[$x]["ckat"] = $list_event_[$x]["ckat"];

        if ($list_event_[$x]["ctipe"] == "0") {
          $list_events[$x]["tipe"] = "Pameran";
        } else if ($list_event_[$x]["ctipe"] == "1") {
          $list_events[$x]["tipe"] = "Display";
        } else if ($list_event_[$x]["ctipe"] == "2") {
          $list_events[$x]["tipe"] = "Kanvasing";
        } else if ($list_event_[$x]["ctipe"] == "3") {
          $list_events[$x]["tipe"] = "Gathering";
        } else if ($list_event_[$x]["ctipe"] == "4") {
          $list_events[$x]["tipe"] = "Sponsorship";
        } else if ($list_event_[$x]["ctipe"] == "5") {
          $list_events[$x]["tipe"] = "Showroom Event";
        } else if ($list_event_[$x]["ctipe"] == "6") {
          $list_events[$x]["tipe"] = "Office Event";
        } else if ($list_event_[$x]["ctipe"] == "7") {
          $list_events[$x]["tipe"] = "Public Area Event";
        } else if ($list_event_[$x]["ctipe"] == "8") {
          $list_events[$x]["tipe"] = "Test Drive Event";
        } else if ($list_event_[$x]["ctipe"] == "9") {
          $list_events[$x]["tipe"] = "Open Table";
        } else if ($list_event_[$x]["ctipe"] == "10") {
          $list_events[$x]["tipe"] = "Above The Line";
        } else if ($list_event_[$x]["ctipe"] == "11") {
          $list_events[$x]["tipe"] = "Event ATPM";
        } else {
          $list_events[$x]["tipe"] = "";
        }

        if ($list_event_[$x]["csta_pengajuan"] == "0") {
          $list_events[$x]["sta_pengajuan"] = "Kepala Cabang";
        } else if ($list_event_[$x]["csta_pengajuan"] == "1") {
          $list_events[$x]["sta_pengajuan"] = "Marketing";
        } else if ($list_event_[$x]["csta_pengajuan"] == "2") {
          $list_events[$x]["sta_pengajuan"] = "NOH";
        } else if ($list_event_[$x]["csta_pengajuan"] == "3") {
          $list_events[$x]["sta_pengajuan"] = "COO";
        } else if ($list_event_[$x]["csta_pengajuan"] == "4") {
          //$list_events[$x]["sta_pengajuan"] = "Disetujui";
          $list_events[$x]["sta_pengajuan"] = "NOH";
        } else {
          $list_events[$x]["sta_pengajuan"] = "";
        }

        $list_events[$x]["cabang"] = $list_event_[$x]["cabang"];
        $list_events[$x]["cnama_spv"] = $list_event_[$x]["cnama_spv"];
        $list_events[$x]["dtgl_kegiatan"] = date_format(date_create($list_event_[$x]["dtgl_start"]), "d-m-Y") . " s/d " . date_format(date_create($list_event_[$x]["dtgl_finish"]), "d-m-Y");
        $list_events[$x]["lokasi"] = $list_event_[$x]["lokasi"];

        if ($list_event_[$x]["cstatus"] == "0") {
          $list_events[$x]["status"] = '<span class="badge bg-label-primary me-1">Pengajuan Baru</span>';
        } else if ($list_event_[$x]["cstatus"] == "1") {
          // $date_today = date('Y-m-d');
          // $date_start = date('Y-m-d', strtotime($list_event_[$x]["dtgl_start"]));
          // $date_finish = date('Y-m-d', strtotime($list_event_[$x]["dtgl_finish"]));
          // $date_h3 = date('Y-m-d', strtotime($list_event_[$x]["dtgl_finish"] . '+3 days'));
          // $date_h30 = date('Y-m-d', strtotime($list_event_[$x]["dtgl_finish"] . '+30 days'));
          // if ($date_today < $date_start) {
          //   $list_events[$x]["status"] = '<span class="badge bg-label-info me-1">Sedang Diproses</span>';
          // } else if ($date_today >= $date_start && $date_today <= $date_finish) {
          //   $list_events[$x]["status"] = '<span class="badge bg-label-info me-1">Sedang Berlangsung</span>';
          // } else if ($date_today > $date_h3 && $date_today <= $date_h30) {
          //   $list_events[$x]["status"] = '<span class="badge bg-label-warning me-1">Database Complete</span>';
          // } else if ($date_today > $date_h30) {
          //   $list_events[$x]["status"] = '<span class="badge bg-label-success me-1">Selesai</span>';
          // } else {
          //   $list_events[$x]["status"] = '';
          // }
          $list_events[$x]["status"] = '<span class="badge bg-label-info me-1">Sedang Diproses</span>';
        }/*else if($list_event_[$x]["cstatus"] == "2"){
				$list_events[$x]["status"] = '<span class="badge bg-label-danger me-1">Batal</span>';
			}*/ else if ($list_event_[$x]["cstatus"] == "3" || $list_event_[$x]["cstatus"] == "2") {
          $list_events[$x]["status"] = '<span class="badge bg-label-danger me-1">Ditolak</span>';
        } else {
          $list_events[$x]["status"] = "";
        }

        $cnmr_event_base = base64_encode($list_event_[$x]["cnmr_event"]);

        if ($list_event_[$x]["cstatus"] == "1") {
          $graf = '<a class="dropdown-item" href="javascript:void(0);" onclick="javascript:model_show_chart(' . "'" . $list_event_[$x]["cnmr_event"] . "'" . ');return false;"><i class="bx bxs-bar-chart-alt-2 me-2"></i> Activity Report</a>';
        } else {
          $graf = '';
        }

        if ($list_event_[$x]["cstatus"] == "1" && $list_event_[$x]["csta_pengajuan"] == "4") {
          $letter = '<a class="dropdown-item" href="' . url('print_approval_event') . '?no_event=' . $cnmr_event_base . '" target="_BLANK"><i class="bx bxs-edit me-2"></i>Print Event</a>';
        } else {
          $letter = '';
        }

        $report_event_1 = "";
        $report_event_2 = "";
        $report_event_3 = "";
        $report_event_4 = "";
        $report_event_5 = "";
        $report_event_6 = "";
        $report_event_7 = "";
        $report_event_8 = "";
        $report_event_9 = "";
        $report_event_10 = "";
        $report_event_11 = "";
        $report_event_12 = "";

        if ($list_event_[$x]["creport_event_1"] != "") {
          $report_event_1 = url('storage_event') . "/" . $list_event_[$x]["creport_event_1"];
        }

        if ($list_event_[$x]["creport_event_2"] != "") {
          $report_event_2 = url('storage_event') . "/" . $list_event_[$x]["creport_event_2"];
        }

        if ($list_event_[$x]["creport_event_3"] != "") {
          $report_event_3 = url('storage_event') . "/" . $list_event_[$x]["creport_event_3"];
        }

        if ($list_event_[$x]["creport_event_4"] != "") {
          $report_event_4 = url('storage_event') . "/" . $list_event_[$x]["creport_event_4"];
        }

        if ($list_event_[$x]["creport_event_5"] != "") {
          $report_event_5 = url('storage_event') . "/" . $list_event_[$x]["creport_event_5"];
        }

        if ($list_event_[$x]["creport_event_6"] != "") {
          $report_event_6 = url('storage_event') . "/" . $list_event_[$x]["creport_event_6"];
        }

        if ($list_event_[$x]["creport_event_7"] != "") {
          $report_event_7 = url('storage_event') . "/" . $list_event_[$x]["creport_event_7"];
        }

        if ($list_event_[$x]["creport_event_8"] != "") {
          $report_event_8 = url('storage_event') . "/" . $list_event_[$x]["creport_event_8"];
        }

        if ($list_event_[$x]["creport_event_9"] != "") {
          $report_event_9 = url('storage_event') . "/" . $list_event_[$x]["creport_event_9"];
        }

        if ($list_event_[$x]["creport_event_10"] != "") {
          $report_event_10 = url('storage_event') . "/" . $list_event_[$x]["creport_event_10"];
        }

        if ($list_event_[$x]["creport_event_11"] != "") {
          $report_event_11 = url('storage_event') . "/" . $list_event_[$x]["creport_event_11"];
        }

        if ($list_event_[$x]["creport_event_12"] != "") {
          $report_event_12 = url('storage_event') . "/" . $list_event_[$x]["creport_event_12"];
        }

        $date_now = date_create();
        $date_finish = date_create($list_event_[$x]["dtgl_finish"]);

        if ($list_event_[$x]["cstatus"] == "1" && $cjab == "Marketing" && $date_finish > $date_now) {
          $cancels = '<a class="dropdown-item" href="javascript:void(0);" onclick="javascript:model_cancel_event(' . "'" . $list_event_[$x]["cnmr_event"] . "'" . ');return false;"><i class="bx bx-window-close me-2"></i> Cancel</a>';
        } else {
          $cancels = '';
        }

        if ($cjab == "Marketing") {
          $all_ver = '1';
        } else {
          $all_ver = '';
        }

        $list_events[$x]["aksi"] = '<div class="dropdown">
											  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
											  <div class="dropdown-menu">
												<a class="dropdown-item" href="/edit_event_list?no_event=' . $cnmr_event_base . '"><i class="bx bxs-edit me-2"></i> Edit</a>
												' . $graf . '
												' . $letter . '
												<a class="dropdown-item" href="javascript:void(0);" onclick="javascript:model_report(' . "'" . $list_event_[$x]["cnmr_event"] . "'" . ',' . "'" . $report_event_1 . "'" . ',' . "'" . $report_event_2 . "'" . ',' . "'" . $report_event_3 . "'" . ',' . "'" . $report_event_4 . "'" . ',' . "'" . $report_event_5 . "'" . ',' . "'" . $report_event_6 . "'" . ',' . "'" . $report_event_7 . "'" . ',' . "'" . $report_event_8 . "'" . ',' . "'" . $report_event_9 . "'" . ',' . "'" . $report_event_10 . "'" . ',' . "'" . $report_event_11 . "'" . ',' . "'" . $report_event_12 . "'" . ',' . "'" . $list_event_[$x]["csta_verifikasi_report"] . "'" . ',' . "'" . $all_ver . "'" . ');return false;"><i class="bx bx-edit-alt me-2"></i> Report</a>
												<!--<a class="dropdown-item" href="javascript:void(0);" onclick="javascript:model_report(' . "'2'" . ',' . "'" . $list_event_[$x]["cnmr_event"] . "'" . ',' . "'" . $report_event_2 . "'" . ');return false;"><i class="bx bx-edit-alt me-2"></i> Report 2</a>-->
												' . $cancels . '
											  </div>
											</div>';
      }
    }

    $list_event_arr  = array(
      "data" => $list_events
    );

    echo json_encode($list_event_arr);
  }

  public function edit_event_list(Request $request)
  {
    $no_event_ = $request['no_event'];

    $no_event = base64_decode($no_event_);

    $cloc = session('cloc', '');
    $cjab = session('cjab', '');

    //echo $no_event;

    $cabang_res = Http::get('http://bbm-bams.co.id/sparepart_api/v1/region', [
      'json' => ['cloc' => $cloc, 'cjab' => $cjab],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    $alokasi_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_lokasi', [
      'json' => [],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    $detail_event = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_detail_event', [
      'json' => ['no_event' => $no_event],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    $cabang  = $cabang_res->json()['result'];
    $lokasi  = $alokasi_res->json()['result'];
    $list_event_  = $detail_event->json()['result'];
    $detail_rincian_event_ = array();

    if (is_array($list_event_)) {
      $count_arr_detail = count($list_event_);
    } else {
      $count_arr_detail = 0;
    }

    if ($count_arr_detail > 0) {

      $detail_rincian_event = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_detail_biaya_event', [
        'json' => ['no_event' => $no_event],
        'headers' => [
          'Content-Type' => 'application/json',
        ]
      ]);

      if (isset($detail_rincian_event->json()['result'])) {
        $detail_rincian_event_  = $detail_rincian_event->json()['result'];
      }

      if (session()->has('username')) {

        //var_dump($detail_rincian_event_);

        return view('content.pages.pages-event-detail', ['cabang' => $cabang, 'list_event' => $list_event_[0], 'detail_rincian_event' => $detail_rincian_event_, 'lokasi' => $lokasi]);
      } else {

        $err_msg = 'Anda belum login.';
        redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
      }
    } else {

      if ($detail_event->json()['result'] == 'No Data') {
        $err_msg = 'Data Event No. ' . $no_event . ' Tidak Ditemukan';
      } else {
        $err_msg = $detail_event->json()['result'];
      }

      //var_dump($err_msg);

      redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('event-list')])->send();
    }
  }

  public function update_event_proses(Request $request)
  {
    $no_event = $request->input('no_event');
    $tgl_pengajuan = $request->input('tgl_pengajuan');
    $kategori = $request->input('kategori');
    $tipe_kegiatan = $request->input('tipe_kegiatan');
    $cabang = $request->input('cabang');
    $nm_spv = $request->input('nm_spv');
    $ckode_spv = $request->input('ckode_spv');
    $tgl_mulai = $request->input('tgl_mulai');
    $tgl_selesai = $request->input('tgl_selesai');
    $lokasi = $request->input('lokasi');

    if ($request->has('tipe_xforce')) {
      $tipe_xforce = $request->input('tipe_xforce');
    } else {
      $tipe_xforce = '';
    }

    if ($request->has('tipe_xpander')) {
      $tipe_xpander = $request->input('tipe_xpander');
    } else {
      $tipe_xpander = '';
    }

    if ($request->has('tipe_xpander_cross')) {
      $tipe_xpander_cross = $request->input('tipe_xpander_cross');
    } else {
      $tipe_xpander_cross = '';
    }

    if ($request->has('tipe_pajero_sport')) {
      $tipe_pajero_sport = $request->input('tipe_pajero_sport');
    } else {
      $tipe_pajero_sport = '';
    }

    if ($request->has('tipe_l300')) {
      $tipe_l300 = $request->input('tipe_l300');
    } else {
      $tipe_l300 = '';
    }

    if ($request->has('tipe_colt_diesel')) {
      $tipe_colt_diesel = $request->input('tipe_colt_diesel');
    } else {
      $tipe_colt_diesel = '';
    }

    if ($request->has('tipe_fuso')) {
      $tipe_fuso = $request->input('tipe_fuso');
    } else {
      $tipe_fuso = '';
    }

    if ($request->has('eclipse_cross')) {
      $eclipse_cross = $request->input('eclipse_cross');
    } else {
      $eclipse_cross = '';
    }

    if ($request->has('triton_dc')) {
      $triton_dc = $request->input('triton_dc');
    } else {
      $triton_dc = '';
    }

    if ($request->has('triton_sc')) {
      $triton_sc = $request->input('triton_sc');
    } else {
      $triton_sc = '';
    }

    $target_database = $request->input('target_database');
    $target_prospek = $request->input('target_prospek');
    $target_spk_ots = $request->input('target_spk_ots');
    $target_spk_fu = $request->input('target_spk_fu');
    $total = $request->input('total');
    $per_prspk = $request->input('per_prspk');
    $per_spk = $request->input('per_spk');
    $area_display = $request->file('area_display');
    $area_display2 = $request->file('area_display2');
    $lokasi_pameran = $request->file('lokasi_pameran');
    $surat_penawaran = $request->file('surat_penawaran');
    $tampak_luar = $request->file('tampak_luar');
    $lokasi_gmaps = $request->file('lokasi_gmaps');
    $user_create = session('username', '');
    $status = $request->input('status');
    $ket_cancel = $request->input('ket_cancel');
    $note_spv = $request->input('note_spv');

    //Detail Biaya
    $nama_biaya = $request->input('nama_biaya');
    $qty = $request->input('qty');
    $uom = $request->input('uom');
    $harga = $request->input('harga');
    $keterangan = $request->input('keterangan');

    //var_dump($request->input('nama_biaya'));
    $area_display_nm = "";
    $area_display_src = "";
    $area_display2_nm = "";
    $area_display2_src = "";
    $lokasi_pameran_nm = "";
    $lokasi_pameran_src = "";
    $surat_penawaran_nm = "";
    $surat_penawaran_src = "";
    $tampak_luar_nm = "";
    $tampak_luar_src = "";
    $lokasi_gmaps_nm = "";
    $lokasi_gmaps_src = "";

    $tujuan_upload = 'event_file';
    $err_msg_upl = "";

    $nama_file1 = "";
    $nama_file2 = "";
    $nama_file3 = "";
    $nama_file4 = "";
    $nama_file5 = "";
    $nama_file6 = "";

    if ($request->hasFile('area_display') && $request->file('area_display')->isValid()) {

      $area_display_nm = $area_display->getClientOriginalExtension();
      $nama_file1 = 'area_display_' . time() . '.' . $area_display_nm;

      if (!$area_display->move($tujuan_upload, $nama_file1)) {
        $nama_file1 = "";
        $err_msg_upl = "Gagal Upload file Area Display, ";
      }
    }

    if ($request->hasFile('area_display2') && $request->file('area_display2')->isValid()) {

      $area_display2_nm = $area_display2->getClientOriginalExtension();
      $nama_file2 = 'area_display2_' . time() . '.' . $area_display2_nm;

      if (!$area_display2->move($tujuan_upload, $nama_file2)) {
        $nama_file2 = "";
        if ($err_msg_upl == "") {
          $err_msg_upl = "Gagal Upload file Area Display2, ";
        } else {
          $err_msg_upl = $err_msg_upl . "Gagal Upload file Area Display2, ";
        }
      }
    }

    if ($request->hasFile('lokasi_pameran') && $request->file('lokasi_pameran')->isValid()) {

      $lokasi_pameran_nm = $lokasi_pameran->getClientOriginalExtension();
      $nama_file3 = 'lokasi_pameran_' . time() . '.' . $lokasi_pameran_nm;

      if (!$lokasi_pameran->move($tujuan_upload, $nama_file3)) {
        $nama_file3 = "";
        if ($err_msg_upl == "") {
          $err_msg_upl = "Gagal Upload file Lokasi Pameran, ";
        } else {
          $err_msg_upl = $err_msg_upl . "Gagal Upload file Lokasi Pameran, ";
        }
      }
    }

    if ($request->hasFile('surat_penawaran') && $request->file('surat_penawaran')->isValid()) {

      $surat_penawaran_nm = $surat_penawaran->getClientOriginalExtension();
      $nama_file4 = 'surat_penawaran_' . time() . '.' . $surat_penawaran_nm;

      if (!$surat_penawaran->move($tujuan_upload, $nama_file4)) {
        $nama_file4 = "";
        if ($err_msg_upl == "") {
          $err_msg_upl = "Gagal Upload file Surat Penawaran.";
        } else {
          $err_msg_upl = $err_msg_upl . "Gagal Upload file Surat Penawaran, ";
        }
      }
    }

    if ($request->hasFile('tampak_luar') && $request->file('tampak_luar')->isValid()) {

      $tampak_luar_nm = $tampak_luar->getClientOriginalExtension();
      $nama_file5 = 'tampak_luar_' . time() . '.' . $tampak_luar_nm;

      if (!$tampak_luar->move($tujuan_upload, $nama_file5)) {
        $nama_file5 = "";
        if ($err_msg_upl == "") {
          $err_msg_upl = "Gagal Upload file Tampak Luar Gedung/Area Pameran.";
        } else {
          $err_msg_upl = $err_msg_upl . "Gagal Upload file Tampak Luar Gedung/Area Pameran, ";
        }
      }
    }

    if ($request->hasFile('lokasi_gmaps') && $request->file('lokasi_gmaps')->isValid()) {

      $lokasi_gmaps_nm = $lokasi_gmaps->getClientOriginalExtension();
      $nama_file6 = 'lokasi_gmaps_' . time() . '.' . $lokasi_gmaps_nm;

      if (!$lokasi_gmaps->move($tujuan_upload, $nama_file6)) {
        $nama_file6 = "";
        if ($err_msg_upl == "") {
          $err_msg_upl = "Gagal Upload file Screenshot Lokasi Pameran di GMaps.";
        } else {
          $err_msg_upl = $err_msg_upl . "Gagal Upload file Screenshot Lokasi Pameran di GMaps.";
        }
      }
    }

    $response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/update_event_sales', [
      'json' => [
        'status' => $status,
        'no_event' => $no_event,
        'tgl_pengajuan' => $tgl_pengajuan,
        'kategori' => $kategori,
        'tipe_kegiatan' => $tipe_kegiatan,
        'cabang' => $cabang,
        'nm_spv' => $nm_spv,
        'ckode_spv' => $ckode_spv,
        'tgl_mulai' => $tgl_mulai,
        'tgl_selesai' => $tgl_selesai,
        'lokasi' => $lokasi,
        'tipe_xforce' => $tipe_xforce,
        'tipe_xpander' => $tipe_xpander,
        'tipe_xpander_cross' => $tipe_xpander_cross,
        'tipe_pajero_sport' => $tipe_pajero_sport,
        'tipe_l300' => $tipe_l300,
        'tipe_colt_diesel' => $tipe_colt_diesel,
        'tipe_fuso' => $tipe_fuso,
        'eclipse_cross' => $eclipse_cross,
        'triton_dc' => $triton_dc,
        'triton_sc' => $triton_sc,
        'target_database' => $target_database,
        'target_prospek' => $target_prospek,
        'target_spk_ots' => $target_spk_ots,
        'target_spk_fu' => $target_spk_fu,
        'total' => $total,
        'per_prspk' => $per_prspk,
        'per_spk' => $per_spk,
        'nama_biaya' => $nama_biaya,
        'qty' => $qty,
        'uom' => $uom,
        'harga' => $harga,
        'keterangan' => $keterangan,
        'user_create' => $user_create,
        'area_display_nm' => $nama_file1,
        'area_display2_nm' => $nama_file2,
        'lokasi_pameran_nm' => $nama_file3,
        'surat_penawaran_nm' => $nama_file4,
        'foto_tampak_luar_nm' => $nama_file5,
        'foto_lokasi_gmaps_nm' => $nama_file6,
        'ket_cancel' => $ket_cancel,
        'note_spv' => $note_spv
      ],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    /*var_dump(array(
				'status' => $status,
                'no_event' => $no_event,
                'tgl_pengajuan' => $tgl_pengajuan,
				'kategori' => $kategori,
				'tipe_kegiatan' => $tipe_kegiatan,
				'cabang' => $cabang,
				'nm_spv' => $nm_spv,
				'ckode_spv' => $ckode_spv,
				'tgl_mulai' => $tgl_mulai,
				'tgl_selesai' => $tgl_selesai,
				'lokasi' => $lokasi,
				'tipe_xpander' => $tipe_xpander,
				'tipe_xpander_cross' => $tipe_xpander_cross,
				'tipe_pajero_sport' => $tipe_pajero_sport,
				'tipe_l300' => $tipe_l300,
				'tipe_colt_diesel' => $tipe_colt_diesel,
				'tipe_fuso' => $tipe_fuso,
				'target_database' => $target_database,
				'target_prospek' => $target_prospek,
				'target_spk_ots' => $target_spk_ots,
				'target_spk_fu' => $target_spk_fu,
				'total' => $total,
				'per_prspk' => $per_prspk,
				'per_spk' => $per_spk,
				'nama_biaya' => $nama_biaya,
				'qty' => $qty,
				'uom' => $uom,
				'harga' => $harga,
				'keterangan' => $keterangan,
				'user_create' => $user_create,
				'area_display_nm' => $nama_file1,
				'area_display2_nm' => $nama_file2,
				'lokasi_pameran_nm' => $nama_file3,
				'surat_penawaran_nm' => $nama_file4,
				'ket_cancel' => $ket_cancel,
				'note_spv' => $note_spv
                ));*/

    if (!$response->successful()) {

      $err_msg = 'Gagal menyimpan data.';

      redirect()->route('auth-notif', ['msg' => 'Gagal menyimpan data.', 'type' => 'error', 'redir' => route('pages-home')])->send();
    } else {

      if ($response['message'] == 'Success') {

        if ($err_msg_upl == "") {

          redirect()->route('auth-notif', ['msg' => 'Berhasil menyimpan data.', 'type' => 'success', 'redir' => route('pages-home')])->send();
        } else {

          $err_msg = "Berhasil menyimpan data event, tetapi " . $err_msg_upl;

          redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('pages-home')])->send();
        }
      } else {

        $err_msg = $response['message'];

        redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('pages-home')])->send();
      }
    }
  }

  public function proses_upload_report(Request $request)
  {
    $cloc = session('cloc', '');
    $user_create = session('username', '');

    $no_event = $request->input('no_event');
    $report_file1 = $request->file('file_report1');
    $report_file2 = $request->file('file_report2');
    $report_file3 = $request->file('file_report3');
    $report_file4 = $request->file('file_report4');
    $report_file5 = $request->file('file_report5');
    $report_file6 = $request->file('file_report6');
    $report_file7 = $request->file('file_report7');
    $report_file8 = $request->file('file_report8');
    $report_file9 = $request->file('file_report9');
    $report_file10 = $request->file('file_report10');
    $report_file11 = $request->file('file_report11');
    $report_file12 = $request->file('file_report12');

    if ($request->has('sta_verifikasi')) {
      $sta_verifikasi = $request->input('sta_verifikasi');
    } else {
      $sta_verifikasi = '';
    }

    $tujuan_upload = 'event_file';
    $err_msg_up = "";

    $nama_file1 = "";
    $nama_file2 = "";
    $nama_file3 = "";
    $nama_file4 = "";
    $nama_file5 = "";
    $nama_file6 = "";
    $nama_file7 = "";
    $nama_file8 = "";
    $nama_file9 = "";
    $nama_file10 = "";
    $nama_file11 = "";
    $nama_file12 = "";

    $return_rsp = array(
      "nama_file" => "",
      "status" => "2",
      "msg_rsp" => ""
    );

    if ($request->hasFile('file_report1') && $request->file('file_report1')->isValid()) {

      $report_file_nm1 = $report_file1->getClientOriginalExtension();
      $nama_file1 = 'report_1_event_' . time() . '_' . $no_event . '.' . $report_file_nm1;

      if (!$report_file1->move($tujuan_upload, $nama_file1)) {
        $nama_file1 = "";
        $err_msg_up = "Gagal Upload file Report 1";
      }
    }

    if ($request->hasFile('file_report2') && $request->file('file_report2')->isValid()) {

      $report_file_nm2 = $report_file2->getClientOriginalExtension();
      $nama_file2 = 'report_2_event_' . time() . '_' . $no_event . '.' . $report_file_nm2;

      if (!$report_file2->move($tujuan_upload, $nama_file2)) {
        $nama_file2 = "";
        if ($err_msg_up == "") {
          $err_msg_up = "Gagal Upload file Report 2, ";
        } else {
          $err_msg_up = $err_msg_up . "Gagal Upload file Report 2, ";
        }
      }
    }

    if ($request->hasFile('file_report3') && $request->file('file_report3')->isValid()) {

      $report_file_nm3 = $report_file3->getClientOriginalExtension();
      $nama_file3 = 'report_3_event_' . time() . '_' . $no_event . '.' . $report_file_nm3;

      if (!$report_file3->move($tujuan_upload, $nama_file3)) {
        $nama_file3 = "";
        if ($err_msg_up == "") {
          $err_msg_up = "Gagal Upload file Report 3, ";
        } else {
          $err_msg_up = $err_msg_up . "Gagal Upload file Report 3, ";
        }
      }
    }

    if ($request->hasFile('file_report4') && $request->file('file_report4')->isValid()) {

      $report_file_nm4 = $report_file4->getClientOriginalExtension();
      $nama_file4 = 'report_4_event_' . time() . '_' . $no_event . '.' . $report_file_nm4;

      if (!$report_file4->move($tujuan_upload, $nama_file4)) {
        $nama_file4 = "";
        if ($err_msg_up == "") {
          $err_msg_up = "Gagal Upload file Report 4, ";
        } else {
          $err_msg_up = $err_msg_up . "Gagal Upload file Report 4, ";
        }
      }
    }

    if ($request->hasFile('file_report5') && $request->file('file_report5')->isValid()) {

      $report_file_nm5 = $report_file5->getClientOriginalExtension();
      $nama_file5 = 'report_5_event_' . time() . '_' . $no_event . '.' . $report_file_nm5;

      if (!$report_file5->move($tujuan_upload, $nama_file5)) {
        $nama_file5 = "";
        if ($err_msg_up == "") {
          $err_msg_up = "Gagal Upload file Report 5, ";
        } else {
          $err_msg_up = $err_msg_up . "Gagal Upload file Report 5, ";
        }
      }
    }

    if ($request->hasFile('file_report6') && $request->file('file_report6')->isValid()) {

      $report_file_nm6 = $report_file6->getClientOriginalExtension();
      $nama_file6 = 'report_6_event_' . time() . '_' . $no_event . '.' . $report_file_nm6;

      if (!$report_file6->move($tujuan_upload, $nama_file6)) {
        $nama_file6 = "";
        if ($err_msg_up == "") {
          $err_msg_up = "Gagal Upload file Report 6, ";
        } else {
          $err_msg_up = $err_msg_up . "Gagal Upload file Report 6, ";
        }
      }
    }

    if ($request->hasFile('file_report7') && $request->file('file_report7')->isValid()) {

      $report_file_nm7 = $report_file7->getClientOriginalExtension();
      $nama_file7 = 'report_7_event_' . time() . '_' . $no_event . '.' . $report_file_nm7;

      if (!$report_file7->move($tujuan_upload, $nama_file7)) {
        $nama_file7 = "";
        if ($err_msg_up == "") {
          $err_msg_up = "Gagal Upload file Report 7, ";
        } else {
          $err_msg_up = $err_msg_up . "Gagal Upload file Report 7, ";
        }
      }
    }

    if ($request->hasFile('file_report8') && $request->file('file_report8')->isValid()) {

      $report_file_nm8 = $report_file8->getClientOriginalExtension();
      $nama_file8 = 'report_8_event_' . time() . '_' . $no_event . '.' . $report_file_nm8;

      if (!$report_file8->move($tujuan_upload, $nama_file8)) {
        $nama_file8 = "";
        if ($err_msg_up == "") {
          $err_msg_up = "Gagal Upload file Report 8, ";
        } else {
          $err_msg_up = $err_msg_up . "Gagal Upload file Report 8, ";
        }
      }
    }

    if ($request->hasFile('file_report9') && $request->file('file_report9')->isValid()) {

      $report_file_nm9 = $report_file9->getClientOriginalExtension();
      $nama_file9 = 'report_9_event_' . time() . '_' . $no_event . '.' . $report_file_nm9;

      if (!$report_file9->move($tujuan_upload, $nama_file9)) {
        $nama_file9 = "";
        if ($err_msg_up == "") {
          $err_msg_up = "Gagal Upload file Report 9, ";
        } else {
          $err_msg_up = $err_msg_up . "Gagal Upload file Report 9, ";
        }
      }
    }

    if ($request->hasFile('file_report10') && $request->file('file_report10')->isValid()) {

      $report_file_nm10 = $report_file10->getClientOriginalExtension();
      $nama_file10 = 'report_10_event_' . time() . '_' . $no_event . '.' . $report_file_nm10;

      if (!$report_file10->move($tujuan_upload, $nama_file10)) {
        $nama_file10 = "";
        if ($err_msg_up == "") {
          $err_msg_up = "Gagal Upload file Report 10, ";
        } else {
          $err_msg_up = $err_msg_up . "Gagal Upload file Report 10, ";
        }
      }
    }

    if ($request->hasFile('file_report11') && $request->file('file_report11')->isValid()) {

      $report_file_nm11 = $report_file11->getClientOriginalExtension();
      $nama_file11 = 'report_11_event_' . time() . '_' . $no_event . '.' . $report_file_nm11;

      if (!$report_file11->move($tujuan_upload, $nama_file11)) {
        $nama_file11 = "";
        if ($err_msg_up == "") {
          $err_msg_up = "Gagal Upload file Report 11, ";
        } else {
          $err_msg_up = $err_msg_up . "Gagal Upload file Report 11, ";
        }
      }
    }

    if ($request->hasFile('file_report12') && $request->file('file_report12')->isValid()) {

      $report_file_nm12 = $report_file12->getClientOriginalExtension();
      $nama_file12 = 'report_12_event_' . time() . '_' . $no_event . '.' . $report_file_nm12;

      if (!$report_file12->move($tujuan_upload, $nama_file12)) {
        $nama_file12 = "";
        if ($err_msg_up == "") {
          $err_msg_up = "Gagal Upload file Report 12.";
        } else {
          $err_msg_up = $err_msg_up . "Gagal Upload file Report 12.";
        }
      }
    }

    if ($nama_file1 != '' || $nama_file2 != '' || $nama_file3 != '' || $nama_file4 != '' || $nama_file5 != '' || $nama_file6 != '' || $nama_file7 != '' || $nama_file8 != '' || $nama_file9 != '' || $nama_file10 != '' || $nama_file11 != '' || $nama_file12 != '' || $sta_verifikasi != '') {

      $response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/update_event_report', [
        'json' => [
          'no_event' => $no_event,
          'user_create' => $user_create,
          'report_1_nm' => $nama_file1,
          'report_2_nm' => $nama_file2,
          'report_3_nm' => $nama_file3,
          'report_4_nm' => $nama_file4,
          'report_5_nm' => $nama_file5,
          'report_6_nm' => $nama_file6,
          'report_7_nm' => $nama_file7,
          'report_8_nm' => $nama_file8,
          'report_9_nm' => $nama_file9,
          'report_10_nm' => $nama_file10,
          'report_11_nm' => $nama_file11,
          'report_12_nm' => $nama_file12,
          'sta_verifikasi' => $sta_verifikasi
        ],
        'headers' => [
          'Content-Type' => 'application/json',
        ]
      ]);

      if (!$response->successful()) {

        $err_msg = 'Gagal menyimpan data report.';
        $return_rsp['status'] = "2";
        $return_rsp['msg_rsp'] = $err_msg;
      } else {

        if ($response['message'] == 'Success') {

          $err_msg = "Berhasil menyimpan data event";
          $return_rsp['status'] = "1";

          if ($nama_file1 != '') {
            $return_rsp['nama_file1'] = url("storage_event") . "/" . $nama_file1;
          } else {
            $return_rsp['nama_file1'] = "";
          }

          if ($nama_file2 != '') {
            $return_rsp['nama_file2'] = url("storage_event") . "/" . $nama_file2;
          } else {
            $return_rsp['nama_file2'] = "";
          }

          if ($nama_file3 != '') {
            $return_rsp['nama_file3'] = url("storage_event") . "/" . $nama_file3;
          } else {
            $return_rsp['nama_file3'] = "";
          }

          if ($nama_file4 != '') {
            $return_rsp['nama_file4'] = url("storage_event") . "/" . $nama_file4;
          } else {
            $return_rsp['nama_file4'] = "";
          }

          if ($nama_file5 != '') {
            $return_rsp['nama_file5'] = url("storage_event") . "/" . $nama_file5;
          } else {
            $return_rsp['nama_file5'] = "";
          }

          if ($nama_file6 != '') {
            $return_rsp['nama_file6'] = url("storage_event") . "/" . $nama_file6;
          } else {
            $return_rsp['nama_file6'] = "";
          }

          if ($nama_file7 != '') {
            $return_rsp['nama_file7'] = url("storage_event") . "/" . $nama_file7;
          } else {
            $return_rsp['nama_file7'] = "";
          }

          if ($nama_file8 != '') {
            $return_rsp['nama_file8'] = url("storage_event") . "/" . $nama_file8;
          } else {
            $return_rsp['nama_file8'] = "";
          }

          if ($nama_file9 != '') {
            $return_rsp['nama_file9'] = url("storage_event") . "/" . $nama_file9;
          } else {
            $return_rsp['nama_file9'] = "";
          }

          if ($nama_file10 != '') {
            $return_rsp['nama_file10'] = url("storage_event") . "/" . $nama_file10;
          } else {
            $return_rsp['nama_file10'] = "";
          }

          if ($nama_file11 != '') {
            $return_rsp['nama_file11'] = url("storage_event") . "/" . $nama_file11;
          } else {
            $return_rsp['nama_file11'] = "";
          }

          if ($nama_file12 != '') {
            $return_rsp['nama_file12'] = url("storage_event") . "/" . $nama_file12;
          } else {
            $return_rsp['nama_file12'] = "";
          }

          $return_rsp['sta_verifikasi'] = $sta_verifikasi;
          $return_rsp['msg_rsp'] = $err_msg;
        } else {

          $err_msg = $response['message'];
          $return_rsp['status'] = "1";
          $return_rsp['msg_rsp'] = $err_msg;
        }
      }
    } else {

      if ($err_msg_up != '') {
        $err_msg = $err_msg_up;
      } else {
        $err_msg = 'Input salah satu file report / Verifikasi laporan';
      }

      $return_rsp['status'] = "2";
      $return_rsp['msg_rsp'] = $err_msg;
    }

    echo json_encode($return_rsp);
  }

  public function get_list_lokasi(Request $request)
  {
    $cityCode = $request->input('kota');

    $alokasi_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_lokasi', [
      'json' => ['kota' => $cityCode],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    $lokasi_res  = $alokasi_res->json()['result'];
    $lokasi = array();

    if (is_array($lokasi_res)) {
      $count_arr = count($lokasi_res);
    } else {
      $count_arr = 0;
    }

    if ($count_arr > 0) {

      for ($x = 0; $x < count($lokasi_res); $x++) {
        $lokasi[$x]["CityCode"] = $lokasi_res[$x]["ckd_lokasi"];
        $lokasi[$x]["CityName"] = $lokasi_res[$x]["cnm_lokasi"];
      }
    }

    // $lokasi_arr  = array(
    // 	"data"=>$lokasi
    // 	);

    // echo json_encode($lokasi_arr);

    return $lokasi;
  }

  public function get_grafik_ach(Request $request)
  {

    $nmr_event = $request->input('nmr_event');

    $data_achiv_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_ach_event', [
      'json' => ['nmr_event' => $nmr_event],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    $achiv_res  = $data_achiv_res->json()['result'];
    $target = array((int)$achiv_res[0]['target_db'], (int)$achiv_res[0]['target_prospect'], ((int)$achiv_res[0]['target_spk_ots'] + (int)$achiv_res[0]['target_spk_fu']));
    $achiv = array((int)$achiv_res[0]['pencapaian_db'], (int)$achiv_res[0]['pencapaian_prospect'], ((int)$achiv_res[0]['pencapaian_spk_ots'] + (int)$achiv_res[0]['pencapaian_spk_fu']));

    $bobot_db = 30;
    $bobot_prospect = 20;
    $bobot_spk = 50;

    if ($achiv_res[0]['target_db'] > 0) {
      $achived_db = ($achiv_res[0]['pencapaian_db'] / $achiv_res[0]['target_db']) * 100;
    } else {
      $achived_db = 0;
    }

    if ($achiv_res[0]['target_prospect'] > 0) {
      $achived_prospect = (($achiv_res[0]['pencapaian_prospect'] + $achiv_res[0]['pencapaian_spk_ots'] + $achiv_res[0]['pencapaian_spk_fu']) / $achiv_res[0]['target_prospect']) * 100;
    } else {
      $achived_prospect = 0;
    }

    if (($achiv_res[0]['target_spk_ots'] + $achiv_res[0]['target_spk_fu']) > 0) {
      $achived_spk = (($achiv_res[0]['pencapaian_spk_ots'] + $achiv_res[0]['pencapaian_spk_fu']) / ($achiv_res[0]['target_spk_ots'] + $achiv_res[0]['target_spk_fu'])) * 100;
    } else {
      $achived_spk = 0;
    }

    if ($achived_db <= 100) {
      $tot_db = $achived_db * $bobot_db / 100;
    } else {
      $tot_db = $bobot_db;
    }

    if ($achived_prospect <= 100) {
      $tot_prospect = $achived_prospect * $bobot_prospect / 100;
    } else {
      $tot_prospect = $bobot_prospect;
    }

    if ($achived_spk <= 100) {
      $tot_spk = $achived_spk * $bobot_spk / 100;
    } else {
      $tot_spk = $bobot_spk;
    }

    $tot_grade = $tot_db + $tot_prospect + $tot_spk;

    if ($achiv_res[0]['ctipe'] == "0") {
      $tipe_kegiatan = 'Pameran';
    } else if ($achiv_res[0]['ctipe'] == "1") {
      $tipe_kegiatan = 'Display';
    } else if ($achiv_res[0]['ctipe'] == "2") {
      $tipe_kegiatan = 'Kanvasing';
    } else if ($achiv_res[0]['ctipe'] == "3") {
      $tipe_kegiatan = 'Gathering';
    } else if ($achiv_res[0]['ctipe'] == "4") {
      $tipe_kegiatan = 'Sponsorship';
    } else if ($achiv_res[0]['ctipe'] == "5") {
      $tipe_kegiatan = 'Showroom Event';
    } else if ($achiv_res[0]['ctipe'] == "6") {
      $tipe_kegiatan = 'Office Event';
    } else if ($achiv_res[0]['ctipe'] == "7") {
      $tipe_kegiatan = 'Public Area Event';
    } else if ($achiv_res[0]['ctipe'] == "8") {
      $tipe_kegiatan = 'Test Drive Event';
    } else if ($achiv_res[0]['ctipe'] == "9") {
      $tipe_kegiatan = 'Open Table';
    } else if ($achiv_res[0]['ctipe'] == "10") {
      $tipe_kegiatan = 'Above The Line';
    } else if ($achiv_res[0]['ctipe'] == "11") {
      $tipe_kegiatan = 'Event ATPM';
    }

    $kendaraan = "";

    if ($achiv_res[0]['cxforce'] == "1") {
      if ($kendaraan == "") {
        $kendaraan = "XForce";
      } else {
        $kendaraan = $kendaraan . ", XForce";
      }
    }

    if ($achiv_res[0]['cxpander'] == "1") {
      if ($kendaraan == "") {
        $kendaraan = "Xpander";
      } else {
        $kendaraan = $kendaraan . ", Xpander";
      }
    }

    if ($achiv_res[0]['cxpander_cross'] == "1") {
      if ($kendaraan == "") {
        $kendaraan = "Xpander Cross";
      } else {
        $kendaraan = $kendaraan . ", Xpander Cross";
      }
    }

    if ($achiv_res[0]['cpajero_sport'] == "1") {
      if ($kendaraan == "") {
        $kendaraan = "Pajero Sport";
      } else {
        $kendaraan = $kendaraan . ", Pajero Sport";
      }
    }

    if ($achiv_res[0]['cl300'] == "1") {
      if ($kendaraan == "") {
        $kendaraan = "L300";
      } else {
        $kendaraan = $kendaraan . ", L300";
      }
    }

    if ($achiv_res[0]['ccolt_diesel'] == "1") {
      if ($kendaraan == "") {
        $kendaraan = "Canter";
      } else {
        $kendaraan = $kendaraan . ", Canter";
      }
    }

    if ($achiv_res[0]['cfuso'] == "1") {
      if ($kendaraan == "") {
        $kendaraan = "Fingter X";
      } else {
        $kendaraan = $kendaraan . ", Fingter X";
      }
    }

    if ($achiv_res[0]['ceclipse_cross'] == "1") {
      if ($kendaraan == "") {
        $kendaraan = "Eclipse Cross";
      } else {
        $kendaraan = $kendaraan . ", Eclipse Cross";
      }
    }

    if ($achiv_res[0]['ctriton_dc'] == "1") {
      if ($kendaraan == "") {
        $kendaraan = "Triton DC";
      } else {
        $kendaraan = $kendaraan . ", Triton DC";
      }
    }

    if ($achiv_res[0]['ctriton_sc'] == "1") {
      if ($kendaraan == "") {
        $kendaraan = "Triton SC";
      } else {
        $kendaraan = $kendaraan . ", Triton SC";
      }
    }

    if ($tot_grade > 70) {
      $grade = '<span class="badge bg-label-primary me-1" style="padding: 0.2em 0.4em !important; font-size: 1.0em !important; background-color:#e5fce8 !important; color:#02c41b !important;">A</span>';
    } else if ($tot_grade >= 50 && $tot_grade <= 70) {
      $grade = '<span class="badge bg-label-warning me-1" style="padding: 0.2em 0.4em !important; font-size: 1.0em !important; background-color:#f5f5c6 !important; color:#dbd402 !important;">B</span>';
    } else if ($tot_grade < 50) {
      $grade = '<span class="badge bg-label-danger me-1" style="padding: 0.2em 0.4em !important; font-size: 1.0em !important; /*background-color:#e5fce8 !important; color:#02c41b !important;*/">C</span>';
    } else {
      $grade = '<span class="badge bg-label-secondary me-1" style="padding: 0.2em 0.4em !important; font-size: 1.0em !important;">?</span>';
    }

    if ($achiv_res[0]['target_db'] > 0) {
      $per_database_tg = $achiv_res[0]['ntotal'] / $achiv_res[0]['target_db'];
    } else {
      $per_database_tg = 0;
    }

    if ($achiv_res[0]['target_prospect'] > 0) {
      $per_prospek_tg = $achiv_res[0]['ntotal'] / $achiv_res[0]['target_prospect'];
    } else {
      $per_prospek_tg = 0;
    }

    if (($achiv_res[0]['target_spk_ots'] + $achiv_res[0]['target_spk_fu']) > 0) {
      $per_spk_tg = $achiv_res[0]['ntotal'] / ($achiv_res[0]['target_spk_ots'] + $achiv_res[0]['target_spk_fu']);
    } else {
      $per_spk_tg = 0;
    }


    if ($achiv_res[0]['pencapaian_db'] > 0) {
      $per_database_ac = $achiv_res[0]['ntotal'] / $achiv_res[0]['pencapaian_db'];
    } else {
      $per_database_ac = 0;
    }

    if ($achiv_res[0]['pencapaian_prospect'] > 0) {
      $per_prospek_ac = $achiv_res[0]['ntotal'] / $achiv_res[0]['pencapaian_prospect'];
    } else {
      $per_prospek_ac = 0;
    }

    if (($achiv_res[0]['pencapaian_spk_ots'] + $achiv_res[0]['pencapaian_spk_fu']) > 0) {
      $per_spk_ac = $achiv_res[0]['ntotal'] / ($achiv_res[0]['pencapaian_spk_ots'] + $achiv_res[0]['pencapaian_spk_fu']);
    } else {
      $per_spk_ac = 0;
    }


    $returs = array(
      "target" => $target,
      "achiv" => $achiv,
      "kategori" => $achiv_res[0]['ckat'],
      "tipe" => $tipe_kegiatan,
      "cabang" => $achiv_res[0]['cabang'],
      "spv" => $achiv_res[0]['cnama_spv'],
      "tanggal" => $achiv_res[0]['dtgl_start'] . " S/D " . $achiv_res[0]['dtgl_finish'],
      "lokasi" => $achiv_res[0]['lokasi'],
      "kendaraan" => $kendaraan,
      "total" => "Rp. " . number_format($achiv_res[0]['ntotal'], 2, ".", ","),
      "per_database_tg" => "Rp. " . number_format($per_database_tg, 2, ".", ","),
      "per_prospek_tg" => "Rp. " . number_format($per_prospek_tg, 2, ".", ","),
      "per_spk_tg" => "Rp. " . number_format($per_spk_tg, 2, ".", ","),
      "per_database_ac" => "Rp. " . number_format($per_database_ac, 2, ".", ","),
      "per_prospek_ac" => "Rp. " . number_format($per_prospek_ac, 2, ".", ","),
      "per_spk_ac" => "Rp. " . number_format($per_spk_ac, 2, ".", ","),
      "grade" => $grade
    );

    echo json_encode($returs);
  }

  public function print_approval(Request $request)
  {

    $no_event_ = $request['no_event'];
    $no_event = base64_decode($no_event_);

    $cloc = session('cloc', '');

    $detail_event = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_detail_event', [
      'json' => ['no_event' => $no_event],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    $list_event_  = $detail_event->json()['result'];
    $detail_rincian_event_ = array();

    if (is_array($list_event_)) {
      $count_arr_detail = count($list_event_);
    } else {
      $count_arr_detail = 0;
    }

    if ($count_arr_detail > 0) {

      $detail_rincian_event = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_detail_biaya_event', [
        'json' => ['no_event' => $no_event],
        'headers' => [
          'Content-Type' => 'application/json',
        ]
      ]);

      if (isset($detail_rincian_event->json()['result'])) {
        $detail_rincian_event_  = $detail_rincian_event->json()['result'];
      }

      $data = [
        'list_event' => $list_event_[0], 'detail_rincian_event' => $detail_rincian_event_
      ];

      $pdf = PDF::loadView('content.print.print-approval-event', $data, [], [
        'title' => 'Print Approval Event',
        'margin_top' => 10,
        'margin_left' => 10,
        'margin_right' => 10,
        'default_font_size' => 8,
        'default_font' => 'arial'
      ]);

      return $pdf->stream('document.pdf');

      //return view('content.print.print-approval-event', $data);

    } else {

      if ($detail_event->json()['result'] == 'No Data') {
        $err_msg = 'Data Event No. ' . $no_event . ' Tidak Ditemukan';
      } else {
        $err_msg = $detail_event->json()['result'];
      }

      redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('event-list')])->send();
    }
  }

  public function event_test(Request $request)
  {

    $user_name = session('username', '');

    $menu_arr = array();

    $menu_arr = Helper::get_menu_access($user_name);

    $user_name = session('menu_active', '');
    //var_dump($user_name);
    /*if(isset($user_name)){
		$menu_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_menu_access',[
				'json' => ['user_name' => $user_name],
				'headers' => [
					'Content-Type' => 'application/json',
				]
		]);

		$menu_arr  = $menu_res->json()['result'];
	}*/

    //return $menu_arr;
  }

  public function export_event_xls(Request $request)
  {

    $cloc = session('cloc', '');
    $username = session('username', '');
    $cjab = session('cjab', '');

    $date_start = $request->input('tgl_mulai');
    $date_finish = $request->input('tgl_selesai');
    $search = $request->input('cari_event');

    $list_event_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_list_event', [
      'json' => ['cloc' => $cloc, 'cjab' => $cjab, 'date_start' => $date_start, 'date_finish' => $date_finish, 'search' => $search],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    //var_dump($list_event_res->json()['result']);

    $list_event_  = $list_event_res->json()['result'];
    $list_events = array();

    if (is_array($list_event_)) {
      $count_arr = count($list_event_);
    } else {
      $count_arr = 0;
    }

    if ($count_arr > 0) {

      for ($x = 0; $x < count($list_event_); $x++) {
        $list_events[$x]["cnmr_event"] = $list_event_[$x]["cnmr_event"];
        $list_events[$x]["dtgl_pengajuan"] = date_format(date_create($list_event_[$x]["dtgl_pengajuan"]), "d-m-Y");
        $list_events[$x]["ckat"] = $list_event_[$x]["ckat"];

        if ($list_event_[$x]["ctipe"] == "0") {
          $list_events[$x]["tipe"] = "Pameran";
        } else if ($list_event_[$x]["ctipe"] == "1") {
          $list_events[$x]["tipe"] = "Display";
        } else if ($list_event_[$x]["ctipe"] == "2") {
          $list_events[$x]["tipe"] = "Kanvasing";
        } else if ($list_event_[$x]["ctipe"] == "3") {
          $list_events[$x]["tipe"] = "Gathering";
        } else if ($list_event_[$x]["ctipe"] == "4") {
          $list_events[$x]["tipe"] = "Sponsorship";
        } else if ($list_event_[$x]["ctipe"] == "5") {
          $list_events[$x]["tipe"] = "Showroom Event";
        } else if ($list_event_[$x]["ctipe"] == "6") {
          $list_events[$x]["tipe"] = "Office Event";
        } else if ($list_event_[$x]["ctipe"] == "7") {
          $list_events[$x]["tipe"] = "Public Area Event";
        } else if ($list_event_[$x]["ctipe"] == "8") {
          $list_events[$x]["tipe"] = "Test Drive Event";
        } else if ($list_event_[$x]["ctipe"] == "9") {
          $list_events[$x]["tipe"] = "Open Table";
        } else if ($list_event_[$x]["ctipe"] == "10") {
          $list_events[$x]["tipe"] = "Above The Line";
        } else if ($list_event_[$x]["ctipe"] == "11") {
          $list_events[$x]["tipe"] = "Event ATPM";
        } else {
          $list_events[$x]["tipe"] = "";
        }

        if ($list_event_[$x]["csta_pengajuan"] == "0") {
          $list_events[$x]["sta_pengajuan"] = "Kepala Cabang";
        } else if ($list_event_[$x]["csta_pengajuan"] == "1") {
          $list_events[$x]["sta_pengajuan"] = "Marketing";
        } else if ($list_event_[$x]["csta_pengajuan"] == "2") {
          $list_events[$x]["sta_pengajuan"] = "NOH";
        } else if ($list_event_[$x]["csta_pengajuan"] == "3") {
          $list_events[$x]["sta_pengajuan"] = "COO";
        } else if ($list_event_[$x]["csta_pengajuan"] == "4") {
          //$list_events[$x]["sta_pengajuan"] = "Disetujui";
          $list_events[$x]["sta_pengajuan"] = "NOH";
        } else {
          $list_events[$x]["sta_pengajuan"] = "";
        }

        $list_events[$x]["cabang"] = $list_event_[$x]["cabang"];
        $list_events[$x]["cnama_spv"] = $list_event_[$x]["cnama_spv"];
        $list_events[$x]["dtgl_kegiatan"] = date_format(date_create($list_event_[$x]["dtgl_start"]), "d-m-Y") . " - " . date_format(date_create($list_event_[$x]["dtgl_finish"]), "d-m-Y");
        $list_events[$x]["lokasi"] = $list_event_[$x]["lokasi"];

        if ($list_event_[$x]["cstatus"] == "0") {
          $list_events[$x]["status"] = 'Pengajuan Baru';
        } else if ($list_event_[$x]["cstatus"] == "1") {
          $list_events[$x]["status"] = 'Sedang Diproses';
        }/*else if($list_event_[$x]["cstatus"] == "2"){
				$list_events[$x]["status"] = 'Batal';
			}*/ else if ($list_event_[$x]["cstatus"] == "3" || $list_event_[$x]["cstatus"] == "2") {
          $list_events[$x]["status"] = 'Ditolak';
        } else {
          $list_events[$x]["status"] = "";
        }
      }

      /*if(isset($detail_rincian_event->json()['result'])){
			$detail_rincian_event_  = $detail_rincian_event->json()['result'];
		}

		$data = [
			'list_event'=> $list_event_[0], 'detail_rincian_event'=> $detail_rincian_event_
		];

		$pdf = PDF::loadView('content.print.print-approval-event', $data, [], [
					'title' => 'Print Approval Event',
					'margin_top' => 10,
					'margin_left' => 10,
					'margin_right' => 10,
					'default_font_size' => 8,
					'default_font' => 'arial'
				]);

		return $pdf->stream('document.pdf');*/
    } else {

      /*if($detail_event->json()['result'] == 'No Data'){
			$err_msg = 'Data Event No. '.$no_event.' Tidak Ditemukan';
		}else{
			$err_msg = $detail_event->json()['result'];
		}

		redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('event-list')])->send();*/
    }


    return Excel::download(new ListEventExport($list_events), 'List_Event.xlsx');
  }

  public function proses_cancel_report(Request $request)
  {
    $cloc = session('cloc', '');
    $user_create = session('username', '');
    $cjab = session('cjab', '');

    $no_event = $request->input('no_event_clc');
    $keterangan_cancel = $request->input('keterangan_cancel');

    $err_msg_up = "";

    $return_rsp = array(
      "status" => "2",
      "msg_rsp" => ""
    );

    if ($keterangan_cancel != '' && $no_event != '') {

      $response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/update_event_cancel', [
        'json' => [
          'no_event' => $no_event,
          'user_create' => $user_create,
          'keterangan_cancel' => $keterangan_cancel
        ],
        'headers' => [
          'Content-Type' => 'application/json',
        ]
      ]);

      if (!$response->successful()) {

        $err_msg = 'Gagal update data event.';
        $return_rsp['status'] = "2";
        $return_rsp['msg_rsp'] = $err_msg;
      } else {

        if ($response['message'] == 'Success') {

          $err_msg = "Berhasil update data event";
          $return_rsp['status'] = "1";
          $return_rsp['msg_rsp'] = $err_msg;
        } else {

          $err_msg = $response['message'];
          $return_rsp['status'] = "1";
          $return_rsp['msg_rsp'] = $err_msg;
        }
      }
    } else {

      $err_msg = "Keterangan Cancel & Nomor Event tidak boleh kosong.";
      $return_rsp['status'] = "2";
      $return_rsp['msg_rsp'] = $err_msg;
    }

    echo json_encode($return_rsp);
  }
}
