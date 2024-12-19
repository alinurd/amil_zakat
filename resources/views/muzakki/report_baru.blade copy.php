<table style="border: 1px solid #ddd; width: 100%; border-collapse: collapse; text-align: left;">
   <thead style="background-color: #f8f9fa; border-bottom: 2px solid #ddd;">
      <tr>
         <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">No</th>
         <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">TGL TRANSAKSI</th>
         <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">DIBAYARKAN</th>
         <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">KATEGORI</th>
         <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">NAMA</th>
         <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">SATUAN</th>
         <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">JUMLAH</th>
         <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">JML JIWA</th>
         <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">SUBTOTAL <br> (jml*jiwa)</th>
      </tr>
   </thead>
   <tbody>
      <?php
      $no = 1;
      $totalKeseluruhanBayar = 0;
      $totalKeseluruhanSubtotal = 0;

      $totalKeseluruhanKG = 0;
      $totalKeseluruhanKGJiwa = 0;
      $totalKeseluruhanLITER = 0;
      $totalKeseluruhanLITERJiwa = 0;
      $totalKeseluruhanRUPIAH = 0;
      $totalKeseluruhanRUPIAHJiwa = 0;

      ?>
      @foreach($data['header'] as $header)
      
@php
    // Filter data detail berdasarkan code
    $details = $data['detail']->filter(fn($detail) => $detail->code == $header->code);

    // Menghitung totalJumlahBayar dengan mengganti null atau string kosong menjadi 0
    $totalJumlahBayar = $details->sum(fn($detail) => 
        floatval(empty($detail->jumlah_jiwa) ? 0 : $detail->jumlah_jiwa)
    );

    // Menghitung totalSubtotal dengan memastikan tidak ada nilai null atau kosong
    $totalSubtotal = $details->sum(fn($detail) => 
        floatval(empty($detail->jumlah_bayar) ? 0 : $detail->jumlah_bayar) * 
        floatval(empty($detail->jumlah_jiwa) ? 0 : $detail->jumlah_jiwa)
    );

    // Menambahkan totalJumlahBayar ke totalKeseluruhanBayar
    $totalKeseluruhanBayar += $totalJumlahBayar;

    // Menambahkan totalSubtotal ke totalKeseluruhanSubtotal
    $totalKeseluruhanSubtotal += $totalSubtotal;
@endphp

      @foreach($details as $index => $detail)
     @php
    // Pastikan nilai jumlah_bayar dan jumlah_jiwa tidak null atau kosong
    $jumlahBayar = floatval(empty($detail->jumlah_bayar) ? 0 : $detail->jumlah_bayar);
    $jumlahJiwa = floatval(empty($detail->jumlah_jiwa) ? 0 : $detail->jumlah_jiwa);

    if ($detail->satuan == 'Kg') {
        $totalKeseluruhanKG += $jumlahBayar * $jumlahJiwa;
        $totalKeseluruhanKGJiwa += $jumlahJiwa;
    } elseif ($detail->satuan == 'Liter') {
        $totalKeseluruhanLITER += $jumlahBayar * $jumlahJiwa;
        $totalKeseluruhanLITERJiwa += $jumlahJiwa;
    } elseif ($detail->satuan == 'Rupiah') {
        $totalKeseluruhanRUPIAH += $jumlahBayar * $jumlahJiwa;
        $totalKeseluruhanRUPIAHJiwa += $jumlahJiwa;
    }
@endphp

      <tr>
         @if($index === 0)
         <td rowspan="{{ $details->count() }}" style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $no++ }}</td>
         <td rowspan="{{ $details->count() }}" style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $header->created_at }}</td>
         <td rowspan="{{ $details->count() }}" style="border: 1px solid #ddd; padding: 8px;">{{ $header->user->nama_lengkap }}</td>
         @endif
         <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->kategori->nama_kategori }}</td>
         <td style="border: 1px solid #ddd; padding: 8px;">{{$detail->name}}</td>
         <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->satuan }}</td>
         <td style="border: 1px solid #ddd; padding: 8px;">{{ $jumlahBayar }}</td>
         <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $jumlahJiwa }}</td>
         <td style="border: 1px solid #ddd; padding: 8px;">{{ $jumlahBayar * $jumlahJiwa }}</td>
      </tr>
      @endforeach
      <tr>
         <td colspan="5" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px;">{{ $header->code }}</td>
         <td colspan="2" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px;">TOTAL:</td>
         <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $totalJumlahBayar }}</td>
         <td style="border: 1px solid #ddd; padding: 8px;">{{ $totalSubtotal }}</td>
      </tr>
      @endforeach

      <!--SATUAN KG -->
      <tr>
         <td colspan="5" rowspan="3" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px;"></td>
         <td colspan="2" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px;">KG</td>
         <td style="border: 1px solid #ddd; text-align: right; font-weight: bold; padding: 8px;">{{ $totalKeseluruhanKGJiwa }}</td>
         <td style="border: 1px solid #ddd; text-align: right; font-weight: bold; padding: 8px;">{{ $totalKeseluruhanKG }}</td>
      </tr>

      <!--SATUAN LITER -->
      <tr>
         <td colspan="2" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px;">LITER</td>
         <td style="border: 1px solid #ddd; text-align: right; font-weight: bold; padding: 8px;">{{ $totalKeseluruhanLITERJiwa }}</td>
         <td style="border: 1px solid #ddd; text-align: right; font-weight: bold; padding: 8px;">{{ $totalKeseluruhanLITER }}</td>
      </tr>
      <!--SATUAN RUPIAH -->
      <tr>
         <td colspan="2" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px;">RUPIAH</td>
         <td style="border: 1px solid #ddd; text-align: right; font-weight: bold; padding: 8px;">{{ $totalKeseluruhanRUPIAHJiwa }}</td>
         <td style="border: 1px solid #ddd; text-align: right; font-weight: bold; padding: 8px;">{{ $totalKeseluruhanRUPIAH }}</td>
      </tr>
      <tr>
         <td colspan="7" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px; background-color: #494949; color:#fff ">TOTAL KESELURUHAN</td>
         <td style="border: 1px solid #ddd; text-align: right; font-weight: bold; padding: 8px;  background-color: #494949; color:#fff">{{ $totalKeseluruhanBayar }}</td>
         <td style="border: 1px solid #ddd; text-align: right; font-weight: bold; padding: 8px;  background-color: #494949; color:#fff">{{ $totalKeseluruhanSubtotal }}</td>
      </tr>
   </tbody>
</table>