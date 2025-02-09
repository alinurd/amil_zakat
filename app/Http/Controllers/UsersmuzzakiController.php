<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsermuzzakiDataTable;
use App\Models\Kategori;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UsersmuzzakiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsermuzzakiDataTable $dataTable)
    { 
        $pageTitle = trans('global-message.list_form_title',['form' => trans('User Muzzaki')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '';
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

        return view('kategori.form_tambah', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ], [
            'nama_kategori.required' => 'The nama kategori field is required.',
        ]);
  
        // Create a new category instance
        $kategori = new Kategori();
  
        // Fill the category data from the request
        $kategori->nama_kategori = $request->nama_kategori;
 
        // Save the category
        $kategori->save();

        // Redirect back to the index page of categories with a success message
        return redirect()->route('kategori.index')->withSuccess(__('Kategori added successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $kategori = Kategori::findOrFail($id);

        return view('kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
       // Find the category data by ID
       $user = User::findOrFail($id);

       // Pass the category data to the form view
       return view('users.form_edit_muzzaki', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Temukan kategori yang akan diperbarui
        $kategori = User::findOrFail($id);
 
        $request->validate([
            'nama_lengkap' => 'required|string|max:255', // Contoh aturan validasi untuk nama_kategori
            'jenis_kelamin' => 'required', // Contoh aturan validasi untuk nama_kategori
            'nomor_telp' => 'required', // Contoh aturan validasi untuk nama_kategori
            'alamat' => 'required', // Contoh aturan validasi untuk nama_kategori
            // Tambahkan aturan validasi lainnya jika diperlukan
        ]); 
        // Lakukan pemrosesan update kategori
        $kategori->update($request->all()); // Gunakan metode update() untuk melakukan pembaruan

        // Redirect ke halaman yang sesuai setelah update
        return redirect()->route('usersmuzzaki.index')->withSuccess(__('usersmuzzaki successfully updated.'));
    }  

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $status = 'errors';
        $message = __('global-message.delete_form', ['form' => __('kategori')]);

        if ($kategori != '') {
            $kategori->delete();
            $status = 'success';
            $message = __('global-message.delete_form', ['form' => __('kategori')]);
        }

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status, $message);

    } 
}
