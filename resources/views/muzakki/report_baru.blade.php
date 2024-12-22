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
      // Inisialisasi variabel untuk total per satuan
      $totalsByCode = [];

      foreach ($data['header'] as $header) {
         foreach ($header->details as $index => $detail) {
            $jumlahBayar = floatval(empty($detail->jumlah_bayar) ? 0 : $detail->jumlah_bayar);
            $jumlahJiwa = floatval(empty($detail->jumlah_jiwa) ? 0 : $detail->jumlah_jiwa);
            $subtotal = $jumlahBayar * $jumlahJiwa;
            $totalKeseluruhanSubtotal += $subtotal;

            // Mengelompokkan total berdasarkan code dan satuan
            $code = $header->code;
            $satuan = $detail->satuan;

            if (!isset($totalsByCode[$code])) {
               $totalsByCode[$code] = [
                  'KG' => 0,
                  'KGJIWA' => 0,
                  'Liter' => 0,
                  'LiterJIWA' => 0,
                  'Rupiah' => 0,
                  'RupiahJIWA' => 0
               ];
            }

            if ($satuan == 'Kg') {
               $totalKeseluruhanKG += $subtotal;
               $totalKeseluruhanKGJiwa += $jumlahJiwa;
               $totalsByCode[$code]['KG'] += $subtotal;
               $totalsByCode[$code]['KGJIWA'] += $jumlahJiwa;
            } elseif ($satuan == 'Liter') {
               $totalKeseluruhanLITER += $subtotal;
               $totalKeseluruhanLITERJiwa += $jumlahJiwa;
               $totalsByCode[$code]['Liter'] += $subtotal;
               $totalsByCode[$code]['LiterJIWA'] += $jumlahJiwa;
            } elseif ($satuan == 'Rupiah') {
               $totalKeseluruhanRUPIAH += $subtotal;
               $totalKeseluruhanRUPIAHJiwa += $jumlahJiwa;
               $totalsByCode[$code]['Rupiah'] += $subtotal;
               $totalsByCode[$code]['RupiahJIWA'] += $jumlahJiwa;
            }


      ?>
            <tr>
               @if($index == 0)
               <td rowspan="{{ count($header->details) }}" style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$no++}}</td>
               <td rowspan="{{ count($header->details) }}" style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $header->created_at }}</td>
               <td rowspan="{{ count($header->details) }}" style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $header->user->nama_lengkap }}</td>
               @endif
               <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $detail->kategori->nama_kategori }}</td>
               <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$detail->user->nama_lengkap}}</td>
               <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $detail->satuan }}</td>
               <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $jumlahBayar }}</td>
               <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $jumlahJiwa }}</td>
               <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                  @if($detail->satuan == 'Rupiah')
                  {{ number_format($subtotal, 2, ',', '.') }}
                  @else
                  {{ $subtotal }}
                  @endif

               </td>
            </tr>
            <?php
         }

         foreach ($totalsByCode as $code => $totals) {
            if ($header->code == $code) {
            ?>
               <tr>
                  <td colspan="5" rowspan="3" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px;">{{ $code }}</td>
                  <td colspan="2" style="background-color:rgb(230, 227, 227); border: 1px solid #ddd; padding: 8px; text-align: center;">KG:</td>
                  <td style="background-color:rgb(230, 227, 227); border: 1px solid #ddd; padding: 8px; text-align: center;">{{$totals['KGJIWA']}}</td>
                  <td style="background-color:rgb(230, 227, 227);  border: 1px solid #ddd; padding: 8px; text-align: center;">{{$totals['KG']}}</td>
               </tr>
               <tr>
                  <td colspan="2" style="background-color:rgb(214, 213, 213); border: 1px solid #ddd; padding: 8px; text-align: center;">Liter:</td>
                  <td style="background-color:rgb(214, 213, 213); border: 1px solid #ddd; padding: 8px; text-align: center;">{{$totals['LiterJIWA']}}</td>
                  <td style="background-color:rgb(214, 213, 213); border: 1px solid #ddd; padding: 8px; text-align: center;">{{$totals['Liter']}}</td>
               </tr>
               <tr>
                  <td colspan="2" style="background-color:rgb(199, 197, 197); border: 1px solid #ddd; padding: 8px; text-align: center;">Rupiah:</td>
                  <td style="background-color:rgb(199, 197, 197); border: 1px solid #ddd; padding: 8px; text-align: center;">{{$totals['RupiahJIWA']}}</td>
                  <td style="background-color:rgb(199, 197, 197); border: 1px solid #ddd; padding: 8px; text-align: center;">{{ number_format($totals['Rupiah'], 2, ',', '.') }}</td>
               </tr>
               <tr style=" height: 10px;">
                  <td colspan="9"></td>
               </tr>
      <?php
            }
         }
      }
      ?>


      <!--SATUAN KG -->
      <tr>
         <td colspan="5" rowspan="3" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px; background-color: #494949; color:#fff ">TOTAL KESELURUHAN</td>
         <td colspan="2" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px; background-color: #494949; color:#fff ">KG</td>
         <td style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px; background-color: #494949; color:#fff ">{{ $totalKeseluruhanKGJiwa }}</td>
         <td style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px; background-color: #494949; color:#fff ">{{ $totalKeseluruhanKG }}</td>
      </tr>

      <!--SATUAN LITER -->
      <tr>
         <td colspan="2" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px; background-color: #494949; color:#fff ">LITER</td>
         <td style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px; background-color: #494949; color:#fff ">{{ $totalKeseluruhanLITERJiwa }}</td>
         <td style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px; background-color: #494949; color:#fff ">{{ $totalKeseluruhanLITER }}</td>
      </tr>
      <!--SATUAN RUPIAH -->
      <tr>
         <td colspan="2" style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px; background-color: #494949; color:#fff ">RUPIAH</td>
         <td style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px; background-color: #494949; color:#fff ">{{ $totalKeseluruhanRUPIAHJiwa }}</td>
         <td style="border: 1px solid #ddd; text-align: center; font-weight: bold; padding: 8px; background-color: #494949; color:#fff ">{{ number_format($totalKeseluruhanRUPIAH, 2, ',', '.')  }}</td>
      </tr>

   </tbody>
</table>