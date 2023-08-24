<?php

namespace App\Http\Controllers\pages;

use App\Models\Cabang;
use App\Models\Lokasi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CalendarEventController extends Controller{

    public function index(){
        if(session()->has('username')){
		
            $kota_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_kota',[
                'json' => [],
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

	        $kota  = $kota_res->json()['result'];

            $nm_spv = session('cnm_lengkap', '');
            $kd_spv = session('kode_peg', '');

            return view('content.pages.pages-lokasi-create', ['kota' => $kota, 'nama' => $nm_spv]);
                
        }else{
                
            $err_msg = 'Anda belum login.';
            redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
        }
    }

    public function list_event()
    {
      $cloc = session('cloc', '');
        
      if(session()->has('username')){
          
          return view('content.pages.pages-event-list-bc', ['cloc' => $cloc]);
              
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
	
	$list_event_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_list_event_calendar',[
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
			$nid = $list_event_[$x]["nid"];
			$list_events[$x]["cnmr_event"] = $list_event_[$x]["cnmr_event"];
			$list_events[$x]["dtgl_pengajuan"] = $list_event_[$x]["dtgl_pengajuan"];
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
			$list_events[$x]["dtgl_start"] = $list_event_[$x]["dtgl_start"];
			$list_events[$x]["dtgl_finish"] = $list_event_[$x]["dtgl_finish"];
			$list_events[$x]["lokasi"] = $list_event_[$x]["lokasi"];
			
            $today = date("Y-m-d");
            $tglstart = date("Y-m-d",strtotime($list_event_[$x]["dtgl_start"]));
            $tglfinish = date("Y-m-d",strtotime($list_event_[$x]["dtgl_finish"]));
            if (($today >= $tglstart) && ($today <= $tglfinish)){
                $list_events[$x]["status"] = '<span class="badge bg-label-info me-1">Berlangsung</span>';
            }else if($today < $tglstart){
                $list_events[$x]["status"] = '<span class="badge bg-label-primary me-1">Terjadwal</span>';
            }else if($today > $tglfinish){
                $list_events[$x]["status"] = '<span class="badge bg-label-danger me-1">Selesai</span>';
            }else{
                $list_events[$x]["status"] = "";
            }
			// if($list_event_[$x]["cstatus"] == "0"){
			// 	$list_events[$x]["status"] = '<span class="badge bg-label-primary me-1">Open</span>';
			// }else if($list_event_[$x]["cstatus"] == "1"){
			// 	$list_events[$x]["status"] = '<span class="badge bg-label-info me-1">Release</span>';
			// }else if($list_event_[$x]["cstatus"] == "2"){
			// 	$list_events[$x]["status"] = '<span class="badge bg-label-danger me-1">Batal</span>';
			// }else if($list_event_[$x]["cstatus"] == "3"){
			// 	$list_events[$x]["status"] = '<span class="badge bg-label-danger me-1">Ditolak</span>';
			// }else{
			// 	$list_events[$x]["status"] = "";
			// }

            $selected_aktif = "";
            $selected_nonaktif = "";
			if($list_event_[$x]["cbc_calendar"] == "1"){
                $selected_aktif = "selected";
			}else if($list_event_[$x]["cbc_calendar"] == "0"){
                $selected_nonaktif = "selected";
			}
            
			$cnmr_event_base = base64_encode($list_event_[$x]["cnmr_event"]);
			
            $list_events[$x]["aksi"] = '<select class="select2 form-select form-select-lg" id="cbc_calendar-'.$nid.'" name="cbc_calendar" aria-label="Status Calendar" data-allow-clear="true" onchange="gantiStatus(this)">
            <option '.$selected_aktif.' value="1">Aktif</option><option '.$selected_nonaktif.' value="0">Nonaktif</option>
            </select>';
			
		}
		
	}
	
	$list_event_arr  = array(
					"data"=>$list_events
					);
	
	echo json_encode($list_event_arr);
	
  }
  
  public function gantiStatusCalendar(Request $request){
	$cid = $request->input('id');
	$caktif = $request->input('ca');

    $response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/ganti_status_calendar_bsc',[
        'json' => [
            'cid' => $cid,
            'caktif' => $caktif
            ],
        'headers' => [
            'Content-Type' => 'application/json',
        ]
    ]);
        // echo($response);
    if(!$response->successful()){
       echo "failed";
    }else{
        if($response['message'] == 'Success'){
            echo "success";
        }else{                    
            echo "failed2";
        }
    }
  }

    public function list_lokasi(){
        if(session()->has('username')){
		
            return view('content.pages.pages-lokasi-list');
                
        }else{
                
            $err_msg = 'Anda belum login.';
            redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
        }
    }

    public function getListLokasi(){
        
        $list_lokasi_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_lokasi',[
            'json' => [],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);

        // var_dump($list_lokasi_res->json()['result']);

        $list_lokasi_json  = $list_lokasi_res->json()['result'];
        // $list_lokasi_arr = json_decode($list_lokasi_json);
        
        $count_arr = 0;
        if(is_array($list_lokasi_json)){
            $count_arr = count($list_lokasi_json);
        }
        
        $html = "";
        $data = array();

        if($count_arr > 0){
            foreach($list_lokasi_json as $row){
                $html .= "<tr>";
                $html .= "<td>".$row['ckd_lokasi']."</td>";
                $html .= "<td>".$row['cnm_lokasi']."</td>";
                $html .= "<td>".$row['ProvinceName']."</td>";
                $html .= "<td>".$row['CityName']."</td>";
                $html .= "<td>".$row['caktif'] == '1' ? "Aktif" : "Tidak Aktif"."</td>";
                $html .= "<td></td>";
                $html .= "</tr>";

                array_push($data, array(
                    'ckd_lokasi' => $row['ckd_lokasi'],
                    'cnm_lokasi' => $row['cnm_lokasi'],
                    'ProvinceName' => $row['ProvinceName'],
                    'CityName' => $row['CityName'],
                    'caktif' => $row['caktif'] == '1' ? "Aktif" : "Tidak Aktif",
                    'aksi' => ''
                ));
            }
        }

        // return $html;
        echo json_encode(
            array(
                "data"=>$data
                )
        );

    }

    public function prosesCreateLokasi(Request $request){
        $nama_lokasi = $request->input('nama_lokasi');
        $kota = $request->input('kota');
    	$user_create = session('username', '');

        $kota_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_kota',[
            'json' => ['city_code' => $kota,],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);

        $provinsi = $kota_res->json()['result'][0]['ProvinceCode'];
        
        $response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/simpan_lokasi',[
            'json' => [
                    'cnm_lokasi' => $nama_lokasi,
                    'cprovinsi' => $provinsi,
                    'ckota' => $kota,
                    'cusercreate' => $user_create,
                    ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
        ]);

        if(!$response->successful()){
	
            $err_msg = 'Gagal menyimpan data.';
                
            redirect()->route('auth-notif', ['msg' => 'Gagal menyimpan data.', 'type' => 'error', 'redir' => route('pages-home')])->send();
            
        }else{
            
            if($response['message'] == 'Success'){
                
                redirect()->route('auth-notif', ['msg' => 'Berhasil menyimpan data.', 'type' => 'success', 'redir' => route('pages-home')])->send();
            
            }else{
                $err_msg = $response['message'];
                
                redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('pages-home')])->send();
            }
        }
    }
}

?>