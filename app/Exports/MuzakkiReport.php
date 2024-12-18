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

    public function index()
    {
        $data['detail'] = Muzakki::with('user', 'kategori')->get();
        $data['header'] = MuzakkiHeader::with('user')->get();

        return view('muzakki.report', compact('data'));
    }
    public function exportMuzakkiReport()
{
    $thn=date('Y');
    header("Content-type:appalication/vnd.ms-excel");
    header("content-disposition:attachment;filename=Muzzaki-Report-".$thn.".xls");
    
    $data['detail'] = Muzakki::with('user', 'kategori')->get();
    $data['header'] = MuzakkiHeader::with('user', 'details')->get();

    return view('muzakki.report_baru', compact('data'));
 }

}
