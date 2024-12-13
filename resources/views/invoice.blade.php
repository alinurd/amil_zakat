<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @page {
            size: 148mm 210mm;
            margin: 0;
            font-size: 9px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
           
        }

        .invoice {
           
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            background-image: url("{{asset('images/icons/watermak.png')}}");
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 5px;
        }

        .invoice-body {
            margin-bottom: 20px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .invoice-total {
            margin-top: 10px;
            text-align: left;
        }

        .invoice-footer {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="invoice-header">
            <img src="{{asset('images/icons/header.jpg')}}" style="width: 100%;" />
            <p><b><h3>#{{$header[0]['code']}}</h3></b></p>
            <p style="text-align: right;"> <i>Jakarta, {{date('d-m-Y', strtotime($header[0]['created_at']))}}</i></p> 
        </div>
        <div class="invoice-body">
             <span>Alhamdulillah, telah diterima penunaian zis/fidyah dari Bapak/ibu: <br><b><u>{{$header[0]['user']['nama_lengkap']}}</u></b></span>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                                 <th>Jumlah Jiwa</th>
                                 <th>Type</th>
                                 <th>Satuan</th>
                                 <th>Jumlah</th>
                                 <th>Subtotal</th>
                    </tr>
                </thead>
                <?php
$no = 0;
$totalLiter = 0;
$totalKg = 0;
$totalRupiah = 0;
?>

@foreach($detail as $item)
<tr>
                                 <td class="text-center">{{++$no}}</td>
                              
                                 <td style="text-align: left;">{{ $item['user']['nama_lengkap'] }}</td>
                               
                                 <td class="text-center">{{$item['kategori']['nama_kategori']}}</td>
                                 <td class="text-center">{{$item['jumlah_jiwa']}}</td>
                                 <td class="text-center">{{$item['type']}}</td>
                                 <td class="text-center">{{$item['satuan']}}</td>
                                 <td class="text-center">
                                    @if($item['satuan']=='Rupiah')
                                    {{ number_format($item['jumlah_bayar'], 2) }} 
                                    @else  
                                    {{$item['jumlah_bayar']}}
                                    @endif
                                </td>
                                 <td class="text-center">
                                    @if($item['satuan']=='Rupiah')
                                        {{ number_format($item['jumlah_bayar']*$item['jumlah_jiwa'], 2) }} 
                                        @else  
                                        {{$item['jumlah_bayar'] * $item['jumlah_jiwa']}} {{$item['satuan']}}
                                    @endif
                                </td>
                              </tr>
  
    @if($item['satuan'] === 'Liter')
        <?php $totalLiter += (float) str_replace(',', '.', $item['jumlah_bayar'] * $item['jumlah_jiwa']); ?>
    @elseif($item['satuan'] === 'Kg')
        <?php $totalKg += (float) str_replace(',', '.', $item['jumlah_bayar'] * $item['jumlah_jiwa']); ?>
    @elseif($item['satuan'] === 'Rupiah')
        <?php $totalRupiah += (float) str_replace(',', '.', $item['jumlah_bayar'] * $item['jumlah_jiwa']); ?>
    @endif
@endforeach

<tr>
     <th colspan="4" rowspan="4" style="text-align: right;">Total:</th>
 </tr>
<tr>
     <th style="text-align: right;">{{$totalLiter }}</th>
    <th>Liter</th>
</tr>
<tr>
     <th style="text-align: right;">{{$totalKg}}</th>
    <th>Kilogram</th>
</tr>
<tr>
     <th style="text-align: right;">{{ number_format($totalRupiah, 2) }}</th>
    <th>Rupiah</th>
</tr>



            </table>
        </div>
        <div class="invoice-footer">
            <i>Semoga Allah terima dan berikan sebaik-baik balasan.</i>
            <br>
            <span class="">
<span style="font-size: 7px;"><b style="color:red">*</b><i>Lembaran ini merupakan bukti sah serah terima zakat.</i></span>
                <p><b>Panitia ZIS Masjid Al Hasanah</b></p>
                <p>www.zis-alhasanah.com</p>
            </span>
        </div>
     </div>
</body>
<!-- 
<script>
   document.addEventListener('DOMContentLoaded', function() {
      var totalBeras = 0;
      var totalUang = 0;
      var totalKg = 0;

      @foreach($detail as $item)
    @if($item['satuan'] === 'Liter')
        totalBeras += parseFloat("{{ str_replace(',', '.', $item['jumlah_bayar']) }}");
    @elseif($item['satuan'] === 'Rupiah')
        totalUang += parseFloat("{{ str_replace(',', '.', $item['jumlah_bayar']) }}");
    @elseif($item['satuan'] === 'Kg')
        totalKg += parseFloat("{{ str_replace(',', '.', $item['jumlah_bayar']) }}");
    @endif
@endforeach


      document.getElementById('ttlLiter').textContent = totalBeras();
      document.getElementById('ttlRupiah').textContent = formatRupiah(totalUang);
      document.getElementById('ttlKg').textContent = totalKg();
   });

   function formatRupiah(angka) {
      var number_string = angka.toString().replace(/[^,\d]/g, ''),
         split = number_string.split(','),
         sisa = split[0].length % 3,
         rupiah = split[0].substr(0, sisa),
         ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

      if (ribuan) {
         separator = sisa ? '.' : '';
         rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return rupiah;
   }


    


</script>
 -->

</html>
