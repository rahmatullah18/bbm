<?php

namespace App\Http\Controllers\pages;

use App\Models\Cabang;
use App\Models\Lokasi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LokasiController extends Controller{

    public function index(){
        //if(session()->has('username')){
		
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
                
        /*}else{
                
            $err_msg = 'Anda belum login.';
            redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
        }*/
    }

    public function list_lokasi(){
        //if(session()->has('username')){
		
            return view('content.pages.pages-lokasi-list');
                
        /*}else{
                
            $err_msg = 'Anda belum login.';
            redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
        }*/
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