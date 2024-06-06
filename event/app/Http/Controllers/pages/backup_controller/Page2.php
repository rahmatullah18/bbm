<?php

namespace App\Http\Controllers\pages;

use App\Models\Cabang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PDF;
use App\Helpers\Helpers as Helper;

class Page2 extends Controller
{
  public function index()
  {
	//$cabang = Cabang::where('caktif', '1')
    //           ->orderBy('cnama')
    //           ->get();
	
	$cloc = session('cloc', '');
	$cjab = session('cjab', '');
	
	$cabang_res = Http::get('http://bbm-bams.co.id/sparepart_api/v1/region',[
			'json' => ['cloc' => $cloc, 'cjab' => $cjab],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
    ]);
	
	$no_event_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_no_event',[
			'json' => ['cloc' => $cloc],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
    ]);
	
	$alokasi_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_lokasi',[
			'json' => [],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
    ]);
	
	$kota_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_kota',[
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
	
	if(session()->has('username')){
		
		return view('content.pages.pages-page2', ['cabang' => $cabang, 'nm_spv'=> $nm_spv, 'kd_spv'=> $kd_spv, 'no_event'=> $no_event, 'lokasi'=> $lokasi, 'kota'=> $kota]);
		
	}else{
		
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
	
	if($request->has('tipe_xforce')){
		$tipe_xforce = $request->input('tipe_xforce');
	}else{
		$tipe_xforce = '';
	}
	
	if($request->has('tipe_xpander')){
		$tipe_xpander = $request->input('tipe_xpander');
	}else{
		$tipe_xpander = '';
	}
	
	if($request->has('tipe_xpander_cross')){
		$tipe_xpander_cross = $request->input('tipe_xpander_cross');
	}else{
		$tipe_xpander_cross = '';
	}
	
	if($request->has('tipe_pajero_sport')){
		$tipe_pajero_sport = $request->input('tipe_pajero_sport');
	}else{
		$tipe_pajero_sport = '';
	}
	
	if($request->has('tipe_l300')){
		$tipe_l300 = $request->input('tipe_l300');
	}else{
		$tipe_l300 = '';
	}
	
	if($request->has('tipe_colt_diesel')){
		$tipe_colt_diesel = $request->input('tipe_colt_diesel');
	}else{
		$tipe_colt_diesel = '';
	}
	
	if($request->has('tipe_fuso')){
		$tipe_fuso = $request->input('tipe_fuso');
	}else{
		$tipe_fuso = '';
	}
	
	if($request->has('eclipse_cross')){
		$eclipse_cross = $request->input('eclipse_cross');
	}else{
		$eclipse_cross = '';
	}
	
	if($request->has('triton_dc')){
		$triton_dc = $request->input('triton_dc');
	}else{
		$triton_dc = '';
	}
	
	if($request->has('triton_sc')){
		$triton_sc = $request->input('triton_sc');
	}else{
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
	
	if($request->hasFile('area_display') && $request->file('area_display')->isValid()){
		
		$area_display_nm = $area_display->getClientOriginalExtension();
		$nama_file1 = 'area_display_'.time().'.'.$area_display_nm;
	
		if(!$area_display->move($tujuan_upload,$nama_file1)){
			$nama_file1 = "";
			$err_msg_upl = "Gagal Upload file Area Display, ";
		}
	}
	
	if($request->hasFile('area_display2') && $request->file('area_display2')->isValid()){
		
		$area_display2_nm = $area_display2->getClientOriginalExtension();
		$nama_file2 = 'area_display2_'.time().'.'.$area_display2_nm;
	
		if(!$area_display2->move($tujuan_upload,$nama_file2)){
			$nama_file2 = "";
			if($err_msg_upl == ""){
				$err_msg_upl = "Gagal Upload file Area Display2, ";
			}else{
				$err_msg_upl = $err_msg_upl."Gagal Upload file Area Display2, ";
			}
			
		}
	}
	
	if($request->hasFile('lokasi_pameran') && $request->file('lokasi_pameran')->isValid()){
		
		$lokasi_pameran_nm = $lokasi_pameran->getClientOriginalExtension();
		$nama_file3 = 'lokasi_pameran_'.time().'.'.$lokasi_pameran_nm;
	
		if(!$lokasi_pameran->move($tujuan_upload,$nama_file3)){
			$nama_file3 = "";
			if($err_msg_upl == ""){
				$err_msg_upl = "Gagal Upload file Lokasi Pameran, ";
			}else{
				$err_msg_upl = $err_msg_upl."Gagal Upload file Lokasi Pameran, ";
			}
			
		}
	}
	
	if($request->hasFile('surat_penawaran') && $request->file('surat_penawaran')->isValid()){
		
		$surat_penawaran_nm = $surat_penawaran->getClientOriginalExtension();
		$nama_file4 = 'surat_penawaran_'.time().'.'.$surat_penawaran_nm;
	
		if(!$surat_penawaran->move($tujuan_upload,$nama_file4)){
			$nama_file4 = "";
			if($err_msg_upl == ""){
				$err_msg_upl = "Gagal Upload file Surat Penawaran.";
			}else{
				$err_msg_upl = $err_msg_upl."Gagal Upload file Surat Penawaran, ";
			}
			
		}
		
	}
	
	if($request->hasFile('tampak_luar') && $request->file('tampak_luar')->isValid()){
		
		$tampak_luar_nm = $tampak_luar->getClientOriginalExtension();
		$nama_file5 = 'tampak_luar_'.time().'.'.$tampak_luar_nm;
	
		if(!$tampak_luar->move($tujuan_upload,$nama_file5)){
			$nama_file5 = "";
			if($err_msg_upl == ""){
				$err_msg_upl = "Gagal Upload file Tampak Luar Gedung/Area Pameran.";
			}else{
				$err_msg_upl = $err_msg_upl."Gagal Upload file Tampak Luar Gedung/Area Pameran, ";
			}
			
		}
		
	}
	
	if($request->hasFile('lokasi_gmaps') && $request->file('lokasi_gmaps')->isValid()){
		
		$lokasi_gmaps_nm = $lokasi_gmaps->getClientOriginalExtension();
		$nama_file6 = 'lokasi_gmaps_'.time().'.'.$lokasi_gmaps_nm;
	
		if(!$lokasi_gmaps->move($tujuan_upload,$nama_file6)){
			$nama_file6 = "";
			if($err_msg_upl == ""){
				$err_msg_upl = "Gagal Upload file Screenshot Lokasi Pameran di GMaps.";
			}else{
				$err_msg_upl = $err_msg_upl."Gagal Upload file Screenshot Lokasi Pameran di GMaps.";
			}
			
		}
		
	}
	
    $response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/simpan_event_sales',[
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
	
	if(!$response->successful()){
	
		$err_msg = 'Gagal menyimpan data.';
		// dd($response);
		redirect()->route('auth-notif', ['msg' => 'Gagal menyimpan data.', 'type' => 'error', 'redir' => route('pages-home')])->send();
		
	}else{
		
		if($response['message'] == 'Success'){
			
			if($err_msg_upl == ""){
				
				redirect()->route('auth-notif', ['msg' => 'Berhasil menyimpan data.', 'type' => 'success', 'redir' => route('pages-home')])->send();
				
			}else{
				
				$err_msg = "Berhasil menyimpan data event, tetapi ".$err_msg_upl;
				
				redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('pages-home')])->send();
				
			}
			
		}else{
			
			$err_msg = $response['message'];
			
			redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('pages-home')])->send();
		}
	}
	
  }
  
  public function list_event()
  {
	$cloc = session('cloc', '');
	  
	if(session()->has('username')){
		
		return view('content.pages.pages-event-list', ['cloc' => $cloc]);
			
	}else{
			
		$err_msg = 'Anda belum login.';
		redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
	}
  }
  
  public function get_data_list_event()
  {
	$cloc = session('cloc', '');
	$username = session('username', '');
	$cjab = session('cjab', '');
	
	$list_event_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_list_event',[
			'json' => ['cloc' => $cloc, 'cjab' => $cjab],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
    ]);
	
	//var_dump($list_event_res->json()['result']);
	
	$list_event_  = $list_event_res->json()['result'];
	$list_events = array();
	
	if(is_array($list_event_)){
		$count_arr = count($list_event_);
	}else{
		$count_arr = 0;
	}
	
	
	if($count_arr > 0){
		
		for($x = 0; $x <count($list_event_) ; $x++){
			$list_events[$x]["cnmr_event"] = $list_event_[$x]["cnmr_event"];
			$list_events[$x]["dtgl_pengajuan"] = date_format(date_create($list_event_[$x]["dtgl_pengajuan"]),"d-m-Y");
			$list_events[$x]["ckat"] = $list_event_[$x]["ckat"];
			
			if($list_event_[$x]["ctipe"] == "0"){
				$list_events[$x]["tipe"] = "Pameran";
			}else if($list_event_[$x]["ctipe"] == "1"){
				$list_events[$x]["tipe"] = "Display"; 
			}else if($list_event_[$x]["ctipe"] == "2"){
				$list_events[$x]["tipe"] = "Kanvasing";
			}else if($list_event_[$x]["ctipe"] == "3"){
				$list_events[$x]["tipe"] = "Gathering";
			}else if($list_event_[$x]["ctipe"] == "4"){
				$list_events[$x]["tipe"] = "Sponsorship";
			}else if($list_event_[$x]["ctipe"] == "5"){
				$list_events[$x]["tipe"] = "Showroom Event";
			}else if($list_event_[$x]["ctipe"] == "6"){
				$list_events[$x]["tipe"] = "Office Event";
			}else if($list_event_[$x]["ctipe"] == "7"){
				$list_events[$x]["tipe"] = "Public Area Event";
			}else if($list_event_[$x]["ctipe"] == "8"){
				$list_events[$x]["tipe"] = "Test Drive Event";
			}else if($list_event_[$x]["ctipe"] == "9"){
				$list_events[$x]["tipe"] = "Open Table";
			}else if($list_event_[$x]["ctipe"] == "10"){
				$list_events[$x]["tipe"] = "Above The Line";
			}else{
				$list_events[$x]["tipe"] = "";
			}
		
			if($list_event_[$x]["csta_pengajuan"] == "0"){
				$list_events[$x]["sta_pengajuan"] = "Kepala Cabang";
			}else if($list_event_[$x]["csta_pengajuan"] == "1"){
				$list_events[$x]["sta_pengajuan"] = "Marketing"; 
			}else if($list_event_[$x]["csta_pengajuan"] == "2"){
				$list_events[$x]["sta_pengajuan"] = "NOH";
			}else if($list_event_[$x]["csta_pengajuan"] == "3"){
				$list_events[$x]["sta_pengajuan"] = "COO";
			}else if($list_event_[$x]["csta_pengajuan"] == "4"){
				$list_events[$x]["sta_pengajuan"] = "Disetujui";
			}else{
				$list_events[$x]["sta_pengajuan"] = "";
			}

			$list_events[$x]["cabang"] = $list_event_[$x]["cabang"];
			$list_events[$x]["cnama_spv"] = $list_event_[$x]["cnama_spv"];
			$list_events[$x]["dtgl_kegiatan"] = date_format(date_create($list_event_[$x]["dtgl_start"]),"d-m-Y")." - ".date_format(date_create($list_event_[$x]["dtgl_finish"]),"d-m-Y");
			$list_events[$x]["lokasi"] = $list_event_[$x]["lokasi"];
			
			if($list_event_[$x]["cstatus"] == "0"){
				$list_events[$x]["status"] = '<span class="badge bg-label-primary me-1">Pengajuan Baru</span>';
			}else if($list_event_[$x]["cstatus"] == "1"){
				$list_events[$x]["status"] = '<span class="badge bg-label-info me-1">Sedang Diproses</span>';
			}else if($list_event_[$x]["cstatus"] == "2"){
				$list_events[$x]["status"] = '<span class="badge bg-label-danger me-1">Batal</span>';
			}else if($list_event_[$x]["cstatus"] == "3"){
				$list_events[$x]["status"] = '<span class="badge bg-label-danger me-1">Ditolak</span>';
			}else{
				$list_events[$x]["status"] = "";
			}
			
			$cnmr_event_base = base64_encode($list_event_[$x]["cnmr_event"]);
			
			if($list_event_[$x]["cstatus"] == "1"){
				$graf = '<a class="dropdown-item" href="javascript:void(0);" onclick="javascript:model_show_chart('."'".$list_event_[$x]["cnmr_event"]."'".');return false;"><i class="bx bxs-bar-chart-alt-2 me-2"></i> Activity Report</a>';
			}else{
				$graf = '';
			}
			
			if($list_event_[$x]["cstatus"] == "1" && $list_event_[$x]["csta_pengajuan"] == "4"){
				$letter = '<a class="dropdown-item" href="'.url('print_approval_event').'?no_event='.$cnmr_event_base.'" target="_BLANK"><i class="bx bxs-edit me-2"></i>Print Event</a>';
			}else{
				$letter = '';
			}
				
				$report_event_1 = "";
				$report_event_2 = "";
				
				if($list_event_[$x]["creport_event_1"] != ""){
					$report_event_1 = url('storage_event')."/".$list_event_[$x]["creport_event_1"];
				}
				
				if($list_event_[$x]["creport_event_2"] != ""){
					$report_event_2 = url('storage_event')."/".$list_event_[$x]["creport_event_2"];
				}
				
				$list_events[$x]["aksi"] = '<div class="dropdown">
											  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
											  <div class="dropdown-menu">
												<a class="dropdown-item" href="/edit_event_list?no_event='.$cnmr_event_base.'"><i class="bx bxs-edit me-2"></i> Edit</a>
												'.$graf.'
												'.$letter.'
												<a class="dropdown-item" href="javascript:void(0);" onclick="javascript:model_report('."'1'".','."'".$list_event_[$x]["cnmr_event"]."'".','."'".$report_event_1."'".');return false;"><i class="bx bx-edit-alt me-2"></i> Report</a>
												<!--<a class="dropdown-item" href="javascript:void(0);" onclick="javascript:model_report('."'2'".','."'".$list_event_[$x]["cnmr_event"]."'".','."'".$report_event_2."'".');return false;"><i class="bx bx-edit-alt me-2"></i> Report 2</a>-->
											  </div>
											</div>';
			
		}
		
	}
	
	$list_event_arr  = array(
					"data"=>$list_events
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
	
	$cabang_res = Http::get('http://bbm-bams.co.id/sparepart_api/v1/region',[
			'json' => ['cloc' => $cloc, 'cjab' => $cjab],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
    ]);
	
	$alokasi_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_lokasi',[
			'json' => [],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
    ]);
	
	$detail_event = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_detail_event',[
			'json' => ['no_event' => $no_event],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
    ]);
	
	$cabang  = $cabang_res->json()['result'];
	$lokasi  = $alokasi_res->json()['result'];
	$list_event_  = $detail_event->json()['result'];
	$detail_rincian_event_ = array();
	
	if(is_array($list_event_)){
		$count_arr_detail = count($list_event_);
	}else{
		$count_arr_detail = 0;
	}
	
	if($count_arr_detail > 0){
		
		$detail_rincian_event = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_detail_biaya_event',[
				'json' => ['no_event' => $no_event],
				'headers' => [
					'Content-Type' => 'application/json',
				]
		]);
	
		if(isset($detail_rincian_event->json()['result'])){
			$detail_rincian_event_  = $detail_rincian_event->json()['result'];
		}
		
		if(session()->has('username')){
			
			//var_dump($detail_rincian_event_);
			
			return view('content.pages.pages-event-detail', ['cabang' => $cabang, 'list_event'=> $list_event_[0], 'detail_rincian_event'=> $detail_rincian_event_, 'lokasi'=> $lokasi]);
		
		}else{
			
			$err_msg = 'Anda belum login.';
			redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
		}
		
	}else{
		
		if($detail_event->json()['result'] == 'No Data'){
			$err_msg = 'Data Event No. '.$no_event.' Tidak Ditemukan';
		}else{
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

	if($request->has('tipe_xforce')){
		$tipe_xforce = $request->input('tipe_xforce');
	}else{
		$tipe_xforce = '';
	}
	
	if($request->has('tipe_xpander')){
		$tipe_xpander = $request->input('tipe_xpander');
	}else{
		$tipe_xpander = '';
	}
	
	if($request->has('tipe_xpander_cross')){
		$tipe_xpander_cross = $request->input('tipe_xpander_cross');
	}else{
		$tipe_xpander_cross = '';
	}
	
	if($request->has('tipe_pajero_sport')){
		$tipe_pajero_sport = $request->input('tipe_pajero_sport');
	}else{
		$tipe_pajero_sport = '';
	}
	
	if($request->has('tipe_l300')){
		$tipe_l300 = $request->input('tipe_l300');
	}else{
		$tipe_l300 = '';
	}
	
	if($request->has('tipe_colt_diesel')){
		$tipe_colt_diesel = $request->input('tipe_colt_diesel');
	}else{
		$tipe_colt_diesel = '';
	}
	
	if($request->has('tipe_fuso')){
		$tipe_fuso = $request->input('tipe_fuso');
	}else{
		$tipe_fuso = '';
	}
	
	if($request->has('eclipse_cross')){
		$eclipse_cross = $request->input('eclipse_cross');
	}else{
		$eclipse_cross = '';
	}
	
	if($request->has('triton_dc')){
		$triton_dc = $request->input('triton_dc');
	}else{
		$triton_dc = '';
	}
	
	if($request->has('triton_sc')){
		$triton_sc = $request->input('triton_sc');
	}else{
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
	
	if($request->hasFile('area_display') && $request->file('area_display')->isValid()){
		
		$area_display_nm = $area_display->getClientOriginalExtension();
		$nama_file1 = 'area_display_'.time().'.'.$area_display_nm;
	
		if(!$area_display->move($tujuan_upload,$nama_file1)){
			$nama_file1 = "";
			$err_msg_upl = "Gagal Upload file Area Display, ";
		}
	}
	
	if($request->hasFile('area_display2') && $request->file('area_display2')->isValid()){
		
		$area_display2_nm = $area_display2->getClientOriginalExtension();
		$nama_file2 = 'area_display2_'.time().'.'.$area_display2_nm;
	
		if(!$area_display2->move($tujuan_upload,$nama_file2)){
			$nama_file2 = "";
			if($err_msg_upl == ""){
				$err_msg_upl = "Gagal Upload file Area Display2, ";
			}else{
				$err_msg_upl = $err_msg_upl."Gagal Upload file Area Display2, ";
			}
			
		}
	}
	
	if($request->hasFile('lokasi_pameran') && $request->file('lokasi_pameran')->isValid()){
		
		$lokasi_pameran_nm = $lokasi_pameran->getClientOriginalExtension();
		$nama_file3 = 'lokasi_pameran_'.time().'.'.$lokasi_pameran_nm;
	
		if(!$lokasi_pameran->move($tujuan_upload,$nama_file3)){
			$nama_file3 = "";
			if($err_msg_upl == ""){
				$err_msg_upl = "Gagal Upload file Lokasi Pameran, ";
			}else{
				$err_msg_upl = $err_msg_upl."Gagal Upload file Lokasi Pameran, ";
			}
			
		}
	}
	
	if($request->hasFile('surat_penawaran') && $request->file('surat_penawaran')->isValid()){
		
		$surat_penawaran_nm = $surat_penawaran->getClientOriginalExtension();
		$nama_file4 = 'surat_penawaran_'.time().'.'.$surat_penawaran_nm;
	
		if(!$surat_penawaran->move($tujuan_upload,$nama_file4)){
			$nama_file4 = "";
			if($err_msg_upl == ""){
				$err_msg_upl = "Gagal Upload file Surat Penawaran.";
			}else{
				$err_msg_upl = $err_msg_upl."Gagal Upload file Surat Penawaran, ";
			}
			
		}
		
	}
	
	if($request->hasFile('tampak_luar') && $request->file('tampak_luar')->isValid()){
		
		$tampak_luar_nm = $tampak_luar->getClientOriginalExtension();
		$nama_file5 = 'tampak_luar_'.time().'.'.$tampak_luar_nm;
	
		if(!$tampak_luar->move($tujuan_upload,$nama_file5)){
			$nama_file5 = "";
			if($err_msg_upl == ""){
				$err_msg_upl = "Gagal Upload file Tampak Luar Gedung/Area Pameran.";
			}else{
				$err_msg_upl = $err_msg_upl."Gagal Upload file Tampak Luar Gedung/Area Pameran, ";
			}
			
		}
		
	}
	
	if($request->hasFile('lokasi_gmaps') && $request->file('lokasi_gmaps')->isValid()){
		
		$lokasi_gmaps_nm = $lokasi_gmaps->getClientOriginalExtension();
		$nama_file6 = 'lokasi_gmaps_'.time().'.'.$lokasi_gmaps_nm;
	
		if(!$lokasi_gmaps->move($tujuan_upload,$nama_file6)){
			$nama_file6 = "";
			if($err_msg_upl == ""){
				$err_msg_upl = "Gagal Upload file Screenshot Lokasi Pameran di GMaps.";
			}else{
				$err_msg_upl = $err_msg_upl."Gagal Upload file Screenshot Lokasi Pameran di GMaps.";
			}
			
		}
		
	}
	
    $response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/update_event_sales',[
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
	
	if(!$response->successful()){
	
		$err_msg = 'Gagal menyimpan data.';
			
		redirect()->route('auth-notif', ['msg' => 'Gagal menyimpan data.', 'type' => 'error', 'redir' => route('pages-home')])->send();
		
	}else{
		
		if($response['message'] == 'Success'){
			
			if($err_msg_upl == ""){
				
				redirect()->route('auth-notif', ['msg' => 'Berhasil menyimpan data.', 'type' => 'success', 'redir' => route('pages-home')])->send();
				
			}else{
				
				$err_msg = "Berhasil menyimpan data event, tetapi ".$err_msg_upl;
				
				redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('pages-home')])->send();
				
			}
			
		}else{
			
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
	$report_file = $request->file('file_report');
	$no_report = $request->input('no_report');
	
	$tujuan_upload = 'event_file';
	$err_msg_up = "";
	
	$nama_file_report_1 = "";
	$nama_file_report_2 = "";
	
	$nama_file = "";
	$return_rsp = array(
					"nama_file"=>"",
					"status"=>"2",
					"msg_rsp"=>""
					);
	
	if($request->hasFile('file_report') && $request->file('file_report')->isValid()){
		
		$report_file_nm = $report_file->getClientOriginalExtension();
		$nama_file = 'report_'.$no_report.'_event_'.time().'.'.$report_file_nm;
	
		if(!$report_file->move($tujuan_upload,$nama_file)){
			$nama_file = "";
			$err_msg_up = "Gagal Upload file Report ".$no_report;
		}
	}
	
	if($no_report == "1"){
		$nama_file_report_1 = $nama_file;
		$nama_file_report_2 = "";
	}else{
		$nama_file_report_1 = "";
		$nama_file_report_2 = $nama_file;
	}
	
	if($nama_file != ''){
		
		$response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/update_event_report',[
					'json' => [
							'no_event' => $no_event,
							'user_create' => $user_create,
							'report_1_nm' => $nama_file_report_1,
							'report_2_nm' => $nama_file_report_2
							],
						'headers' => [
							'Content-Type' => 'application/json',
						]
				]);
				
		if(!$response->successful()){
	
			$err_msg = 'Gagal menyimpan data report.';
			$return_rsp['status'] = "2";
			$return_rsp['msg_rsp'] = $err_msg;
			
		}else{
			
			if($response['message'] == 'Success'){
					
				$err_msg = "Berhasil menyimpan data event";
				$return_rsp['status'] = "1";
				$return_rsp['nama_file'] = url("storage_event")."/".$nama_file;
				$return_rsp['msg_rsp'] = $err_msg;
				
			}else{
				
				$err_msg = $response['message'];
				$return_rsp['status'] = "1";
				$return_rsp['msg_rsp'] = $err_msg;
				
			}
		}
		
	}else{
		
		$err_msg = $err_msg_up;
		$return_rsp['status'] = "2";
		$return_rsp['msg_rsp'] = $err_msg;
	}
	
	echo json_encode($return_rsp);
	
	
  }

  public function get_list_lokasi(Request $request){
	$cityCode = $request->input('kota');
	
	$alokasi_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_lokasi',[
		'json' => ['kota' => $cityCode],
		'headers' => [
			'Content-Type' => 'application/json',
		]
	]);

	$lokasi_res  = $alokasi_res->json()['result'];
	$lokasi = array();

	if(is_array($lokasi_res)){
		$count_arr = count($lokasi_res);
	}else{
		$count_arr = 0;
	}

	if($count_arr > 0){
		
		for($x = 0; $x <count($lokasi_res) ; $x++){
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
  
  public function get_grafik_ach(Request $request){
	
	$nmr_event = $request->input('nmr_event');
	
	$data_achiv_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_ach_event',[
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
	
	if($achiv_res[0]['target_db'] > 0){
		$achived_db = ($achiv_res[0]['pencapaian_db'] / $achiv_res[0]['target_db']) * 100;
	}else{
		$achived_db = 0;
	}
	
	if($achiv_res[0]['target_prospect'] > 0){
		$achived_prospect = (($achiv_res[0]['pencapaian_prospect'] + $achiv_res[0]['pencapaian_spk_ots'] + $achiv_res[0]['pencapaian_spk_fu']) / $achiv_res[0]['target_prospect']) * 100;
	}else{
		$achived_prospect = 0;
	}
	
	if(($achiv_res[0]['target_spk_ots'] + $achiv_res[0]['target_spk_fu']) > 0){
		$achived_spk = (($achiv_res[0]['pencapaian_spk_ots'] + $achiv_res[0]['pencapaian_spk_fu']) / ($achiv_res[0]['target_spk_ots'] + $achiv_res[0]['target_spk_fu'])) * 100;
	}else{
		$achived_spk = 0;
	}
	
	if($achived_db <= 100){
		$tot_db = $achived_db * $bobot_db / 100;
	}else{
		$tot_db = $bobot_db;
	}
	
	if($achived_prospect <= 100){
		$tot_prospect = $achived_prospect * $bobot_prospect / 100;
	}else{
		$tot_prospect = $bobot_prospect;
	}
	
	if($achived_spk <= 100){
		$tot_spk = $achived_spk * $bobot_spk / 100;
	}else{
		$tot_spk = $bobot_spk;
	}
	
	$tot_grade = $tot_db + $tot_prospect + $tot_spk;
	
	if($achiv_res[0]['ctipe'] == "0"){
		$tipe_kegiatan = 'Pameran';
	}else if($achiv_res[0]['ctipe'] == "1"){
		$tipe_kegiatan = 'Display';	
	}else if($achiv_res[0]['ctipe'] == "2"){
		$tipe_kegiatan = 'Kanvasing';	
	}else if($achiv_res[0]['ctipe'] == "3"){
		$tipe_kegiatan = 'Gathering';	
	}else if($achiv_res[0]['ctipe'] == "4"){
		$tipe_kegiatan = 'Sponsorship';	
	}else if($achiv_res[0]['ctipe'] == "5"){
		$tipe_kegiatan = 'Showroom Event';	
	}else if($achiv_res[0]['ctipe'] == "6"){
		$tipe_kegiatan = 'Office Event';	
	}else if($achiv_res[0]['ctipe'] == "7"){
		$tipe_kegiatan = 'Public Area Event';	
	}else if($achiv_res[0]['ctipe'] == "8"){
		$tipe_kegiatan = 'Test Drive Event';	
	}else if($achiv_res[0]['ctipe'] == "9"){
		$tipe_kegiatan = 'Open Table';	
	}else if($achiv_res[0]['ctipe'] == "10"){
		$tipe_kegiatan = 'Above The Line';	
	}
	
	$kendaraan = "";
	
	if($achiv_res[0]['cxforce'] == "1"){
		if($kendaraan == ""){
			$kendaraan = "XForce";
		}else{
			$kendaraan = $kendaraan.", XForce";
		}
	}

	if($achiv_res[0]['cxpander'] == "1"){
		if($kendaraan == ""){
			$kendaraan = "Xpander";
		}else{
			$kendaraan = $kendaraan.", Xpander";
		}
	}

	if($achiv_res[0]['cxpander_cross'] == "1"){
		if($kendaraan == ""){
			$kendaraan = "Xpander Cross";
		}else{
			$kendaraan = $kendaraan.", Xpander Cross";
		}
	}
		
	if($achiv_res[0]['cpajero_sport'] == "1"){
		if($kendaraan == ""){
			$kendaraan = "Pajero Sport";
		}else{
			$kendaraan = $kendaraan.", Pajero Sport";
		}
	}
		
	if($achiv_res[0]['cl300'] == "1"){
		if($kendaraan == ""){
			$kendaraan = "L300";
		}else{
			$kendaraan = $kendaraan.", L300";
		}
	}

	if($achiv_res[0]['ccolt_diesel'] == "1"){
		if($kendaraan == ""){
			$kendaraan = "Canter";
		}else{
			$kendaraan = $kendaraan.", Canter";
		}
	}

	if($achiv_res[0]['cfuso'] == "1"){
		if($kendaraan == ""){
			$kendaraan = "Fingter X";
		}else{
			$kendaraan = $kendaraan.", Fingter X";
		}
	}

	if($achiv_res[0]['ceclipse_cross'] == "1"){
		if($kendaraan == ""){
			$kendaraan = "Eclipse Cross";
		}else{
			$kendaraan = $kendaraan.", Eclipse Cross";
		}
	}

	if($achiv_res[0]['ctriton_dc'] == "1"){
		if($kendaraan == ""){
			$kendaraan = "Triton DC";
		}else{
			$kendaraan = $kendaraan.", Triton DC";
		}
	}

	if($achiv_res[0]['ctriton_sc'] == "1"){
		if($kendaraan == ""){
			$kendaraan = "Triton SC";
		}else{
			$kendaraan = $kendaraan.", Triton SC";
		}
	}
	
	if($tot_grade > 70){
		$grade = '<span class="badge bg-label-primary me-1" style="padding: 0.2em 0.4em !important; font-size: 1.0em !important; background-color:#e5fce8 !important; color:#02c41b !important;">A</span>';
	}else if($tot_grade >= 50 && $tot_grade <= 70){
		$grade = '<span class="badge bg-label-warning me-1" style="padding: 0.2em 0.4em !important; font-size: 1.0em !important; background-color:#f5f5c6 !important; color:#dbd402 !important;">B</span>';
	}else if($tot_grade < 50){
		$grade = '<span class="badge bg-label-danger me-1" style="padding: 0.2em 0.4em !important; font-size: 1.0em !important; /*background-color:#e5fce8 !important; color:#02c41b !important;*/">C</span>';
	}else{
		$grade = '<span class="badge bg-label-secondary me-1" style="padding: 0.2em 0.4em !important; font-size: 1.0em !important;">?</span>';
	}
	
	if($achiv_res[0]['target_db'] > 0){
		$per_database_tg = $achiv_res[0]['ntotal'] / $achiv_res[0]['target_db'];
	}else{
		$per_database_tg = 0;
	}
	
	if($achiv_res[0]['target_prospect'] > 0){
		$per_prospek_tg = $achiv_res[0]['ntotal'] / $achiv_res[0]['target_prospect'];
	}else{
		$per_prospek_tg = 0;
	}
	
	if(($achiv_res[0]['target_spk_ots'] + $achiv_res[0]['target_spk_fu']) > 0){
		$per_spk_tg = $achiv_res[0]['ntotal'] / ($achiv_res[0]['target_spk_ots'] + $achiv_res[0]['target_spk_fu']);
	}else{
		$per_spk_tg = 0;
	}
	
	
	if($achiv_res[0]['pencapaian_db'] > 0){
		$per_database_ac = $achiv_res[0]['ntotal'] / $achiv_res[0]['pencapaian_db'];
	}else{
		$per_database_ac = 0;
	}
	
	if($achiv_res[0]['pencapaian_prospect'] > 0){
		$per_prospek_ac = $achiv_res[0]['ntotal'] / $achiv_res[0]['pencapaian_prospect'];
	}else{
		$per_prospek_ac = 0;
	}
	
	if(($achiv_res[0]['pencapaian_spk_ots'] + $achiv_res[0]['pencapaian_spk_fu']) > 0){
		$per_spk_ac = $achiv_res[0]['ntotal'] / ($achiv_res[0]['pencapaian_spk_ots'] + $achiv_res[0]['pencapaian_spk_fu']);
	}else{
		$per_spk_ac = 0;
	}
	
	
	$returs = array(
	 	"target"=>$target,
		"achiv"=>$achiv,
		"kategori"=>$achiv_res[0]['ckat'],
		"tipe"=>$tipe_kegiatan,
		"cabang"=>$achiv_res[0]['cabang'],
		"spv"=>$achiv_res[0]['cnama_spv'],
		"tanggal"=>$achiv_res[0]['dtgl_start']." S/D ".$achiv_res[0]['dtgl_finish'],
		"lokasi"=>$achiv_res[0]['lokasi'],
		"kendaraan"=>$kendaraan,
		"total"=>"Rp. ".number_format($achiv_res[0]['ntotal'],2,".",","),
		"per_database_tg"=>"Rp. ".number_format($per_database_tg,2,".",","),
		"per_prospek_tg"=>"Rp. ".number_format($per_prospek_tg,2,".",","),
		"per_spk_tg"=>"Rp. ".number_format($per_spk_tg,2,".",","),
		"per_database_ac"=>"Rp. ".number_format($per_database_ac,2,".",","),
		"per_prospek_ac"=>"Rp. ".number_format($per_prospek_ac,2,".",","),
		"per_spk_ac"=>"Rp. ".number_format($per_spk_ac,2,".",","),
		"grade"=>$grade
	 	);
	
	echo json_encode($returs);
  }
  
  public function print_approval(Request $request){
	
	$no_event_ = $request['no_event'];
	$no_event = base64_decode($no_event_);
	
	$cloc = session('cloc', '');
	
	$detail_event = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_detail_event',[
			'json' => ['no_event' => $no_event],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
    ]);
	
	$list_event_  = $detail_event->json()['result'];
	$detail_rincian_event_ = array();
	
	if(is_array($list_event_)){
		$count_arr_detail = count($list_event_);
	}else{
		$count_arr_detail = 0;
	}
	
	if($count_arr_detail > 0){
		
		$detail_rincian_event = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_detail_biaya_event',[
				'json' => ['no_event' => $no_event],
				'headers' => [
					'Content-Type' => 'application/json',
				]
		]);
	
		if(isset($detail_rincian_event->json()['result'])){
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

		return $pdf->stream('document.pdf');
		
		//return view('content.print.print-approval-event', $data);
		
	}else{
		
		if($detail_event->json()['result'] == 'No Data'){
			$err_msg = 'Data Event No. '.$no_event.' Tidak Ditemukan';
		}else{
			$err_msg = $detail_event->json()['result'];
		}
			
		redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('event-list')])->send();
		
	}
	
  }
  
  public function event_test(Request $request){
	
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
}
