@push('scripts')
<script src="{{asset('vendor/sortable/Sortable.js')}}"></script>
<script src="{{asset('js/plugins/kanban.js')}}"></script>
@endpush
<x-app-layout :assets="$assets ?? []">
<div class="row">
      <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                  <form class="form-horizontal mt-1 d-flex align-items-center" method="GET" action="{{ route('mustahikreport.index') }}">
                     <label class="control-label mb-0 me-2">Filter Wilayah:</label>
                     <div class="me-3">
                        <select name="rt_rw" id="rt_rw" class="form-control">
                              <option value="">Pilih RT/RW</option>
                              <option value="1">RT.001/RW.004</option>
                              <option value="2">RT.002/RW.004</option>
                              <option value="3">RT.003/RW.004</option>
                              <option value="4">RT.004/RW.004</option>
                              <option value="5">RT.005/RW.004</option>
                              <option value="6">RT.006/RW.004</option>
                              <option value="7">RT.007/RW.004</option>
                              <option value="8">RT.008/RW.004</option>
                              <option value="9">RT.009/RW.004</option>
                              <option value="10">RT.010/RW.004</option>
                              <option value="11">RT.011/RW.004</option>
                              <option value="12">RT.012/RW.004</option>
                              <option value="13">RT.013/RW.004</option>
                              <option value="14">RT.014/RW.004</option>
                              <option value="15">RT.015/RW.004</option>
                              <option value="16">RT.016/RW.004</option>
                              <option value="17">RT.017/RW.004</option>
                              <option value="18">RT.018/RW.004</option>
                              <option value="lainnya">lainnya</option>
                        </select>
                     </div>
                     <button type="submit" class="btn btn-danger">Cari</button>
                  </form>
            </div>
         </div>
      </div>
      </div>

      <div class="col-sm-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Report Mustahiq</h4>
                  </div>
                  <!-- <div class="card-action">
                     <a href="{{route('mustahikreport')}}">
                        <span class="btn btn-primary float-end" id="export">Export to Excel</span>
                     </a> 
                  </div>  -->
                  @if($data['detail']->isNotEmpty()) <!-- Tambahkan kondisi untuk memeriksa apakah ada data yang sesuai dengan filter -->
                  <div class="card-action">
                     <a href="{{ route('mustahikreport', ['rt_rw' => request('rt_rw')]) }}"> <!-- Tambahkan rute untuk mengekspor data sesuai dengan filter yang dipilih -->
                           <span class="btn btn-primary float-end" id="export">Export to Excel</span>
                     </a>
                  </div>
                  @endif
            </div>   
            <div class="card-body"> 
               <div class="table-responsive">
               <table id="user-list-table" class="table table-striped" role="grid" data-toggle="data-table">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Informasi Wilayah</th>
                           <th>Code Invoice</th>
                           <th>Nama</th>
                           <th>Kategori Mustahiq</th>
                           <th>Kategori Zakat Diterima</th>
                           <th>Jumlah Uang</th>
                           <th>Jumlah Beras</th>
                        </tr>
                     </thead>
                     <tbody> 
                        <?php $no=1?>
                        @foreach($data['detail'] as $detail)
                        @if($detail->code)
                         <tr>
                           <td>{{ $no++ }}</td>
                           <td>
                                 @if($detail->rw_id || $detail->wilayah_lain)
                                    @if($detail->rw_id) 
                                       {{ $detail->rw->rt }}/RW004
                                    @else
                                       {{ $detail->wilayah_lain }}
                                    @endif
                                 @else
                                    Tidak ada informasi
                                 @endif
                           </td>
                           <td>{{ $detail->code }}</td>
                           <td>{{ $detail->nama_lengkap }}</td>
                           <td>{{ $detail->kategori_mustahik }}</td>
                           <td>{{ $detail->kategori->nama_kategori }}</td>
                           <td>Rp{{ number_format($detail->jumlah_uang_diterima, 0, ',', '.') }}</td>
                           @if($detail->jumlah_beras_diterima == '0')
                           <td>{{ $detail->jumlah_beras_diterima }}</td>
                           @else 
                           <td>{{ $detail->jumlah_beras_diterima }} {{ $detail->satuan_beras }}</td>
                           @endif
                        </tr>    
                        @endif
                        @endforeach 
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>

</div>
</x-app-layout>

