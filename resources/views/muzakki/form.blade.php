<x-app-layout :assets="$assets ?? []">
   <div>
      <?php
      $id = $id ?? null;
      ?>
      @if(isset($id))
      {!! Form::model($data, ['route' => ['muzakki.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
      @else
      {!! Form::open(['route' => ['muzakki.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      @endif

      <div class="card">
         <div class="card-header d-flex justify-content-between">
            <div class="header-title">
               <h4 class="card-title">{{$id !== null ? 'Update' : 'New' }} Muzakki</h4>
            </div>
            <div class="card-action">
               <a href="#" class="mt-lg-0 mt-md-0 mt-3 btn btn-secondary btn-icon" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="{{ route('muzakkiCreate') }}" data-app-title="Add user muzakki" data-placement="top" title="New Muzakki">
                  <i class="btn-inner">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                     </svg>
                  </i>
                  <span>New User Muzakki</span>
               </a>
               <a href="{{route('muzakki.index')}}" class="btn  btn-primary" role="button">Back</a>
            </div>
         </div>
         <div class="card-body">
            <div class="new-user-info">
               <div class="row">
                  <div class="form-group col-md-10">
                     <label class="form-label" for="fname">Di bayarkan oleh <span class="text-danger">*</span></label>
                     {{ Form::select('dibayarkan', $agt, "", ['class' => 'form-control', 'placeholder' => 'Select User Role', 'id' => 'dibayarkan']) }}
                  </div>
                  <div class="form-group col-md-2">
                  </div>
               </div>
               <div class="row">
                  <div class="form-group col-md-12">
                     <table class="table" id="muzakkiTable">
                        <thead>
                           <th>No</th>
                           <th>Nama</th>
                           <th>Kategori</th>
                           <th>Type Pembayaran</th>
                           <th>Satuan</th>
                           <th>Jumlah</th>
                        </thead>
                        <tbody>
                           <tr>
                              <td>1</td>
                              <td>
                                 {{ Form::select('user[]', $agt, "", ['class' => 'form-control',  'id' => 'user0']) }}
                              </td>
                              <td>
                                 {{ Form::select('kategori[]', $ktg, "", ['class' => 'form-control', 'id' => 'kategori0']) }}
                              </td>
                              <td>
                                 <input type="radio" name="type[0]" value="Beras" id="Beras0">
                                 <label for="Beras0">Beras</label>
                                 <input type="radio" name="type[0]" value="Uang" id="Uang0">
                                 <label for="Uang0">Uang</label>
                                 <input type="radio" name="type[0]" value="Transfer" id="Transfer0">
                                 <label for="Transfer0">Transfer</label>
                              </td>
                              <td>
                                 <select name="satuan[0]" id="satuan0" class="form-control">
                                    <option value="Kg">Kg</option>
                                    <option value="Liter">Liter</option>
                                    <option value="Rupiah">Rupiah</option>
                                 </select>
                              </td>
                              <td>
                                 <input type="text" name="jumlah[]" id="jumlah0" class="form-control">
                              </td>
                           </tr>
                        </tbody>
                        <tr>
                           <td colspan="4" rowspan="3" class="text-end"><strong>Total:</strong></td>
                           <td class="text-star" colspan="2"><span id="ttlLiter">0</span> <i>Liter</i></td>
                        </tr>
                        <td class="text-star" colspan="2"><span id="ttlKg">0</span> <i>Kilo Gram</i></td>
                        </tr>
                        </tr>
                        <td class="text-star" colspan="2"><span id="ttlRupiah">0</span> <i>Rupiah</i></td>
                        </tr>
                     </table>
                     <span class="btn btn-info btn-sm float-end" id="addRow">Tambah Row</span>
                  </div>
                  <button type="submit" class="btn btn-primary">{{$id !== null ? 'Update' : 'Add' }} Muzakki</button>
               </div>
            </div>
         </div>
      </div>

      {!! Form::close() !!}
   </div>
</x-app-layout>


<script>
   document.getElementById('addRow').addEventListener('click', function() {
      var tableBody = document.querySelector('#muzakkiTable tbody');
      var rowCount = tableBody.rows.length;
      var newRow = tableBody.insertRow(rowCount);

      var cellCount = tableBody.rows[0].cells.length;
      for (var i = 0; i < cellCount; i++) {
         var newCell = newRow.insertCell(i);
         if (i == 0) {
            newCell.textContent = rowCount + 1;
         } else if (i == 2) {
            newCell.innerHTML = '{!! Form::select('kategori[]', $ktg, "", ['class' => 'form-control']) !!}';
         } else if (i == 3) {
            newCell.innerHTML = '<input type="radio" name="type[' + rowCount + ']" value="Beras" id="Beras' + rowCount + '"><label for="Beras' + rowCount + '">Beras</label><input type="radio" name="type[' + rowCount + ']" value="Uang" id="Uang' + rowCount + '"><label for="Uang' + rowCount + '">Uang</label><input type="radio" name="type[' + rowCount + ']" value="Transfer" id="Transfer' + rowCount + '"><label for="Transfer' + rowCount + '">Transfer</label>';
         } else if (i == 4) {
            newCell.innerHTML = '<select name="satuan[' + rowCount + ']" id="satuan' + rowCount + '" class="form-control"><option value="Kg">Kg</option><option value="Liter">Liter</option><option value="Rupiah">Rupiah</option></select>';
         } else if (i == 5) {
            newCell.innerHTML = '<input type="text" name="jumlah[]" id="jumlah' + rowCount + '" class="form-control">';
         } else {
            newCell.innerHTML = '{!! Form::select('user[]', $agt, "", ['class' => 'form-control']) !!}';
         }
      }

      // Tambahkan event listener untuk input jumlah pada baris yang baru ditambahkan
      newRow.querySelector('input[name^="jumlah"]').addEventListener('input', function() {
         calculateTotal();
      });
   });

   // Event listener untuk menghitung total ketika halaman dimuat
   document.addEventListener('DOMContentLoaded', function() {
      calculateTotal();
   });

   // Fungsi untuk menghitung total
   function calculateTotal() {
    var totalLiter = 0;
    var totalRupiah = 0;
    var totalKg = 0;

    var tableBody = document.querySelector('#muzakkiTable tbody');
    var rows = tableBody.rows;
    for (var i = 0; i < rows.length; i++) {
      var satuanSelect = rows[i].querySelector('select[name="satuan['+i+']"]');
        var jumlahInput = rows[i].querySelector('input[name="jumlah[]"]');
        var type = satuanSelect.value;
        var jumlah = parseFloat(jumlahInput.value.replace(',', '.')); // Replace koma dengan titik

        if (isNaN(jumlah)) {
            jumlah = 0;
        }

        if (type === 'Liter') {
            totalLiter += jumlah;
        } else if (type === 'Rupiah') {
            totalRupiah += jumlah;
        } else if (type === 'Kg') {
            totalKg += jumlah;
        }
    }

    // Update total liter dan total rupiah di tabel
    document.getElementById('ttlLiter').textContent = totalLiter.toLocaleString();
    document.getElementById('ttlKg').textContent = totalKg.toLocaleString();
    document.getElementById('ttlRupiah').textContent = totalRupiah.toLocaleString();
}

</script>

