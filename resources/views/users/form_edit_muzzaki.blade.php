<x-app-layout :assets="$assets ?? []">
   <div>
      {!! Form::model($user, ['route' => ['usersmuzzaki.update', $user->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}
      <div class="row">   
         <div class="col-xl-9 col-lg-12"> 
            <div class="card">  
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Edit User Muzzaki</h4>
                  </div> 
                  <div class="card-action"> 
                        <a href="{{ route('usersmuzzaki.index') }}" class="btn btn-sm btn-primary" role="button">Back</a>
                  </div> 
               </div>   
               <div class="card-body">   
                  <div class="new-user-info">
                        <div class="row"> 
                           <div class="form-group col-md-12">
                              <label class="form-label" for="nama_lengkap">Nama Lengkap: <span class="text-danger">*</span></label>
                              {!! Form::text('nama_lengkap', old('nama_lengkap', $user->nama_lengkap), ['class' => 'form-control', 'required', 'placeholder' => 'Nama Kategori']) !!}
                           </div>
                        </div>
                        
                        <div class="row"> 
                        <div class="form-group col-md-12">
                                 <label class="form-label" for="jenis_kelamin">Jenis Kelamin: <span class="text-danger">*</span></label>
                                 <select name="jenis_kelamin" class="form-control" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ $user->jenis_kelamin == "Laki-laki" ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="Perempuan" {{ $user->jenis_kelamin == "Perempuan" ? 'selected' : '' }}>Perempuan</option>
                                 </select>
                              </div> 
                        </div>
                        <div class="row"> 
                           <div class="form-group col-md-12">
                              <label class="form-label" for="nama_lengkap">Nomor Telp: <span class="text-danger">*</span></label>
                              {!! Form::text('nomor_telp', old('nomor_telp', $user->nomor_telp), ['class' => 'form-control', 'required', 'placeholder' => 'Nama Kategori']) !!}
                              <i class="text-warning">note: Nomor Telp Harus diawali dengan 62. comtoh 6285817046097</i>
                           </div>
                        </div>
                        <div class="row"> 
                           
                           <div class="form-group col-md-12">
                              <label class="form-label" for="alamat">Alamat: <span class="text-danger">*</span></label>
                              {!! Form::text('alamat', old('alamat', $user->alamat), ['class' => 'form-control', 'required', 'placeholder' => 'Nama Kategori']) !!}
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                  </div>
               </div>   
            </div>  
         </div>
        </div>
      {!! Form::close() !!}
   </div> 
</x-app-layout>
