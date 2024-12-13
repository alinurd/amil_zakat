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
         <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">SUBTOTAL</th>
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
      $details = $data['detail']->filter(fn($detail) => $detail->code == $header->code);
      $totalJumlahBayar = $details->sum('jumlah_bayar');
      $totalSubtotal = $details->sum(fn($detail) => $detail->jumlah_bayar * $detail->jumlah_jiwa);

      $totalKeseluruhanBayar += $totalJumlahBayar;
      $totalKeseluruhanSubtotal += $totalSubtotal;
      @endphp

      @foreach($details as $index => $detail)
      @php
      if($detail->satuan == 'Kg') {
      $totalKeseluruhanKG += $detail->jumlah_bayar * $detail->jumlah_jiwa;
      $totalKeseluruhanKGJiwa += $detail->jumlah_jiwa;
      } elseif($detail->satuan == 'Liter') {
      $totalKeseluruhanLITER += $detail->jumlah_bayar * $detail->jumlah_jiwa;
      $totalKeseluruhanLITERJiwa += $detail->jumlah_jiwa;
      } elseif($detail->satuan == 'Rupiah') {
      $totalKeseluruhanRUPIAH += $detail->jumlah_bayar * $detail->jumlah_jiwa;
      $totalKeseluruhanRUPIAHJiwa += $detail->jumlah_jiwa;
      }
      @endphp
      <tr>
         @if($index === 0)
         <td rowspan="{{ $details->count() }}" style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $no++ }}</td>
         <td rowspan="{{ $details->count() }}" style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $header->created_at }}</td>
         <td rowspan="{{ $details->count() }}" style="border: 1px solid #ddd; padding: 8px;">{{ $header->user->nama_lengkap }}</td>
         @endif
         <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->kategori->nama_kategori }}</td>
         <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->user->nama_lengkap }}</td>
         <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->satuan }}</td>
         <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->jumlah_bayar }}</td>
         <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $detail->jumlah_jiwa }}</td>
         <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->jumlah_bayar * $detail->jumlah_jiwa }}</td>
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