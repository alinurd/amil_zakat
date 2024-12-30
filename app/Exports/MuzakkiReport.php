<?php

namespace App\Exports;

use App\Models\Muzakki;
use App\Models\MuzakkiHeader;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings; 
class MuzakkiReport implements FromCollection, WithHeadings, ShouldAutoSize{
    /*
    * @return \Illuminate\Support\Collection
    */ 
    public function collection()
    {
        $detail = Muzakki::with('user', 'kategori')->get();
        $header = MuzakkiHeader::with('user')->get();

        $dataRupiah = [];
        $dataLiter = [];
        $dataKg = [];

        $totalsRupiah = 0;
        $totalsLiter = 0;
        $totalsKg = 0;

        $no = 1;
        foreach ($detail as $item) {
            foreach ($header as $h) {
                if ($item->code == $h->code) {
                    $jumlah_bayar = str_replace(',', '.', $item->jumlah_bayar);
                    $jumlah_bayar = floatval($jumlah_bayar);

                    if (is_numeric($jumlah_bayar)) {
                        $satuan = $item->satuan;

                        switch ($satuan) {
                            case 'Rupiah':
                                $totalsRupiah += $jumlah_bayar;
                                $dataRupiah[] = [
                                    'No' => $no++,
                                    'Code Invoice' => $item->code,
                                    'Tanggal' => $h->created_at,
                                    'Dibayarkan Oleh' => $h->user->nama_lengkap,
                                    'Nama' => $item->user->nama_lengkap,
                                    'Kategori' => $item->kategori->nama_kategori,
                                    'Type' => $item->type,
                                    'Satuan' => $satuan,
                                    'Jumlah' => $jumlah_bayar,
                                ];
                                break;
                            case 'Liter':
                                $totalsLiter += $jumlah_bayar;
                                $dataLiter[] = [
                                    'No' => $no++,
                                    'Code Invoice' => $item->code,
                                    'Tanggal' => $h->created_at,
                                    'Dibayarkan Oleh' => $h->user->nama_lengkap,
                                    'Nama' => $item->user->nama_lengkap,
                                    'Kategori' => $item->kategori->nama_kategori,
                                    'Type' => $item->type,
                                    'Satuan' => $satuan,
                                    'Jumlah' => $jumlah_bayar,
                                ];
                                break;
                            case 'Kg':
                                $totalsKg += $jumlah_bayar;
                                $dataKg[] = [
                                    'No' => $no++,
                                    'Code Invoice' => $item->code,
                                    'Tanggal' => $h->created_at,
                                    'Dibayarkan Oleh' => $h->user->nama_lengkap,
                                    'Nama' => $item->user->nama_lengkap,
                                    'Kategori' => $item->kategori->nama_kategori,
                                    'Type' => $item->type,
                                    'Satuan' => $satuan,
                                    'Jumlah' => $jumlah_bayar,
                                ];
                                break;
                        }
                    } else {
                        // Lakukan penanganan jika $jumlah_bayar bukan numerik 
                        // Contoh: set nilai $jumlah_bayar ke 0 atau lakukan tindakan lain
                        $jumlah_bayar = 0;
                    }
                }
            }
        }

        // Tambahkan total berdasarkan satuan ke data
        $dataRupiah[] = [
            'No' => '',
            'Code Invoice' => '',
            'Tanggal' => '',
            'Dibayarkan Oleh' => '',
            'Nama' => '',
            'Kategori' => '',
            'Type' => 'Total',
            'Satuan' => 'Rupiah',
            'Jumlah' => $totalsRupiah,
        ];
        
        $dataLiter[] = [
            'No' => '',
            'Code Invoice' => '',
            'Tanggal' => '',
            'Dibayarkan Oleh' => '',
            'Nama' => '',
            'Kategori' => '',
            'Type' => 'Total',
            'Satuan' => 'Liter',
            'Jumlah' => $totalsLiter,
      ];
        
        $dataKg[] = [
            'No' => '',
            'Code Invoice' => '',
            'Tanggal' => '',
            'Dibayarkan Oleh' => '',
            'Nama' => '',
            'Kategori' => '',
            'Type' => 'Total',
            'Satuan' => 'Kg',
            'Jumlah' => $totalsKg,
      ];
        

        return collect(array_merge($dataRupiah, $dataLiter, $dataKg));
    }

    public function headings(): array
    {
        return [
            'No',
            'Code Invoice',
            'Tanggal',
            'Dibayarkan Oleh',
            'Nama',
            'Kategori',
            'Type',
            'Satuan',
            'Jumlah',
        ];
    }

    public function muzakkireport()
    {
        return Excel::download(new MuzakkiReport, "Muzakki-Report-" . date("Y") . ".xlsx");
    }

    public function index(Request $request)
    {
        $queryDetail = Muzakki::with('user', 'kategori');
        $queryHeader = MuzakkiHeader::with('user');

        // Filter berdasarkan tanggal jika dipilih
        if ($request->has('tanggal') && $request->tanggal) {
            $tanggal = $request->input('tanggal');
            $queryDetail->whereDate('created_at', $tanggal);
            $queryHeader->whereDate('created_at', $tanggal); // Pastikan ini sesuai dengan kolom yang relevan
        }

        $data['detail'] = $queryDetail->get();
        $data['header'] = $queryHeader->get();

        return view('muzakki.report', compact('data'));
    }

    public function exportMuzakkiReport(Request $request) 
    {
        $tanggal = $request->input('tanggal'); // Tangkap parameter tanggal
        $thn = date('Y');
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Muzzaki-Report-{$thn}.xls");

        // Filter data berdasarkan tanggal jika parameter 'tanggal' ada
        $queryDetail = Muzakki::with('user', 'kategori');
        $queryHeader = MuzakkiHeader::with('user', 'details');

        if ($tanggal) {
            $queryDetail->whereDate('created_at', $tanggal);
            $queryHeader->whereDate('created_at', $tanggal);
        }

        $data['detail'] = $queryDetail->get();
        $data['header'] = $queryHeader->get();

        // Gunakan view untuk menghasilkan file Excel
        return view('muzakki.report_baru', compact('data'));
    } 

}
