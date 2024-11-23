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
                  <div class="form-group col-md-12" style="overflow-x: auto;">
                  <table class="table mb-3" id="muzakkiTable">
                        <thead>
                           <th>No</th>
                           <th>Nama</th>
                           <th>Kategori</th>
                           <th>Jumlah jiwa</th>
                           <th>Type Pembayaran</th>
                           <th>Satuan</th>
                           <th>Satuan</th>
                           <th>Subtotal</th>
                           <!-- <th>Aksi</th> -->
                        </thead>
                        <tbody>
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
                              <span id="subtotal0"> </span><input type="hidden" name="subtotal[]" id="subInt0">
                              <span id="subtotaltext0"> </span>
                            </td>
                               <!-- <td>
                                <span class="btn btn-danger btn-sm" disabled>Hapus</span>
                               </td> -->
                           </tr>
                        </tbody>
                        <tr>

                           <td colspan="6" rowspan="3" class="text-end"><strong>Total:</strong></td>
                           <td class="text-star" colspan="2"><span id="ttlLiter">0</span> <i>Liter</i></td>
                        </tr>
                        <td class="text-star" colspan="2"><span id="ttlKg">0</span> <i>Kilo Gram</i></td>
                        </tr>

                        </tr>
                        <td class="text-star" colspan="2"><span id="ttlRupiah">0</span> <i>Rupiah</i></td>
                        </tr>
                     </table>
                     <span class="btn btn-dark btn-sm float-end" id="addRow">Tambah Row</span>
                     <span class="float-end" >&nbsp; </span>
                     <span class="btn btn-info btn-sm float-end" id="getTotal">
                        <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.4">
                            <path
                                d="M4.88076 14.6713C4.74978 14.2784 4.32504 14.066 3.93208 14.197C3.53912 14.328 3.32675 14.7527 3.45774 15.1457L4.88076 14.6713ZM20.8808 15.1457C21.0117 14.7527 20.7994 14.328 20.4064 14.197C20.0135 14.066 19.5887 14.2784 19.4577 14.6713L20.8808 15.1457ZM4.16925 14.9085C3.45774 15.1457 3.45785 15.146 3.45797 15.1464C3.45802 15.1465 3.45815 15.1469 3.45825 15.1472C3.45845 15.1478 3.45868 15.1485 3.45895 15.1493C3.45948 15.1509 3.46013 15.1528 3.46092 15.1551C3.46249 15.1597 3.46456 15.1657 3.46716 15.1731C3.47235 15.188 3.47961 15.2084 3.48902 15.2341C3.50782 15.2854 3.53521 15.3576 3.5717 15.4477C3.64461 15.6279 3.7542 15.8805 3.90468 16.1814C4.2048 16.7817 4.67223 17.5836 5.34308 18.3886C6.68942 20.0043 8.88343 21.6585 12.1693 21.6585V20.1585C9.45507 20.1585 7.64908 18.8128 6.49542 17.4284C5.91627 16.7334 5.5087 16.0354 5.24632 15.5106C5.11555 15.2491 5.02201 15.0329 4.96212 14.8849C4.9322 14.811 4.91076 14.7543 4.89733 14.7177C4.89062 14.6994 4.88593 14.6861 4.88318 14.6783C4.88181 14.6744 4.88093 14.6718 4.88053 14.6706C4.88033 14.67 4.88025 14.6698 4.88029 14.6699C4.88031 14.67 4.88036 14.6701 4.88044 14.6704C4.88047 14.6705 4.88056 14.6707 4.88058 14.6708C4.88067 14.671 4.88076 14.6713 4.16925 14.9085ZM12.1693 21.6585C15.4551 21.6585 17.6491 20.0043 18.9954 18.3886C19.6663 17.5836 20.1337 16.7817 20.4338 16.1814C20.5843 15.8805 20.6939 15.6279 20.7668 15.4477C20.8033 15.3576 20.8307 15.2854 20.8495 15.2341C20.8589 15.2084 20.8662 15.188 20.8713 15.1731C20.8739 15.1657 20.876 15.1597 20.8776 15.1551C20.8784 15.1528 20.879 15.1509 20.8796 15.1493C20.8798 15.1485 20.8801 15.1478 20.8803 15.1472C20.8804 15.1469 20.8805 15.1465 20.8805 15.1464C20.8807 15.146 20.8808 15.1457 20.1693 14.9085C19.4577 14.6713 19.4578 14.671 19.4579 14.6708C19.4579 14.6707 19.458 14.6705 19.4581 14.6704C19.4581 14.6701 19.4582 14.67 19.4582 14.6699C19.4583 14.6698 19.4582 14.67 19.458 14.6706C19.4576 14.6718 19.4567 14.6744 19.4553 14.6783C19.4526 14.6861 19.4479 14.6994 19.4412 14.7177C19.4277 14.7543 19.4063 14.811 19.3764 14.8849C19.3165 15.0329 19.223 15.2491 19.0922 15.5106C18.8298 16.0354 18.4222 16.7334 17.8431 17.4284C16.6894 18.8128 14.8834 20.1585 12.1693 20.1585V21.6585Z"
                                fill="currentColor"></path>
                            <path d="M21.5183 19.2271C21.4293 19.2234 21.3427 19.196 21.2671 19.1465L16.3546 15.8924C16.2197 15.8026 16.1413 15.6537 16.148 15.4969C16.1546 15.34 16.2452 15.1982 16.3873 15.1202L21.5571 12.2926C21.7075 12.2106 21.8932 12.213 22.0416 12.3003C22.1907 12.387 22.2783 12.5436 22.2712 12.7096L22.014 18.7913C22.007 18.9573 21.9065 19.1059 21.7506 19.1797C21.6772 19.215 21.597 19.2305 21.5183 19.2271" fill="currentColor"></path>
                            </g>
                            <path
                            d="M20.0742 10.0265C20.1886 10.4246 20.6041 10.6546 21.0022 10.5401C21.4003 10.4257 21.6302 10.0102 21.5158 9.61214L20.0742 10.0265ZM4.10803 8.88317C3.96071 9.27031 4.15513 9.70356 4.54226 9.85087C4.92939 9.99818 5.36265 9.80377 5.50996 9.41664L4.10803 8.88317ZM20.795 9.81934C21.5158 9.61214 21.5157 9.6118 21.5156 9.61144C21.5155 9.61129 21.5154 9.6109 21.5153 9.61059C21.5152 9.60998 21.515 9.60928 21.5147 9.60848C21.5143 9.60689 21.5137 9.60493 21.513 9.6026C21.5116 9.59795 21.5098 9.59184 21.5075 9.58431C21.503 9.56925 21.4966 9.54853 21.4882 9.52251C21.4716 9.47048 21.4473 9.39719 21.4146 9.3056C21.3493 9.12256 21.2503 8.8656 21.1126 8.55861C20.8378 7.94634 20.4044 7.12552 19.7678 6.29313C18.4902 4.62261 16.3673 2.87801 13.0844 2.74053L13.0216 4.23922C15.7334 4.35278 17.4816 5.77291 18.5763 7.20436C19.1258 7.92295 19.5038 8.63743 19.744 9.17271C19.8638 9.43949 19.9482 9.65937 20.0018 9.80972C20.0286 9.88483 20.0477 9.94238 20.0596 9.97951C20.0655 9.99808 20.0696 10.0115 20.072 10.0195C20.0732 10.0235 20.074 10.0261 20.0744 10.0273C20.0746 10.0278 20.0746 10.0281 20.0746 10.028C20.0746 10.0279 20.0745 10.0278 20.0745 10.0275C20.0744 10.0274 20.0744 10.0272 20.0743 10.0271C20.0743 10.0268 20.0742 10.0265 20.795 9.81934ZM13.0844 2.74053C9.80146 2.60306 7.54016 4.16407 6.12741 5.72193C5.42345 6.49818 4.92288 7.27989 4.59791 7.86704C4.43497 8.16144 4.31491 8.40923 4.23452 8.58617C4.1943 8.67471 4.16391 8.7457 4.14298 8.79616C4.13251 8.82139 4.1244 8.84151 4.11859 8.85613C4.11568 8.86344 4.11336 8.86938 4.1116 8.8739C4.11072 8.87616 4.10998 8.87807 4.10939 8.87962C4.10909 8.88039 4.10883 8.88108 4.1086 8.88167C4.10849 8.88196 4.10834 8.88234 4.10829 8.88249C4.10815 8.88284 4.10803 8.88317 4.80899 9.14991C5.50996 9.41664 5.50985 9.41692 5.50975 9.41719C5.50973 9.41725 5.50964 9.41749 5.50959 9.4176C5.5095 9.41784 5.50945 9.41798 5.50942 9.41804C5.50938 9.41816 5.50947 9.41792 5.50969 9.41734C5.51014 9.41619 5.51113 9.41365 5.51267 9.40979C5.51574 9.40206 5.52099 9.38901 5.52846 9.37101C5.5434 9.335 5.56719 9.27924 5.60018 9.20664C5.66621 9.0613 5.76871 8.84925 5.91031 8.59341C6.19442 8.08008 6.63084 7.39971 7.23855 6.72958C8.44912 5.39466 10.3098 4.12566 13.0216 4.23922L13.0844 2.74053Z"
                            fill="currentColor"></path>
                            <path d="M8.78337 9.33604C8.72981 9.40713 8.65805 9.46292 8.57443 9.49703L3.1072 11.6951C2.95672 11.7552 2.78966 11.7352 2.66427 11.6407C2.53887 11.5462 2.47359 11.3912 2.48993 11.2299L3.09576 5.36863C3.11367 5.19823 3.22102 5.04666 3.37711 4.97402C3.5331 4.9005 3.71173 4.91728 3.84442 5.01726L8.70581 8.68052C8.8385 8.78051 8.90387 8.94759 8.8762 9.1178C8.86358 9.19825 8.83082 9.27308 8.78337 9.33604" fill="currentColor"></path>
                        </svg>
                    </span>&nbsp; &nbsp; 
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

 
function deleteRow(rowCount) {
 
    var row = document.querySelector('#muzakkiTable tbody tr:nth-child(' + (rowCount + 1) + ')');
    if (row) {
        row.remove();
    }
 
    calculateTotal();
}
 
document.addEventListener('DOMContentLoaded', function() {
     document.querySelector('#deleteRow0').addEventListener('click', function() {
        deleteRow(0); 
    });
});


    document.getElementById('getTotal').addEventListener('click', function() {
        calculateTotal()
    })
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
                newCell.innerHTML = '<span id="subtotal' + rowCount + '"></span> <span id="subtotaltext' + rowCount + '"> </span><br><input type="hidden" name="subtotal[]" id="subInt' + rowCount + '" class="form-control">';        
            
             }
            //  else if (i == 8) {
            //     newCell.innerHTML = '<span class="btn btn-danger btn-sm" id="deleteRow' + rowCount + '" onclick="deleteRow(' + rowCount + ')">Hapus</span>';            
            // } 
            else if (i == 1) {
                newCell.innerHTML = '{!! Form::select('user[]', $agt, "", ['class' => 'form-control']) !!}';
            }
         

           
        }
        newRow.querySelector('input[name^="jumlah[]"]').addEventListener('input', function() {
            
            caclculateSubtotal();
            
        });

        newRow.querySelector('input[name^="jumlah_jiwa[]"]').addEventListener('input', function() {
                
                caclculateSubtotal();
                
            });

            newRow.querySelector('select[name^="satuan[' + rowCount + ']"]').addEventListener('change', function() {
    
    calculateSubtotalForRow(rowCount);
});

newRow.querySelector('input[name^="type[' + rowCount + ']"]').addEventListener('change', function() {
    
    calculateSubtotalForRow(rowCount);
});
            
    });

    // Event listener untuk menghitung total ketika halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
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

    // Penundaan untuk memastikan input subInt tersedia di DOM
    
    // Update total jika diperlukan
    caclculateSubtotal();
    

}






    function caclculateSubtotal() {
      

    var rows = document.querySelectorAll('#muzakkiTable tbody tr');
    var total = 0;

    rows.forEach(function(row, index) {
        // var jumlahJiwa = parseFloat(row.querySelector('#jumlah_jiwa' + index).value);
        var jumlah = parseFloat(row.querySelector('#jumlah' + index).value.replace(',', '.')); // Replace koma dengan titik
        var satuanSelect = row.querySelector('#satuan' + index);
        var typeInput = row.querySelector('input[name^="type[' + index + ']"]:checked');
        var type = typeInput ? typeInput.value : '';
        setTimeout(function() {
        var subIntElem = document.querySelector('#subInt' + index);
        if (subIntElem) {
            subIntElem.value = subtotal.toLocaleString('id-ID');
            console.log('Nilai subInt diupdate:', subtotal.toLocaleString('id-ID'));
        } else {
            console.log('Input subInt tidak ditemukan setelah penundaan');
        }
    }, 100);  // Penundaan 100ms
     

        var jumlahJiwa=1
        if (isNaN(jumlah)) {
            jumlah = 0;
        }

        var subtotal = jumlahJiwa * jumlah;
        total += subtotal;

        row.querySelector('#subtotal' + index).textContent = subtotal.toLocaleString('id-ID');
        row.querySelector('#subtotaltext' + index).textContent = satuanSelect.value;
        ;
    });

}


var satuanElem0 = document.querySelector('#satuan0');

// Menambahkan event listener untuk elemen satuan0
satuanElem0.addEventListener('change', function() {
     
});


var jumlahElem0 = document.querySelector('#jumlah0');
jumlahElem0.addEventListener('input', function() {
     

});

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
            var jumlahInput = rows[i].querySelector('input[name="subtotal[]"]');
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
