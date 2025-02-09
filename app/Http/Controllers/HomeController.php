<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Muzakki;
use App\Models\User;
use App\Models\Mustahik;
use App\Models\Rw;
use App\Models\MuzakkiHeader;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller 
{
    /* 
     * Dashboard Pages Routs
     */
    public function index(Request $request)
    {
        // Menghitung jumlah transaksi muzakki dan mustahik dari database
        $Transactionsmuzakki = Muzakki::count();
        $TransactionsmuzakkiH = MuzakkiHeader::count();
        $Transactionsmustahik = Mustahik::where('status', '2')->count();

        // Menghitung total transaksi muzakki (Uang dan Transfer) berdasarkan jumlah_bayar * jumlah_jiwa
        $totalTransactionsmuzakki = Muzakki::whereIn('type', ['Uang', 'Transfer'])
            ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
            ->value('total');

        // Menghitung total transaksi mustahik berdasarkan jumlah_uang_diterima
        $totalTransactionsmustahik = Mustahik::sum('jumlah_uang_diterima');

        // Menghitung total saldo uang
        $totalSaldoUang = $totalTransactionsmuzakki - $totalTransactionsmustahik;

        // Menghitung total beras yang masuk dari Muzakki (Kg)
        $totalBerasMuzakkiKg = Muzakki::where('type', 'Beras')
            ->where('satuan', 'Kg')
            ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
            ->value('total');

        // Menghitung total beras yang masuk dari Muzakki (Liter)
        $totalBerasMuzakkiL = Muzakki::where('type', 'Beras')
            ->where('satuan', 'Liter')
            ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
            ->value('total');

        // Menghitung total beras yang diterima oleh Mustahik (Kg)
        $totalBerasMustahikKg = Mustahik::where('satuan_beras', 'Kg')
            ->selectRaw('SUM(jumlah_beras_diterima) as total')
            ->value('total');

        // Menghitung total beras yang diterima oleh Mustahik (Liter)
        $totalBerasMustahikL = Mustahik::where('satuan_beras', 'Liter')
            ->selectRaw('SUM(jumlah_beras_diterima) as total')
            ->value('total');

        // Menghitung total saldo beras
        $totalSaldoBerasKg = $totalBerasMuzakkiKg - $totalBerasMustahikKg;
        $totalSaldoBerasL = $totalBerasMuzakkiL - $totalBerasMustahikL;

        // Mengambil data berdasarkan created_by dan mengelompokkan
        $userId = Auth::user()->id; 

        // Cek apakah ada filter tanggal dari request
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        // Buat query dasar untuk data Muzakki
        $queryMuzakki = Muzakki::where('created_by', $userId);

        // Tambahkan filter berdasarkan tanggal
        if ($tanggalMulai && $tanggalSelesai) {
            if ($tanggalMulai === $tanggalSelesai) {
                // Jika tanggal mulai dan akhir sama
                $queryMuzakki->whereDate('created_at', $tanggalMulai);
            } else {
                // Jika tanggal mulai dan akhir berbeda
                $queryMuzakki->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            }
        }

        // Menghitung jumlah transaksi muzakki berdasarkan created_by
        $TransactionsmuzakkiByUser = $queryMuzakki->count();

        // Hitung total pemasukan untuk setiap kategori dengan perkalian jumlah_bayar * jumlah_jiwa
        $totalPemasukanFitrahByUser = Muzakki::where('created_by', $userId)
        ->when($tanggalMulai && $tanggalSelesai, function ($query) use ($tanggalMulai, $tanggalSelesai) {
            return $query->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        })
        ->where('kategori_id', 1)
        ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
        ->value('total');

        $totalPemasukanMaalByUser = Muzakki::where('created_by', $userId)
        ->when($tanggalMulai && $tanggalSelesai, function ($query) use ($tanggalMulai, $tanggalSelesai) {
            return $query->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        })
        ->where('kategori_id', 2)
        ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
        ->value('total');

        $totalPemasukanFidyahByUser = Muzakki::where('created_by', $userId)
        ->when($tanggalMulai && $tanggalSelesai, function ($query) use ($tanggalMulai, $tanggalSelesai) {
            return $query->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        })
        ->where('kategori_id', 3)
        ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
        ->value('total');

        $totalPemasukanInfaqByUser = Muzakki::where('created_by', $userId)
        ->when($tanggalMulai && $tanggalSelesai, function ($query) use ($tanggalMulai, $tanggalSelesai) {
            return $query->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        })
        ->where('kategori_id', 4)
        ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
        ->value('total');

        // Menghitung total beras masuk untuk kategori Fitrah (dalam kilogram dan liter)
        $totalBerasMuzakkiKgFitrahByUser = $queryMuzakki->clone()
        ->where('kategori_id', 1)
        ->where('type', 'Beras')
        ->where('satuan', 'Kg')
        ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
        ->value('total');

        $totalBerasMuzakkiLFitrahByUser = $queryMuzakki->clone()  
        ->where('kategori_id', 1)
        ->where('type', 'Beras')
        ->where('satuan', 'Liter')
        ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
        ->value('total');

        // Menghitung total beras masuk untuk kategori Fidyah (dalam kilogram dan liter)
        $totalBerasMuzakkiKgFidyahByUser = $queryMuzakki->clone()
        ->where('kategori_id', 3)
        ->where('type', 'Beras')
        ->where('satuan', 'Kg')
        ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
        ->value('total');

        $totalBerasMuzakkiLFidyahByUser = $queryMuzakki->clone()
        ->where('kategori_id', 3)
        ->where('type', 'Beras')
        ->where('satuan', 'Liter')
        ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
        ->value('total');
        $credite=$this->getCredite();
          $assets = ['chart', 'animation'];
        return view('dashboards.dashboard', compact('assets', 'Transactionsmuzakki', 'Transactionsmustahik', 'totalSaldoUang', 
        'totalSaldoBerasKg','totalSaldoBerasL', 'TransactionsmuzakkiH','totalPemasukanFitrahByUser','totalPemasukanMaalByUser',
        'totalPemasukanFidyahByUser','totalPemasukanInfaqByUser','totalBerasMuzakkiKgFitrahByUser','totalBerasMuzakkiLFitrahByUser',
        'totalBerasMuzakkiKgFidyahByUser','totalBerasMuzakkiLFidyahByUser', 'credite'));
    } 

    /* 
     * Menu Style Routs
     */
    public function horizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.horizontal',compact('assets'));
    }
    public function dualhorizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-horizontal',compact('assets'));
    }
    public function dualcompact(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-compact',compact('assets'));
    }
    public function boxed(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed',compact('assets'));
    }
    public function boxedfancy(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed-fancy',compact('assets'));
    }

    /*
     * Pages Routs
     */
    public function billing(Request $request)
    {
        return view('special-pages.billing');
    }

    public function calender(Request $request)
    {
        $assets = ['calender'];
        return view('special-pages.calender',compact('assets'));
    }

    public function kanban(Request $request)
    {
        return view('special-pages.kanban');
    }

    public function pricing(Request $request)
    {
        return view('special-pages.pricing');
    }

    public function rtlsupport(Request $request)
    {
        return view('special-pages.rtl-support');
    }

    public function timeline(Request $request)
    {
        return view('special-pages.timeline');
    }


    /*
     * Widget Routs
     */
    public function widgetbasic(Request $request)
    {
        return view('widget.widget-basic');
    }
    public function widgetchart(Request $request)
    {
        $assets = ['chart'];
        return view('widget.widget-chart', compact('assets'));
    }
    public function widgetcard(Request $request)
    {
        return view('widget.widget-card');
    }

    /*
     * Maps Routs
     */
    public function google(Request $request)
    {
        return view('maps.google');
    }
    public function vector(Request $request)
    {
        return view('maps.vector');
    }

    /*
     * Auth Routs
     */
    public function signin(Request $request)
    {
        return view('auth.login');
    }
    public function signup(Request $request)
    {
        return view('auth.register');
    }
    public function confirmmail(Request $request)
    {
        return view('auth.confirm-mail');
    }
    public function lockscreen(Request $request)
    {
        return view('auth.lockscreen');
    }
    public function recoverpw(Request $request)
    {
        return view('auth.recoverpw');
    }
    public function userprivacysetting(Request $request)
    {
        return view('auth.user-privacy-setting');
    }

    /*
     * Error Page Routs
     */

    public function error404(Request $request)
    {
        return view('errors.error404');
    }

    public function error500(Request $request)
    {
        return view('errors.error500');
    }
    public function maintenance(Request $request)
    {
        return view('errors.maintenance');
    }

    /*
     * uisheet Page Routs
     */
    public function uisheet(Request $request)
    {
        return view('uisheet');
    }

    /*
     * Form Page Routs
     */
    public function element(Request $request)
    {
        return view('forms.element');
    }

    public function wizard(Request $request)
    {
        return view('forms.wizard');
    }

    public function validation(Request $request)
    {
        return view('forms.validation');
    }

     /*
     * Table Page Routs
     */
    public function bootstraptable(Request $request)
    {
        return view('table.bootstraptable');
    }

    public function datatable(Request $request)
    {
        return view('table.datatable');
    }

    /*
     * Icons Page Routs
     */

    public function solid(Request $request)
    {
        return view('icons.solid');
    }

    public function outline(Request $request)
    {
        return view('icons.outline');
    }

    public function dualtone(Request $request)
    {
        return view('icons.dualtone');
    }

    public function colored(Request $request)
    {
        return view('icons.colored');
    }

    /*
     * Extra Page Routs
     */
    public function privacypolicy(Request $request)
    {
        return view('privacy-policy');
    }
    public function termsofuse(Request $request)
    {
        return view('terms-of-use');
    }

    /*
    * Landing Page Routs
    */
    public function landing_index(Request $request) 
    {
        // Ambil tahun dari request, jika tidak ada gunakan tahun saat ini
        $year = $request->input('year', date('Y'));

        // Menghitung jumlah transaksi muzakki dan mustahik dari database berdasarkan tahun
        $Transactionsmuzakki = Muzakki::whereYear('created_at', $year)->count();
        $Transactionsmustahik = Mustahik::whereYear('created_at', $year)->where('status', '2')->count();

        // Hitung total pemasukan untuk setiap kategori berdasarkan tahun 
        $totalPemasukanFitrah = Muzakki::where('kategori_id', 1)
            ->whereYear('created_at', $year)
            ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
            ->value('total');

        $totalPengeluaranFitrah = Mustahik::where('kategori_id', 1)
            ->whereYear('created_at', $year)
            ->sum('jumlah_uang_diterima');
        $sisaPemasukanFitrah = $totalPemasukanFitrah - $totalPengeluaranFitrah;

        $totalPemasukanMaal = Muzakki::where('kategori_id', 2)
            ->whereYear('created_at', $year)
            ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
            ->value('total');

        $totalPengeluaranMaal = Mustahik::where('kategori_id', 2)
            ->whereYear('created_at', $year)
            ->sum('jumlah_uang_diterima');
        $sisaPemasukanMaal = $totalPemasukanMaal - $totalPengeluaranMaal;

        $totalPemasukanFidyah = Muzakki::where('kategori_id', 3)
            ->whereYear('created_at', $year)
            ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
            ->value('total');

        $totalPengeluaranFidyah = Mustahik::where('kategori_id', 3)
            ->whereYear('created_at', $year)
            ->sum('jumlah_uang_diterima');
        $sisaPemasukanFidyah = $totalPemasukanFidyah - $totalPengeluaranFidyah;

        $totalPemasukanInfaq = Muzakki::where('kategori_id', 4)
            ->whereYear('created_at', $year)
            ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
            ->value('total');

        $totalPengeluaranInfaq = Mustahik::where('kategori_id', 4)
            ->whereYear('created_at', $year)
            ->sum('jumlah_uang_diterima');
        $sisaPemasukanInfaq = $totalPemasukanInfaq - $totalPengeluaranInfaq;

        // Menghitung total beras masuk (Kg) untuk kategori tertentu
        $totalBerasMuzakkiKgFitrah = Muzakki::where('type', 'Beras')
            ->where('satuan', 'Kg')
            ->where('kategori_id', 1)
            ->whereYear('created_at', $year)
            ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
            ->value('total');

        $totalBerasMuzakkiKgFidyah = Muzakki::where('type', 'Beras')
            ->where('satuan', 'Kg')
            ->where('kategori_id', 3)
            ->whereYear('created_at', $year)
            ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
            ->value('total');

        // Menghitung total beras masuk (Liter) untuk kategori tertentu
        $totalBerasMuzakkiLFitrah = Muzakki::where('type', 'Beras')
            ->where('satuan', 'Liter')
            ->where('kategori_id', 1)
            ->whereYear('created_at', $year)
            ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
            ->value('total');

        $totalBerasMuzakkiLFidyah = Muzakki::where('type', 'Beras')
            ->where('satuan', 'Liter')
            ->where('kategori_id', 3)
            ->whereYear('created_at', $year)
            ->selectRaw('SUM(jumlah_bayar * jumlah_jiwa) as total')
            ->value('total');

        // Menghitung total beras diterima oleh Mustahik (Kg)
        $totalBerasMustahikKgFitrah = Mustahik::where('satuan_beras', 'Kg')
            ->where('kategori_id', 1)
            ->whereYear('created_at', $year)
            ->sum('jumlah_beras_diterima');

        $totalBerasMustahikKgFidyah = Mustahik::where('satuan_beras', 'Kg')
            ->where('kategori_id', 3)
            ->whereYear('created_at', $year)
            ->sum('jumlah_beras_diterima');

        // Menghitung total beras diterima oleh Mustahik (Liter)
        $totalBerasMustahikLFitrah = Mustahik::where('satuan_beras', 'Liter')
            ->where('kategori_id', 1)
            ->whereYear('created_at', $year)
            ->sum('jumlah_beras_diterima');

        $totalBerasMustahikLFidyah = Mustahik::where('satuan_beras', 'Liter')
            ->where('kategori_id', 3)
            ->whereYear('created_at', $year)
            ->sum('jumlah_beras_diterima');

        // Menghitung total saldo beras untuk kategori Fitrah
        $totalSaldoBerasKgFitrah = $totalBerasMuzakkiKgFitrah - $totalBerasMustahikKgFitrah;
        $totalSaldoBerasLFitrah = $totalBerasMuzakkiLFitrah - $totalBerasMustahikLFitrah;
 
        // Menghitung total saldo beras untuk kategori Fidyah
        $totalSaldoBerasKgFidyah = $totalBerasMuzakkiKgFidyah - $totalBerasMustahikKgFidyah;
        $totalSaldoBerasLFidyah = $totalBerasMuzakkiLFidyah - $totalBerasMustahikLFidyah;
 
        // Menghitung jumlah mustahiq untuk setiap RT
        $allRt = Rw::pluck('rt')->toArray();
        $rtData = [];

        foreach ($allRt as $rt) {
            $jumlahMustahiq = Mustahik::whereHas('rw', function ($query) use ($rt) {
                $query->where('rt', $rt);
            })->where('status', '2')->whereYear('created_at', $year)->count();

            $rtData[] = $jumlahMustahiq;
        } 

        $rtLabels = $allRt;
        $jumlahMustahiqWilayahLain = Mustahik::whereNull('rw_id')->where('status', '2')  
        ->whereYear('created_at', $year)
        ->count();
        $rtData[] = $jumlahMustahiqWilayahLain;
        $rtLabels[] = 'Wilayah Lain'; 

        $assets = ['chart', 'animation'];

        return view('landing-pages.pages.index', compact('rtLabels', 'rtData', 'assets', 'Transactionsmuzakki', 'Transactionsmustahik', 'totalPemasukanFitrah', 'totalBerasMuzakkiLFitrah', 'totalBerasMuzakkiKgFitrah', 'totalPemasukanFidyah', 'totalBerasMuzakkiLFidyah', 'totalBerasMuzakkiKgFidyah', 'totalPemasukanMaal', 'totalPemasukanInfaq', 'totalPengeluaranFitrah', 'totalBerasMustahikLFitrah', 'totalBerasMustahikKgFitrah', 'totalPengeluaranMaal', 'totalPengeluaranInfaq', 'totalPengeluaranFidyah', 'totalBerasMustahikLFidyah', 'totalBerasMustahikKgFidyah', 'sisaPemasukanFitrah', 'sisaPemasukanMaal', 'sisaPemasukanInfaq', 'sisaPemasukanFidyah', 'totalSaldoBerasKgFitrah', 'totalSaldoBerasLFitrah', 'totalSaldoBerasKgFidyah', 'totalSaldoBerasLFidyah'));
    } 
    
    public function landing_blog(Request $request)
    {
        return view('landing-pages.pages.blog');
    }
    public function landing_about(Request $request)
    {
        return view('landing-pages.pages.about');
    }
    public function landing_blog_detail(Request $request)
    {
        return view('landing-pages.pages.blog-detail');
    }
    public function landing_contact(Request $request)
    {
        return view('landing-pages.pages.contact-us');
    }
    public function landing_ecommerce(Request $request)
    {
        return view('landing-pages.pages.ecommerce-landing-page');
    }
    public function landing_faq(Request $request)
    {
        return view('landing-pages.pages.faq');
    }
    public function landing_feature(Request $request)
    {
        return view('landing-pages.pages.feature');
    }
    public function landing_pricing(Request $request)
    {
        return view('landing-pages.pages.pricing');
    }
    public function landing_saas(Request $request)
    {
        return view('landing-pages.pages.saas-marketing-landing-page');
    }
    public function landing_shop(Request $request)
    {
        return view('landing-pages.pages.shop');
    }
    public function landing_shop_detail(Request $request)
    {
        return view('landing-pages.pages.shop_detail');
    }
    public function landing_software(Request $request)
    {
        return view('landing-pages.pages.software-landing-page');
    }
    public function landing_startup(Request $request)
    {
        return view('landing-pages.pages.startup-landing-page');
    }
}
