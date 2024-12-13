<table style="border: 1px solid #ddd; width: 100%; border-collapse: collapse; text-align: left;">
    <thead style="background-color: #f8f9fa; border-bottom: 2px solid #ddd;">
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">No</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">TGL TRANSAKSI</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">DIBAYARKAN</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">KATEGORI</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">NAMA</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">TYPE</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">SATUAN</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">JML JIWA</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">SUBTOTAL</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $no = 1; 
            $totalKeseluruhanBayar = 0; 
            $totalKeseluruhanSubtotal = 0; 
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
                <tr>
                    @if($index === 0)
                        <td rowspan="{{ $details->count() }}" style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $no++ }}</td>
                        <td rowspan="{{ $details->count() }}" style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $header->created_at }}</td>
                        <td rowspan="{{ $details->count() }}" style="border: 1px solid #ddd; padding: 8px;">{{ $header->user->nama_lengkap }}</td>
                    @endif
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->kategori->nama_kategori }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->user->nama_lengkap }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->type }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->satuan }}</td>
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
        <tr>
            <td colspan="7" style="border: 1px solid #ddd; text-align: right; font-weight: bold; padding: 8px;">TOTAL KESELURUHAN:</td>
            <td  style="border: 1px solid #ddd; text-align: right; font-weight: bold; padding: 8px;">{{ $totalKeseluruhanBayar }}</td>
            <td  style="border: 1px solid #ddd; text-align: right; font-weight: bold; padding: 8px;">{{ $totalKeseluruhanSubtotal }}</td>
         </tr>
    </tbody>
</table>
