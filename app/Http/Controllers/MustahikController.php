<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\MustahikDataTable;
use App\Models\Mustahik;
use App\Models\Kategori;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use App\Models\TransHistory;
use Illuminate\Support\Facades\Auth;

class MustahikController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MustahikDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('Mustahiq')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="'.route('mustahik.create').'" class="btn btn-sm btn-primary" role="button">Add Mustahiq</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('status',1)->get()->pluck('title', 'id');
        $ktg = Kategori::pluck('nama_kategori', 'id');

        return view('mustahik.form_tambah', compact('roles','ktg'));
    }

    public function store(Request $request)
    {   
        // Validate the request data 
        $validatedData = $request->validate([  
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'no_phone' => 'required|string|max:255',
            'status_kawin' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255', 
            'perkerjaan' => 'required|string|max:255', 
            'jml_pendapatan' => 'required|array',  
            'jml_bansos' => 'required|array',
            'jml_anak' => 'required|string|max:255',
            'status_tinggal' => 'required|string|max:255',
            'pengeluaran_kontrakan' => 'nullable|array',
            'pengeluaran_listrik' => 'nullable|array', 
            'jml_hutang' => 'required|array', 
            'keperluan_hutang' => 'nullable|string|max:255',
            'kategori_mustahik' => 'required|string|max:255',
            'tgl_terima_zakat' => 'required|date',
            'kategori' => 'required|array', // Tambahkan validasi untuk input 'kategori'
            'kategori.*' => 'exists:kategori,id', // Tambahkan validasi untuk setiap elemen array 'kategori'
            'jml_uang' => 'nullable|array',
            'jml_beras' => 'nullable|array', 
            'satuan_beras' => 'nullable|string|max:255', 
            'rt_rw' => 'nullable|string|max:255',  
            'nama_wilayah' => 'nullable|max:255', 
            'keterangan' => 'nullable|max:255', 
            'status' => 'string|max:255',  
        ]);  
        
        // Create a new mustahik instance
        $mustahik = new Mustahik();
  
        $kategoriId = $request->input('kategori')[0]; // Menggunakan [0] karena name "kategori" di set sebagai array
        // Mengambil nilai jml_beras dari request
        $jml_beras = $request->input('jml_beras');
        $jml_uang = $request->input('jml_uang');
        $jml_pendapatan = $request->input('jml_pendapatan');
        $jml_bansos = $request->input('jml_bansos');
        $pengeluaran_kontrakan = $request->input('pengeluaran_kontrakan');
        $pengeluaran_listrik = $request->input('pengeluaran_listrik');
        $jml_hutang = $request->input('jml_hutang');

        // Mengonversi array jml_beras menjadi string
        $jumlah_beras = implode(', ', $jml_beras);
        $jumlah_uang = implode(', ', $jml_uang);
        $jumlah_pendapatan = implode(', ', $jml_pendapatan);
        $jumlah_bansos = implode(', ', $jml_bansos);
        $jumlah_pengeluaran_kontrakan = implode(', ', $pengeluaran_kontrakan);
        $jumlah_pengeluaran_listrik = implode(', ', $pengeluaran_listrik);
        $jumlah_hutang = implode(', ', $jml_hutang);

        // Fill the mustahik data from the request
        $lastId = Mustahik::orderByDesc('id')->first();
        if(!$lastId){ 
            $x=0;
          }else{ 
            $x=$lastId->id; 
        }
 
        $mustahik->code = $this->generateCodeById("MSQ", $x+1);
        $mustahik->nama_lengkap = $request->nama_lengkap;
        $mustahik->jenis_kelamin = $request->jenis_kelamin;
        $mustahik->nomor_telp = $request->no_phone;
        $mustahik->status_perkawinan = $request->status_kawin;
        $mustahik->alamat = $request->alamat;  
        $mustahik->pekerjaan = $request->perkerjaan;
        $mustahik->jumlah_pendapatan = $jumlah_pendapatan;
        $mustahik->jumlah_bansos_diterima = $jumlah_bansos;
        $mustahik->jumlah_anak_dalam_tanggungan = $request->jml_anak;
        $mustahik->status_tempat_tinggal = $request->status_tinggal;
        // $status_tempat_tinggal = $request->status_tempat_tinggal;
        // if (strlen($status_tempat_tinggal) > 255) {
        //     $status_tempat_tinggal = substr($status_tempat_tinggal, 0, 255);   
        // } 

        $mustahik->pengeluaran_kontrakan = $jumlah_pengeluaran_kontrakan;
        $mustahik->pengeluaran_listrik = $jumlah_pengeluaran_listrik;
        $mustahik->jumlah_hutang = $jumlah_hutang;
        $mustahik->keperluan_hutang = $request->keperluan_hutang;
        $mustahik->kategori_mustahik = $request->kategori_mustahik;
        $mustahik->tanggal = $request->tgl_terima_zakat; 
        $mustahik->kategori_id = $kategoriId;
        $mustahik->jumlah_uang_diterima = $jumlah_uang;   
        $mustahik->jumlah_beras_diterima = $jumlah_beras;
        $mustahik->satuan_beras = $request->satuan_beras;
        $mustahik->keterangan = $request->keterangan;    
        $mustahik->rw_id = $request->rt_rw;    
        $mustahik->wilayah_lain = $request->nama_wilayah;    
        $mustahik->status = $request->status;    

         // If "Apakah masuk ke RW 04?" is "Tidak", assign "Nama Wilayah"
        // if ($request->rt_rw === 'Tidak') {   
        //     $mustahik->rt_rw = $request->nama_wilayah;   
        // } else {
        //     $mustahik->rt_rw = $request->rt_rw_select; 
        // }  

        // $mustahik->rt_rw = $request->pilihan_rw === 'Tidak' ? $request->nama_wilayah : $request->rt_rw_select;
   
        // Save the mustahik
        $mustahik->save();
        $history = new TransHistory();
        $history->muzakki_id = $mustahik->id;
        $history->user =Auth::user()->nama_lengkap;
        $history->code =$mustahik->code ;
        $history->method ="create";
        $history->changes = json_encode([
        'code' => $mustahik->code,
        'nama_lengkap' =>$mustahik->nama_lengkap,
        'jenis_kelamin' => $mustahik->jenis_kelamin,
        'nomor_telp' => $mustahik->nomor_telp,
        'status_perkawinan' => $mustahik->status_perkawinan,
        'alamat' => $mustahik->alamat,
        'pekerjaan' => $mustahik->pekerjaan,
        'jumlah_pendapatan' => $mustahik->jumlah_pendapatan,
        'jumlah_bansos_diterima' => $mustahik->jumlah_bansos_diterima,
        'jumlah_anak_dalam_tanggungan' => $mustahik->jumlah_anak_dalam_tanggungan,
        'status_tempat_tinggal' => $mustahik->status_tempat_tinggal,
        'pengeluaran_kontrakan' => $mustahik->pengeluaran_kontrakan,
        'pengeluaran_listrik' => $mustahik->pengeluaran_listrik,
        'jumlah_hutang' => $mustahik->jumlah_hutang,
        'keperluan_hutang' => $mustahik->keperluan_hutang,
        'kategori_mustahik' => $mustahik->kategori_mustahik,
        'tanggal' => $mustahik->tanggal,
        'kategori_id' => $mustahik->kategori_id,
        'jumlah_uang_diterima' => $mustahik->jumlah_uang_diterima,
        'jumlah_beras_diterima' => $mustahik->jumlah_beras_diterima,
        'satuan_beras' => $mustahik->satuan_beras,
        'keterangan' => $mustahik->keterangan,
        'rw_id' => $mustahik->rw_id,
        'wilayah_lain' => $mustahik->wilayah_lain,
        'status' => $mustahik->status,
    ]);
    
    $history->save();



        // Redirect back to the index page of mustahik with a success message
        return redirect()->route('mustahik.index')->withSuccess(__('Mustahik added successfully.'));
    }

    public function destroy($id)
    {
        $mustahik = Mustahik::findOrFail($id);
        $status = 'errors';
        $message = __('global-message.delete_form', ['form' => __('mustahik.title')]);
 
        if ($mustahik != '') {
            $mustahik->delete();
            $status = 'success';
            $message = __('global-message.delete_form', ['form' => __('mustahik.title')]);
        }

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status, $message);

    }

    public function show($id)
    {  
       // Find the category data by ID  
       $mustahik = Mustahik::findOrFail($id);
       $ktg = Kategori::pluck('nama_kategori', 'id');

       // Pass the category data to the form view
       return view('mustahik.detail', compact('mustahik','ktg'));
    }

    public function edit($id)
    {  
       // Find the category data by ID  
       $mustahik = Mustahik::findOrFail($id);
       $ktg = Kategori::pluck('nama_kategori', 'id');

       // Pass the category data to the form view
       return view('mustahik.form_edit', compact('mustahik','ktg'));
    }

    public function update(Request $request, $id) {
        // Validate the request data 
        $validatedData = $request->validate([  
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'no_phone' => 'required|string|max:255',
            'status_kawin' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255', 
            'pekerjaan' => 'required|string|max:255', 
            'jml_pendapatan' => 'required|array',  
            'jml_bansos' => 'nullable|array',
            'jml_anak' => 'required|string|max:255',
            'status_tinggal' => 'required|string|max:255',
            'pengeluaran_kontrakan' => 'nullable|array',
            'pengeluaran_listrik' => 'nullable|array', 
            'jml_hutang' => 'nullable|array', 
            'keperluan_hutang' => 'nullable|string|max:255',
            'kategori_mustahik' => 'required|string|max:255',
            'tgl_terima_zakat' => 'required|date',
            'kategori' => 'required|array', // Tambahkan validasi untuk input 'kategori'
            'kategori.*' => 'exists:kategori,id', // Tambahkan validasi untuk setiap elemen array 'kategori'
            'jml_uang' => 'nullable|array',
            'jml_beras' => 'nullable|array', 
            'satuan_beras' => 'nullable|string|max:255', 
            'rt_rw' => 'nullable|string|max:255',  
            'nama_wilayah' => 'nullable|max:255', 
            'keterangan' => 'nullable|max:255', 
            'status' => 'string|max:255',  
        ]);  
    
        // Find the mustahik instance by id 
        $mustahik = Mustahik::findOrFail($id);
        $oldMustahik = clone $mustahik; 

        $kategoriId = $request->input('kategori')[0]; // Menggunakan [0] karena name "kategori" di set sebagai array
        // Mengambil nilai jml_beras dari request
        $jml_beras = $request->input('jml_beras');
        $jml_uang = $request->input('jml_uang');
        $jml_pendapatan = $request->input('jml_pendapatan');
        $jml_bansos = $request->input('jml_bansos');
        $pengeluaran_kontrakan = $request->input('pengeluaran_kontrakan');
        $pengeluaran_listrik = $request->input('pengeluaran_listrik');
        $jml_hutang = $request->input('jml_hutang');
    
        // Mengonversi array jml_beras menjadi string
        $jumlah_beras = is_array($jml_beras) ? implode(', ', $jml_beras) : $jml_beras;
        $jumlah_uang = is_array($jml_uang) ? implode(', ', $jml_uang) : $jml_uang;
        $jumlah_pendapatan = is_array($jml_pendapatan) ? implode(', ', $jml_pendapatan) : $jml_pendapatan;
        $jumlah_bansos = is_array($jml_bansos) ? implode(', ', $jml_bansos) : $jml_bansos;
        $jumlah_pengeluaran_kontrakan = is_array($pengeluaran_kontrakan) ? implode(', ', $pengeluaran_kontrakan) : $pengeluaran_kontrakan;
        $jumlah_pengeluaran_listrik = is_array($pengeluaran_listrik) ? implode(', ', $pengeluaran_listrik) : $pengeluaran_listrik;
        $jumlah_hutang = is_array($jml_hutang) ? implode(', ', $jml_hutang) : $jml_hutang;
    
        // Fill the mustahik data from the request
        $lastId = Mustahik::orderByDesc('id')->first();
        if(!$lastId){ 
            $x=0;
          }else{  
            $x=$lastId->id; 
        } 
    
        // Update mustahik data from the request
        // $mustahik->code = $this->generateCodeById("MSQ", $x+1);
        $mustahik->nama_lengkap = $request->nama_lengkap;
        $mustahik->jenis_kelamin = $request->jenis_kelamin;
        $mustahik->nomor_telp = $request->no_phone;
        $mustahik->status_perkawinan = $request->status_kawin;
        $mustahik->alamat = $request->alamat;
        $mustahik->pekerjaan = $request->pekerjaan;
        $mustahik->jumlah_pendapatan = $jumlah_pendapatan;
        $mustahik->jumlah_bansos_diterima = $jumlah_bansos;
        $mustahik->jumlah_anak_dalam_tanggungan = $request->jml_anak;
        $mustahik->status_tempat_tinggal = $request->status_tinggal;
        $mustahik->pengeluaran_kontrakan = $jumlah_pengeluaran_kontrakan;
        $mustahik->pengeluaran_listrik = $jumlah_pengeluaran_listrik;
        $mustahik->jumlah_hutang = $jumlah_hutang;
        $mustahik->keperluan_hutang = $request->keperluan_hutang;
        $mustahik->kategori_mustahik = $request->kategori_mustahik;
        $mustahik->tanggal = $request->tgl_terima_zakat;
        $mustahik->kategori_id = $kategoriId;
        $mustahik->jumlah_uang_diterima =  $jumlah_uang;
        $mustahik->jumlah_beras_diterima = $jumlah_beras;
        $mustahik->satuan_beras = $request->satuan_beras;
        $mustahik->keterangan = $request->keterangan;
        $mustahik->rw_id = $request->rt_rw;
        $mustahik->wilayah_lain = $request->nama_wilayah;
        $mustahik->status = $request->status;
        
        // Save the updated mustahik 
        $mustahik->save();
    
        // Create history record
    $history = new TransHistory();
    $history->muzakki_id = $mustahik->id;
    $history->code = $oldMustahik->code;
    $history->method = "update";
    $history->user = Auth::user()->nama_lengkap;
    $history->changes = json_encode([
        'code' => $oldMustahik->code,
        'nama_lengkap' => [
            'before' => $oldMustahik->nama_lengkap,
            'after' => $mustahik->nama_lengkap,
        ],
        'jenis_kelamin' => [
            'before' => $oldMustahik->jenis_kelamin,
            'after' => $mustahik->jenis_kelamin,
        ],
        'nomor_telp' => [
            'before' => $oldMustahik->nomor_telp,
            'after' => $mustahik->nomor_telp,
        ],
        'status_perkawinan' => [
            'before' => $oldMustahik->status_perkawinan,
            'after' => $mustahik->status_perkawinan,
        ],
        'alamat' => [
            'before' => $oldMustahik->alamat,
            'after' => $mustahik->alamat,
        ],
        'pekerjaan' => [
            'before' => $oldMustahik->pekerjaan,
            'after' => $mustahik->pekerjaan,
        ],
        'jumlah_pendapatan' => [
            'before' => $oldMustahik->jumlah_pendapatan,
            'after' => $mustahik->jumlah_pendapatan,
        ],
        'jumlah_bansos_diterima' => [
            'before' => $oldMustahik->jumlah_bansos_diterima,
            'after' => $mustahik->jumlah_bansos_diterima,
        ],
        'jumlah_anak_dalam_tanggungan' => [
            'before' => $oldMustahik->jumlah_anak_dalam_tanggungan,
            'after' => $mustahik->jumlah_anak_dalam_tanggungan,
        ],
        'status_tempat_tinggal' => [
            'before' => $oldMustahik->status_tempat_tinggal,
            'after' => $mustahik->status_tempat_tinggal,
        ],
        'pengeluaran_kontrakan' => [
            'before' => $oldMustahik->pengeluaran_kontrakan,
            'after' => $mustahik->pengeluaran_kontrakan,
        ],
        'pengeluaran_listrik' => [
            'before' => $oldMustahik->pengeluaran_listrik,
            'after' => $mustahik->pengeluaran_listrik,
        ],
        'jumlah_hutang' => [
            'before' => $oldMustahik->jumlah_hutang,
            'after' => $mustahik->jumlah_hutang,
        ],
        'keperluan_hutang' => [
            'before' => $oldMustahik->keperluan_hutang,
            'after' => $mustahik->keperluan_hutang,
        ],
        'kategori_mustahik' => [
            'before' => $oldMustahik->kategori_mustahik,
            'after' => $mustahik->kategori_mustahik,
        ],
        'tanggal' => [
            'before' => $oldMustahik->tanggal,
            'after' => $mustahik->tanggal,
        ],
        'kategori_id' => [
            'before' => $oldMustahik->kategori_id,
            'after' => $mustahik->kategori_id,
        ],
        'jumlah_uang_diterima' => [
            'before' => $oldMustahik->jumlah_uang_diterima,
            'after' => $mustahik->jumlah_uang_diterima,
        ],
        'jumlah_beras_diterima' => [
            'before' => $oldMustahik->jumlah_beras_diterima,
            'after' => $mustahik->jumlah_beras_diterima,
        ],
        'satuan_beras' => [
            'before' => $oldMustahik->satuan_beras,
            'after' => $mustahik->satuan_beras,
        ],
        'keterangan' => [
            'before' => $oldMustahik->keterangan,
            'after' => $mustahik->keterangan,
        ],
        'rw_id' => [
            'before' => $oldMustahik->rw_id,
            'after' => $mustahik->rw_id,
        ],
        'wilayah_lain' => [
            'before' => $oldMustahik->wilayah_lain,
            'after' => $mustahik->wilayah_lain,
        ],
        'status' => [
            'before' => $oldMustahik->status,
            'after' => $mustahik->status,
        ],
    ]);
    

    $history->save();
    $no = '62895620014242';
        $msg = "Perubahan data mustahiq dilakukan oleh " . Auth::user()->nama_lengkap . ".\n";

        $msg .= "No. Invoice: #" . $mustahik->code  . "\n\n\n ";
        $msg .= "Lihat detail: https://zis-alhasanah.com/history/showdataupdate/" . $mustahik->code ;
 
        $this->sendMassage2($no, $msg, $mustahik->code );






        // Redirect ke halaman yang sesuai setelah update
        return redirect()->route('mustahik.index')->withSuccess(__('Mustahik successfully updated.'));
    }

}
  