<?php

namespace App\Http\Controllers\pages;

use App\Models\Cabang;
use App\Models\Lokasi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BannerController extends Controller{

    public function index(){
        if(session()->has('username')){
		
            return view('content.pages.pages-banner-list');
                
        }else{
                
            $err_msg = 'Anda belum login.';
            redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
        }
    }

    public function pageUploadBanner(){
        if(session()->has('username')){
		
            return view('content.pages.pages-banner-upload');
                
        }else{
                
            $err_msg = 'Anda belum login.';
            redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
        }
    }

    public function getListLokasi(){
        if(session()->has('username')){
		
            $banner_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_banner',[
                'json' => [],
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

	        $banner  = $banner_res->json()['result'];

            return view('content.pages.pages-banner-list', ['banner' => $banner]);
                
        }else{
                
            $err_msg = 'Anda belum login.';
            redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
        }
    }

    public function getListBanner(){
        
        $banner_res = Http::post('http://bbm-bams.co.id/sparepart_api/v1/get_banner',[
            'json' => [],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);
        
        $list_banner_json  = $banner_res->json()['result'];
        
        $count_arr = 0;
        if(is_array($list_banner_json)){
            $count_arr = count($list_banner_json);
        }
        
        $data = array();

        if($count_arr > 0){
            $i = 0;
            foreach($list_banner_json as $row){
                $i++;

                if($row['caktif'] == '1'){
                    $aksi = '<a href="/edit-status-banner?id='.base64_encode($row['cid']).'&ca=0"><button style="width:150px;" type="button" class="btn btn-danger">Nonaktifkan</button></a>';
                }else{
                    $aksi = '<a href="/edit-status-banner?id='.base64_encode($row['cid']).'&ca=1"><button style="width:150px;" type="button" class="btn btn-info">Aktifkan</button></a>';
                }

                array_push($data, array(
                    'no' => $i,
                    'gambar' => "<img style='width:100px' src='".$row['curl_gambar']."'>",
                    'cnama_gambar' => $row['cnama_gambar'],
                    'curl_link' => $row['curl_link'],
                    'caktif' => $row['caktif'] == '1' ? "Aktif" : "Tidak Aktif",
                    'aksi' => $aksi
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
    
  public function prosesUploadBanner(Request $request)
  {
	$cnama_gambar = $request->input('cnama_gambar');
	$curl_link = $request->input('curl_link');
	$the_file = $request->file('file_image');
	
	$tujuan_upload = 'bsc_file';
	$err_msg_up = "";
	
	$nama_file = "";
	$return_rsp = array(
					"nama_file"=>"",
					"status"=>"2",
					"msg_rsp"=>""
					);
	
	if($request->hasFile('file_image') && $request->file('file_image')->isValid()){
		
		$the_file_nm = $the_file->getClientOriginalExtension();
		$nama_file = 'banner_'.str_replace(" ","",$cnama_gambar).'_'.time().'.'.$the_file_nm;
	
		if(!$the_file->move($tujuan_upload,$nama_file)){
			$nama_file = "";
			$err_msg_up = "Gagal Upload Banner";
            redirect()->route('auth-notif', ['msg' => 'Gagal menyimpan data.', 'type' => 'error', 'redir' => route('pages-home')])->send();
		}else{
        	$response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/upload_banner_bsc',[
                'json' => [
                        'cnama_gambar' => $cnama_gambar,
                        'curl_gambar' => url('/')."/storage_banner/".$nama_file,
                        'curl_link' => $curl_link
                        ],
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ]
            ]);
                
            if(!$response->successful()){
                $err_msg = 'Gagal menyimpan data.';
                // dd($response);
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
	}else{
        redirect()->route('auth-notif', ['msg' => 'File tidak valid.', 'type' => 'error', 'redir' => route('pages-home')])->send();
    }
	
	// if($nama_file != ''){
		
	// 	$response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/upload_banner_bsc',[
	// 				'json' => [
	// 						'cnama_gambar' => $cnama_gambar,
	// 						'curl_link' => $curl_link
	// 						],
	// 					'headers' => [
	// 						'Content-Type' => 'application/json',
	// 					]
	// 			]);
			
    //     if(!$response->successful()){
        
    //         $err_msg = 'Gagal menyimpan data.';
    //         // dd($response);
    //         redirect()->route('auth-notif', ['msg' => 'Gagal menyimpan data.', 'type' => 'error', 'redir' => route('pages-home')])->send();
            
    //     }else{
            
    //         if($response['message'] == 'Success'){
                
    //             if($err_msg_upl == ""){
                    
    //                 redirect()->route('auth-notif', ['msg' => 'Berhasil menyimpan data.', 'type' => 'success', 'redir' => route('pages-home')])->send();
                    
    //             }else{
                    
    //                 $err_msg = "Berhasil menyimpan data event, tetapi ".$err_msg_upl;
                    
    //                 redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('pages-home')])->send();
                    
    //             }
                
    //         }else{
                
    //             $err_msg = $response['message'];
                
    //             redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('pages-home')])->send();
    //         }
    //     }
        
		
	// }else{
		
	// 	$err_msg = $err_msg_up;
	// 	$return_rsp['status'] = "2";
	// 	$return_rsp['msg_rsp'] = $err_msg;
	// }
	
	// echo json_encode($return_rsp);
	
	
  }

  public function gantiStatusBanner(Request $request){
	$cid = $request->input('id');
	$caktif = $request->input('ca');

    $response = Http::post('http://bbm-bams.co.id/sparepart_api/v1/ganti_status_banner_bsc',[
        'json' => [
                'cid' => $cid,
                'caktif' => $caktif
                ],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
    ]);
        // dd($response);
    if(!$response->successful()){
        $err_msg = 'Gagal menyimpan data.';
        // dd($response);
        redirect()->route('auth-notif', ['msg' => 'Gagal menyimpan data 1.', 'type' => 'error', 'redir' => route('pages-home')])->send();
        
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