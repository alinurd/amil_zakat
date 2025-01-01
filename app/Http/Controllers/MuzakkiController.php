<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\MuzakkiDataTable;
use App\Exports\Report;
use App\Models\Muzakki;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use App\Models\Kategori;
use App\Models\MuzakkiHeader;
use App\Models\TransHistory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class MuzakkiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MuzakkiDataTable $dataTable, Request $request)
{
    $hideFilter='';
    if($request->input()){
        $hideFilter = '<a href="' . route('muzakki.index') . '" class="btn btn-warning btn-sm" style="margin-top: 5px;">
            <svg width="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.76045 14.3667C9.18545 13.7927 8.83545 13.0127 8.83545 12.1377C8.83545 10.3847 10.2474 8.97168 11.9994 8.97168C12.8664 8.97168 13.6644 9.32268 14.2294 9.89668" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M15.1049 12.6987C14.8729 13.9887 13.8569 15.0067 12.5679 15.2407" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M6.65451 17.4722C5.06751 16.2262 3.72351 14.4062 2.74951 12.1372C3.73351 9.85823 5.08651 8.02823 6.68351 6.77223C8.27051 5.51623 10.1015 4.83423 11.9995 4.83423C13.9085 4.83423 15.7385 5.52623 17.3355 6.79123" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M19.4473 8.99072C20.1353 9.90472 20.7403 10.9597 21.2493 12.1367C19.2823 16.6937 15.8063 19.4387 11.9993 19.4387C11.1363 19.4387 10.2853 19.2987 9.46729 19.0257" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M19.8868 4.24951L4.11279 20.0235" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
                Sembunyikan Filter
            </a>
        ';
    }
    

    $filter = '<form action="' . route('muzakki.index') . '" method="GET" class="d-flex align-items-center" style="padding-right: 10px;">
            <div class="form-group mb-0 mr-2">
                <select name="year" id="year" class="form-control">
                    <option value="" disabled selected>Pilih Tahun</option>
                    <option value="2025" ' . (request('year') == '2025' ? 'selected' : '') . '>2025</option>
                    <option value="2026" ' . (request('year') == '2026' ? 'selected' : '') . '>2026</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">
                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.56517 3C3.70108 3 3 3.71286 3 4.5904V5.52644C3 6.17647 3.24719 6.80158 3.68936 7.27177L8.5351 12.4243L8.53723 12.4211C9.47271 13.3788 9.99905 14.6734 9.99905 16.0233V20.5952C9.99905 20.9007 10.3187 21.0957 10.584 20.9516L13.3436 19.4479C13.7602 19.2204 14.0201 18.7784 14.0201 18.2984V16.0114C14.0201 14.6691 14.539 13.3799 15.466 12.4243L20.3117 7.27177C20.7528 6.80158 21 6.17647 21 5.52644V4.5904C21 3.71286 20.3 3 19.4359 3H4.56517Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                Filter
            </button>
        </form>
    ';

    $pageTitle = trans('global-message.list_form_title', ['form' => trans('Muzakki')]);
    $auth_user = AuthHelper::authSession();
    $assets = ['data-table'];
    $headerAction = '<a href="' . route('muzakki.create') . '" class="btn btn-primary" role="button">Add Muzakki</a>';

    return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction', 'filter', 'hideFilter'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agt = User::where("user_type", "pemberi")->where("status", "active")->get()->pluck('nama_lengkap', 'id');
        $ktg = Kategori::pluck('nama_kategori', 'id');

        return view('muzakki.form', compact('agt', 'ktg'));
    }

    public function editmuzzaki($code)
    {
        $agt = User::where("user_type", "pemberi")->where("status", "active")->get()->pluck('nama_lengkap', 'id');
        $ktg = Kategori::pluck('nama_kategori', 'id');

        $old['detail'] = Muzakki::where('code', $code)->with('user', 'kategori')->get();
        $old['header'] = MuzakkiHeader::where('code', $code)->with('user')->get();

        return view('muzakki.formedit', compact('agt', 'ktg','old'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'dibayarkan' => 'required',
            'user' => 'required|array',
            'user.*' => 'exists:users,id',
            'kategori' => 'required|array',
            'kategori.*' => 'exists:kategori,id',
            'type' => 'required|array',
            'satuan' => 'required|array',
            'jumlah' => 'required|array',
            'created_by' => 'required|array',
        ]); 

        $lastId = MuzakkiHeader::orderByDesc('id')->first();
        $x = $lastId ? $lastId->id : 0;

        $MuzakkiHeader = MuzakkiHeader::create([
            'user_id' => $validatedData['dibayarkan'],
            'code' => $this->generateCodeById("MZK", $x + 1),
            'created_by' => Auth::user()->role, // Tambahkan nilai created_by dari user yang login
        ]);

        foreach ($validatedData['user'] as $key => $user) {
            $muzakki = Muzakki::create([
                'code' => $MuzakkiHeader->code,
                'user_id' => $user,
                'jumlah_bayar' => $validatedData['jumlah'][$key],
                'jumlah_jiwa' => $request['jumlah_jiwa'][$key],
                'kategori_id' => $validatedData['kategori'][$key],
                'type' => $validatedData['type'][$key],
                'satuan' => $validatedData['satuan'][$key],
                'created_by' => Auth::user()->role, // Tambahkan ini
            ]);

            $useHis = User::where('id', $user)->first();
            $kategHis = kategori::where('id', $validatedData['kategori'][$key])->first();

            $history = new TransHistory();
            $history->muzakki_id = $muzakki->id;
            $history->code = $MuzakkiHeader->code;
            $history->method = "Create";
            $history->user = Auth::user()->nama_lengkap;
            $history->changes = json_encode([
                'code_hst' => $this->generateCodeById("HST", $x + 1),
                'user_id' => $useHis->nama_lengkap, // Nilai sebelumnya tidak ada (baru saja dibuat)
                'jumlah_bayar' => $validatedData['jumlah'][$key],
                'jumlah_jiwa' => $request['jumlah_jiwa'][$key],
                'kategori_id' => $kategHis->nama_kategori,
                'type' => $validatedData['type'][$key],
                'satuan' => $validatedData['satuan'][$key],
            ]);
            $history->save();
        
            $x++; // Perbarui nilai x untuk kode berikutnya
        }
        
        $dibayarkan = User::where('id', $validatedData['dibayarkan'])->first();
        //  $no = '6289528518495'; 
        $no = $dibayarkan->nomor_telp;  
        $msg = "Alhamdulillah, telah diterima penunaikan zis/fidyah dari Bapak/ibu: " . $dibayarkan->nama_lengkap . ".\n";
        $msg .= "No. Invoice: #" . $MuzakkiHeader->code . "\n\n\n ";
        $msg .= "Lihat detail: https://zis-alhasanah.com/showinvoice/" . $MuzakkiHeader->code;
        $this->cetakinvoice($MuzakkiHeader->code);

        $this->sendMassage1($no, $msg, $MuzakkiHeader->code);
        //  $this->sendMassage($no,$msg);
        //  $this->sendWa($no,$n); 

        $key = 'b42be3006183b810feb31c0cc4162822-997e6839-9163-4293-b012-8e9834e6264f';
        $base_url = 'qymz4m.api.infobip.com';
        return redirect()->route('invoice', ['code' => $MuzakkiHeader->code])->withSuccess(__('Pembayaran berhasil dan  invoice telah terkirim kepada ' . $dibayarkan->nama_lengkap));
    }

   public function update(Request $request)
   {
        // Log awal untuk debugging
        \Log::info('Memulai proses update dengan data request:', $request->all());

        try {
            // Validasi data
            $validatedData = $request->validate([
                'dibayarkan' => 'required',
                'user' => 'required|array',
                'user.*' => 'exists:users,id',
                'kategori' => 'required|array',
                'kategori.*' => 'exists:kategori,id',
                'type' => 'required|array',
                'satuan' => 'required|array',
                'jumlah' => 'required|array',
                'jumlah_jiwa' => 'required|array',
            ]);

        // Update MuzakkiHeader
        MuzakkiHeader::withoutTimestamps(function () use ($request, $validatedData) {
            MuzakkiHeader::where('code', $request->code)->update([
                'user_id' => $validatedData['dibayarkan'],
                'created_by' => Auth::user()->id, // Tambahkan created_by
            ]);
        });

        // Loop melalui data yang diberikan
        foreach ($validatedData['user'] as $key => $user) {
            if (empty($request->id[$key])) {
                // Data baru
                $muzakki = new Muzakki([
                    'code' => $request->code,
                    'user_id' => $user,
                    'jumlah_bayar' => $validatedData['jumlah'][$key],
                    'jumlah_jiwa' => $validatedData['jumlah_jiwa'][$key],
                    'kategori_id' => $validatedData['kategori'][$key],
                    'type' => $validatedData['type'][$key],
                    'satuan' => $validatedData['satuan'][$key],
                    'created_by' => Auth::user()->id, // Tambahkan created_by untuk data baru
                ]);
        
                if (!$muzakki->save()) {
                    \Log::error('Gagal menyimpan Muzakki baru:', $muzakki->toArray());
                    throw new \Exception('Gagal menyimpan data Muzakki baru.');
                }
        
                // Log TransHistory untuk data baru
                  
            } else {
                // Data lama (update)
                $muzakki = Muzakki::find($request->id[$key]);
                if (!$muzakki) {
                    throw new \Exception('Data Muzakki dengan ID ' . $request->id[$key] . ' tidak ditemukan.');
                }
        
                $oldValues = $muzakki->getOriginal();
                $muzakki->user_id = $user;
                $muzakki->jumlah_bayar = $validatedData['jumlah'][$key];
                $muzakki->jumlah_jiwa = $validatedData['jumlah_jiwa'][$key];
                $muzakki->kategori_id = $validatedData['kategori'][$key];
                $muzakki->type = $validatedData['type'][$key];
                $muzakki->satuan = $validatedData['satuan'][$key];
                $muzakki->created_by = Auth::user()->id; // Tambahkan created_by untuk data update

                if (!$muzakki->save()) {
                    \Log::error('Gagal memperbarui Muzakki:', $muzakki->toArray());
                    throw new \Exception('Gagal memperbarui data Muzakki.');
                }
        
              
            }
        }
        
        return redirect()->route('invoice', ['code' => $request->code])->withSuccess(__('Pembayaran berhasil diupdate'));
    } catch (\Exception $e) {
        // Log kesalahan jika terjadi exception
        \Log::error('Error dalam proses update:', ['message' => $e->getMessage()]);
        return back()->withErrors(__('Terjadi kesalahan saat memperbarui data: ') . $e->getMessage());
    } 
}
    

    public function invoice($code)
    {
        $data['detail'] = Muzakki::where('code', $code)->with('user', 'kategori')->get();
        $data['header'] = MuzakkiHeader::where('code', $code)->with('user')->get();
        return view('muzakki.print', compact('data'));
        // return view('invoice', compact('data'));
    }

    public function cetakinvoices($code)
    {
        $detail = Muzakki::where('code', $code)->with('user', 'kategori')->get();
        $header = MuzakkiHeader::where('code', $code)->with('user')->get();
        // return view('muzakki.print', compact('data'));
        return view('invoice', compact('header', 'detail'));
    }
 
    public function cetakinvoice($code)
    {
        $detail = Muzakki::where('code', $code)->with('user', 'kategori')->get();
        $header = MuzakkiHeader::where('code', $code)->with('user')->get();

        // Render view to PDF
        $pdf = PDF::loadView('invoice', compact('header', 'detail'));

        // // Save PDF to public folder
        $pdf->save(public_path('invoice/invoice_' . $code . '.pdf'));

        // Return view or response
        // return view('invoice', compact('header','detail'));
        return $pdf->stream('invoice_' . $code . '.pdf');
    }

    public function muzakkiCreate()
    {
        $view = view('muzakki.form-user')->render();
        return response()->json(['data' =>  $view, 'status' => true]);
    }

    public function muzakkiUserStore(Request $request)
    {
        $request['user_type'] = "pemberi";

        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nomor_telp' => 'nullable|string',
            'alamat' => 'required|string',
            'user_type' => 'required|in:admin,pemberi,penerima',
        ]);

        $user = User::create([
            'nama_lengkap' => $validatedData['nama_lengkap'],
            'email' => uniqid() . '@example.com', // Kolom email harus unik, kita buat random untuk sementara
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'nomor_telp' => $validatedData['nomor_telp'],
            'alamat' => $validatedData['alamat'],
            'user_type' => $validatedData['user_type'],
            'status' => 'active', // Mengisi status default
            'role' => null, // Kolom role bisa diisi dengan null sesuai permintaan
        ]);

        // $agt = User::where("user_type", "pemberi")->where("status", "active")->get()->pluck('nama_lengkap', 'id');
        // // $agt = Role::where('status',1)->get()->pluck('title', 'id');

        // return view('muzakki.form', compact('agt'));
    }
 
    public function destroy($code)
    {
        // dd($id);
        $kategori = Muzakki::where('code', $code);
        $status = 'errors';
        $message = __('global-message.delete_form', ['form' => __('muzakki')]);

        if ($kategori != '') {
            $kategori->delete();
            $status = 'success';
            $message = __('global-message.delete_form', ['form' => __('muzakki')]);
        }

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status, $message);
    }
}
