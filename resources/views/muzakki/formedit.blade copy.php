<x-app-layout :assets="$assets ?? []">
   <div>
 
      
      {!! Form::open(['route' => ['muzakki.update',$old['header'][0]->code], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
 
      <div class="card">
         <div class="card-header d-flex justify-content-between">
            <div class="header-title">
               <h4 class="card-title">Update Muzakki</h4> 
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
                     {{ Form::select('dibayarkan', $agt, $old['header'][0]->user_id, ['class' => 'form-control', 'placeholder' => 'Select User Role', 'id' => 'dibayarkan']) }}
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
                           <th>Jumlah jiwa</th>
                           <th>Type Pembayaran</th>
                           <th>Satuan</th>
                           <th>Jumlah</th>
                           <!-- <th>Subtotal</th> -->
                        </thead>
                        <!-- <tbody>
                           <tr>
                              <td>1</td>
                              <td>
                                 {{ Form::select('user[]', $agt, "", ['class' => 'form-control',  'id' => 'user0']) }}
                              </td>
                              <td>

                                 {{ Form::select('kategori[]', $ktg, "", ['class' => 'form-control', 'placeholder' => 'Select Kategri', 'id' => 'kateg0']) }}

                              </td>
                              <td>

                              <input type="number" name="jumlah_jiwa[]" id="jumlah_jiwa0" class="form-control">

                              </td>
                              <td>
                                             <div class="form-check">
                                             <input type="radio" name="type[0]" value="Beras" id="Beras0">
                                             <labe class="form-check-label"l for="Beras0">Beras</labe>
                                            </div>
                                             <div class="form-check">
                                             <input type="radio" name="type[0]" value="Uang" id="Uang0">
                                             <label for="Uang0">Uang</label>
                                            </div>
                                             <div class="form-check">
                                             <input type="radio" name="type[0]" value="Transfer" id="Transfer0">
                                             <label for="Transfer0">Transfer</label>
                                            </div>

                                            
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
                              <td>
                              <span id="subtotal0"> </span>
                              <span id="subtotaltext0"> </span>
                              </td>
                           </tr>
                        </tbody> -->
                        <tbody>
    @foreach($old['detail'] as $index => $detail)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>
            <input type="hidden" name="id[]" value="{{$detail->id}}">
            <input type="hidden" name="code" value="{{$detail->code}}">
            {{ Form::select('user[]', $agt, $detail->user_id, ['class' => 'form-control', 'id' => 'user' . $index]) }}
        </td>
        <td>
            {{ Form::select('kategori[]', $ktg, $detail->kategori_id, ['class' => 'form-control', 'placeholder' => 'Select Kategri', 'id' => 'kateg' . $index]) }}
        </td>
        <td>
            <input type="number" name="jumlah_jiwa[]" id="jumlah_jiwa{{ $index }}" class="form-control" value="{{ $detail->jumlah_jiwa }}">
        </td>


        <td>
            <div class="form-check">
                <input type="radio" name="type[{{ $index }}]" value="Beras" id="Beras{{ $index }}" {{ $detail->type == 'Beras' ? 'checked' : '' }}>
                <label class="form-check-label" for="Beras{{ $index }}">Beras</label>
            </div>
            <div class="form-check">
                <input type="radio" name="type[{{ $index }}]" value="Transfer" id="Transfer{{ $index }}" {{ $detail->type == 'Transfer' ? 'checked' : '' }}>
                <label class="form-check-label" for="Transfer{{ $index }}">Transfer</label>
            </div>
            <div class="form-check">
                <input type="radio" name="type[{{ $index }}]" value="Rupiah" id="Rupiah{{ $index }}" {{ $detail->type == 'Rupiah' ? 'checked' : '' }}>
                <label class="form-check-label" for="Rupiah{{ $index }}">Rupiah</label>
            </div>
        </td>
        <td>
            <select name="satuan[{{ $index }}]" id="satuan{{ $index }}" class="form-control">
                <option value="Kg" {{ $detail->satuan == 'Kg' ? 'selected' : '' }}>Kg</option>
                <option value="Liter" {{ $detail->satuan == 'Liter' ? 'selected' : '' }}>Liter</option>
                <option value="Rupiah" {{ $detail->satuan == 'Rupiah' ? 'selected' : '' }}>Rupiah</option>
            </select>
        </td>
        <td>
            <input type="text" name="jumlah[]" id="jumlah{{ $index }}" class="form-control" value="{{ $detail->jumlah_bayar }}">
        </td>
        <!-- <td>
            <span id="subtotal{{ $index }}">Subtotal</span>
        </td> -->
    </tr>
    @endforeach
</tbody>

                        <tr>

                           <td colspan="5" rowspan="3" class="text-end"><strong>Total:</strong></td>
                           <td class="text-star" colspan="2"><span id="ttlLiter">0</span> <i>Liter</i></td>
                        </tr>
                        <td class="text-star" colspan="2"><span id="ttlKg">0</span> <i>Kilo Gram</i></td>
                        </tr>

                        </tr>
                        <td class="text-star" colspan="2"><span id="ttlRupiah">0</span> <i>Rupiah</i></td>
                        </tr>
                     </table>
                     <!-- <span class="btn btn-info btn-sm float-end" id="addRow">Tambah Row</span> -->
                  </div>
                  <button type="submit" class="btn btn-primary">Update Muzakki</button>
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
                newCell.innerHTML = '<input type="number" name="jumlah_jiwa[]" id="jumlah_jiwa' + rowCount + '" class="form-control">';
            } else if (i == 4) {
               newCell.innerHTML = `
    <div class="form-check">
        <input class="form-check-input" type="radio" name="type[${rowCount}]" value="Beras" id="Beras${rowCount}">
        <label class="form-check-label" for="Beras${rowCount}">Beras</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="type[${rowCount}]" value="Uang" id="Uang${rowCount}">
        <label class="form-check-label" for="Uang${rowCount}">Uang</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="type[${rowCount}]" value="Transfer" id="Transfer${rowCount}">
        <label class="form-check-label" for="Transfer${rowCount}">Transfer</label>
    </div>
`;


               
            } else if (i == 5) {
                newCell.innerHTML = '<select name="satuan[' + rowCount + ']" id="satuan' + rowCount + '" class="form-control"><option value="Kg">Kg</option><option value="Liter">Liter</option><option value="Rupiah">Rupiah</option></select>';

            } else if (i == 6) {
                newCell.innerHTML = '<input type="text" name="jumlah[]" id="jumlah' + rowCount + '" class="form-control">';
            } else if (i == 7) {
               newCell.innerHTML = '<span id="subtotal' + rowCount +'"> </span> <span id="subtotaltext' + rowCount +'"> </span>';
            } else {
                newCell.innerHTML = '{!! Form::select('user[]', $agt, "", ['class' => 'form-control']) !!}';
            }
        }

          // Tambahkan event listener untuk input jumlah pada baris yang baru ditambahkan
       



        

        // Tambahkan event listener untuk input jumlah pada baris yang baru ditambahkan
        newRow.querySelector('input[name^="jumlah[]"]').addEventListener('input', function() {
            calculateTotal();
            caclculateSubtotal();

        });

        newRow.querySelector('input[name^="jumlah_jiwa[]"]').addEventListener('input', function() {
                calculateTotal();
                caclculateSubtotal();
            });

            newRow.querySelector('select[name^="satuan[' + rowCount + ']"]').addEventListener('change', function() {
    calculateTotal();
    calculateSubtotalForRow(rowCount);
});

newRow.querySelector('input[name^="type[' + rowCount + ']"]').addEventListener('change', function() {
    calculateTotal();
    calculateSubtotalForRow(rowCount);
});
            
    });

    // Event listener untuk menghitung total ketika halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();
        caclculateSubtotal();   
         calculateSubtotalForRow(rowCount);

    });


    // Memilih elemen dengan id jumlah_jiwa0
var jumlahJiwaElem = document.querySelector('#jumlah_jiwa0');

// Menambahkan event listener untuk elemen jumlah_jiwa0
jumlahJiwaElem.addEventListener('input', function() {
    calculateSubtotalForRow(0);
});

// Memilih elemen dengan id jumlah0
var jumlahElem = document.querySelector('#jumlah0');

// Menambahkan event listener untuk elemen jumlah0
jumlahElem.addEventListener('input', function() {
    calculateSubtotalForRow(0);
});

// Memilih elemen dengan id satuan0
var satuanElem = document.querySelector('#satuan0');

// Menambahkan event listener untuk elemen satuan0
satuanElem.addEventListener('change', function() {
    calculateSubtotalForRow(0);
});


    function calculateSubtotalForRow(rowCount) {
    var jumlahJiwa = parseFloat(document.querySelector('#jumlah_jiwa' + rowCount).value);
    var jumlah = parseFloat(document.querySelector('#jumlah' + rowCount).value.replace(',', '.')); // Replace koma dengan titik
    var satuanSelect = document.querySelector('#satuan' + rowCount);
    var typeInput = document.querySelector('input[name="type[' + rowCount + ']"]:checked');
    var type = typeInput ? typeInput.value : '';

    if (isNaN(jumlah)) {
        jumlah = 0;
    }

    var subtotal = jumlahJiwa * jumlah;
    document.querySelector('#subtotal' + rowCount).textContent = subtotal.toLocaleString('id-ID');
    document.querySelector('#subtotaltext' + rowCount).textContent = satuanSelect.value;

    // Update total jika diperlukan
    caclculateSubtotal();
}



    function caclculateSubtotal() {
      calculateTotal();

    var rows = document.querySelectorAll('#muzakkiTable tbody tr');
    var total = 0;

    rows.forEach(function(row, index) {
        var jumlahJiwa = parseFloat(row.querySelector('#jumlah_jiwa' + index).value);
        var jumlah = parseFloat(row.querySelector('#jumlah' + index).value.replace(',', '.')); // Replace koma dengan titik
        var satuanSelect = row.querySelector('#satuan' + index);
        var typeInput = row.querySelector('input[name^="type[' + index + ']"]:checked');
        var type = typeInput ? typeInput.value : '';


        if (isNaN(jumlah)) {
            jumlah = 0;
        }

        var subtotal = jumlahJiwa * jumlah;
        total += subtotal;

        row.querySelector('#subtotal' + index).textContent = subtotal.toLocaleString('id-ID');
        row.querySelector('#subtotaltext' + index).textContent = satuanSelect.value;
    });

}



    // Fungsi untuk menghitung total
    function calculateTotal() {
        var totalLiter = 0;
        var totalRupiah = 0;
        var totalKg = 0;
        var totalJiwa = 0;

        var tableBody = document.querySelector('#muzakkiTable tbody');
        var rows = tableBody.rows;
        for (var i = 0; i < rows.length; i++) {
            var satuanSelect = rows[i].querySelector('select[name="satuan[' + i + ']"]');
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

        // Update total liter, total rupiah, total kg, dan total jiwa di tabel
        document.getElementById('ttlLiter').textContent = totalLiter.toLocaleString();
        document.getElementById('ttlKg').textContent = totalKg.toLocaleString();
        document.getElementById('ttlRupiah').textContent = totalRupiah.toLocaleString();
     }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
 


<script>
    $(document).ready(function() {
        // Initialize Select2 for the initial select dropdown
        $('#dibayarkan').select2({
            placeholder: '-- Select --',
            allowClear: true // Optional: This will allow clearing the selected option
        });
        $('#user0').select2({
            placeholder: '-- Select --',
            allowClear: true // Optional: This will allow clearing the selected option
        });
        $('#kateg0').select2({
            placeholder: '-- Select --',
            allowClear: true // Optional: This will allow clearing the selected option
        });
        $('#satuan0').select2({
            placeholder: '-- Select --',
            allowClear: true // Optional: This will allow clearing the selected option
        });

        // Initialize Select2 for dynamically added select dropdowns
        $(document).on('DOMNodeInserted', function(e) {
            if ($(e.target).is('select.form-control')) {
                $(e.target).select2({
                    placeholder: 'Select User',
                    allowClear: true
                });
            }
        });
    });
</script>
