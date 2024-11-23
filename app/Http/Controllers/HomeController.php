<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Muzakki;
use App\Models\Mustahik;
use App\Models\Rw;
use App\Models\MuzakkiHeader;

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

        // Menghitung jumlah transaksi muzakki dan mustahik dari database
        $totalTransactionsmuzakki = Muzakki::where('type', 'Uang')->orWhere('type', 'Transfer')->sum('jumlah_bayar');
        $totalTransactionsmustahik = Mustahik::sum('jumlah_uang_diterima');
 
        // Menghitung total saldo uang
        $totalSaldoUang = $totalTransactionsmuzakki - $totalTransactionsmustahik;
        
        // Menghitung total beras yang masuk dari model Muzakki
        $getMuzakkiKg = Muzakki::where('type', 'Beras')->where('satuan', 'Kg')->get();
        $totalBerasMuzakkiKg = 0;
        foreach ($getMuzakkiKg as $q) {
            $totalBerasMuzakkiKg += (float) str_replace(',', '.', $q->jumlah_bayar);
        }

        $getMuzakkiLiter = Muzakki::where('type', 'Beras')->where('satuan', 'Liter')->get();
        $totalBerasMuzakkiL = 0;
        foreach ($getMuzakkiLiter as $q) {
            $totalBerasMuzakkiL += (float) str_replace(',', '.', $q->jumlah_bayar);
        }

        $getMustahikKg = Mustahik::where('satuan_beras', 'Kg')->get();
        $totalBerasMustahikKg = 0;
        foreach ($getMustahikKg as $q) {
            $totalBerasMustahikKg += (float) str_replace(',', '.', $q->jumlah_beras_diterima);
        } 
        $getMustahiL = Mustahik::where('satuan_beras', 'Liter')->get();
        $totalBerasMustahikL = 0;
        foreach ($getMustahiL as $q) {
            $totalBerasMustahikL += (float) str_replace(',', '.', $q->jumlah_beras_diterima);
        } 
        
        $totalSaldoBerasKg = $totalBerasMuzakkiKg - $totalBerasMustahikKg;
        $totalSaldoBerasL = $totalBerasMuzakkiL - $totalBerasMustahikL;
     
        $assets = ['chart', 'animation'];
        return view('dashboards.dashboard', compact('assets', 'Transactionsmuzakki', 'Transactionsmustahik', 'totalSaldoUang', 'totalSaldoBerasKg','totalSaldoBerasL', 'TransactionsmuzakkiH'));
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
        // Menghitung jumlah transaksi muzakki dan mustahik dari database
        $Transactionsmuzakki = Muzakki::count(); 
        $Transactionsmustahik = Mustahik::where('status', '2')->count();

        // Hitung total pemasukan untuk kategori Fitrah
        $totalPemasukanFitrah = Muzakki::where('kategori_id', 1)->sum('jumlah_bayar');
        // Hitung total pengeluaran untuk kategori Fitrah
        $totalPengeluaranFitrah = Mustahik::where('kategori_id', 1)->sum('jumlah_uang_diterima'); 
        // Hitung sisa pemasukan untuk kategori Fitrah
        $sisaPemasukanFitrah = $totalPemasukanFitrah - $totalPengeluaranFitrah;

        // Hitung total pemasukan untuk kategori Maal
        $totalPemasukanMaal = Muzakki::where('kategori_id', 2)->sum('jumlah_bayar');
        // Hitung total pengeluaran untuk kategori Maal
        $totalPengeluaranMaal = Mustahik::where('kategori_id', 2)->sum('jumlah_uang_diterima'); 
        // Hitung sisa pemasukan untuk kategori Maal
        $sisaPemasukanMaal = $totalPemasukanMaal - $totalPengeluaranMaal;

        // Hitung total pemasukan untuk kategori Fidyah
        $totalPemasukanFidyah = Muzakki::where('kategori_id', 3)->sum('jumlah_bayar');
        // Hitung total pengeluaran untuk kategori Fidyah
        $totalPengeluaranFidyah = Mustahik::where('kategori_id', 3)->sum('jumlah_uang_diterima'); 
        // Hitung sisa pemasukan untuk kategori Fidyah
        $sisaPemasukanFidyah = $totalPemasukanFidyah - $totalPengeluaranFidyah;

        // Hitung total pemasukan untuk kategori Infaq
        $totalPemasukanInfaq = Muzakki::where('kategori_id', 4)->sum('jumlah_bayar');
        // Hitung total pengeluaran untuk kategori Infaq
        $totalPengeluaranInfaq = Mustahik::where('kategori_id', 4)->sum('jumlah_uang_diterima'); 
        // Hitung sisa pemasukan untuk kategori Infaq
        $sisaPemasukanInfaq = $totalPemasukanInfaq - $totalPengeluaranInfaq;

        // Menghitung total beras masuk dari model Muzakki untuk kategori Fitrah (dalam kilogram)
        $getMuzakkiKgFitrah = Muzakki::where('type', 'Beras')
        ->where('satuan', 'Kg')
        ->whereHas('kategori', function ($query) {
            $query->where('kategori_id', 1);
        })
        ->get();
        $totalBerasMuzakkiKgFitrah = 0;
        foreach ($getMuzakkiKgFitrah as $q) {
        $totalBerasMuzakkiKgFitrah += (float) str_replace(',', '.', $q->jumlah_bayar);
        }

        // Menghitung total beras masuk dari model Muzakki untuk kategori Fidyah (dalam kilogram)
        $getMuzakkiKgFidyah = Muzakki::where('type', 'Beras')
        ->where('satuan', 'Kg')
        ->whereHas('kategori', function ($query) {
            $query->where('kategori_id', 3);
        })
        ->get();
        $totalBerasMuzakkiKgFidyah = 0;
        foreach ($getMuzakkiKgFidyah as $q) {
        $totalBerasMuzakkiKgFidyah += (float) str_replace(',', '.', $q->jumlah_bayar);
        }

        // Menghitung total beras masuk dari model Muzakki untuk kategori Fitrah (dalam liter)
        $getMuzakkiLiterFitrah = Muzakki::where('type', 'Beras')
        ->where('satuan', 'Liter')
        ->whereHas('kategori', function ($query) {
            $query->where('kategori_id', 1);
        })
        ->get();
        $totalBerasMuzakkiLFitrah = 0;
        foreach ($getMuzakkiLiterFitrah as $q) {
        $totalBerasMuzakkiLFitrah += (float) str_replace(',', '.', $q->jumlah_bayar);
        }

        // Menghitung total beras masuk dari model Muzakki untuk kategori Fidyah (dalam liter)
        $getMuzakkiLiterFidyah = Muzakki::where('type', 'Beras')
        ->where('satuan', 'Liter')
        ->whereHas('kategori', function ($query) {
            $query->where('kategori_id', 3);
        })
        ->get();
        $totalBerasMuzakkiLFidyah = 0;
        foreach ($getMuzakkiLiterFidyah as $q) {
        $totalBerasMuzakkiLFidyah += (float) str_replace(',', '.', $q->jumlah_bayar);
        }

        // Menghitung total beras diterima oleh Mustahik untuk kategori Fitrah (dalam kilogram)
        $totalBerasMustahikKgFitrah = Mustahik::where('satuan_beras', 'Kg')
        ->where('kategori_id', 1)
        ->sum('jumlah_beras_diterima');

        // Menghitung total beras diterima oleh Mustahik untuk kategori Fidyah (dalam kilogram)
        $totalBerasMustahikKgFidyah = Mustahik::where('satuan_beras', 'Kg')
        ->where('kategori_id', 3)
        ->sum('jumlah_beras_diterima');

        // Menghitung total beras diterima oleh Mustahik untuk kategori Fitrah (dalam liter)
        $totalBerasMustahikLFitrah = Mustahik::where('satuan_beras', 'Liter')
        ->where('kategori_id', 1)
        ->sum('jumlah_beras_diterima');

        // Menghitung total beras diterima oleh Mustahik untuk kategori Fidyah (dalam liter)
        $totalBerasMustahikLFidyah = Mustahik::where('satuan_beras', 'Liter')
        ->where('kategori_id', 3)
        ->sum('jumlah_beras_diterima');

        // Menghitung total saldo beras (dalam kilogram dan liter) untuk kategori Fitrah
        $totalSaldoBerasKgFitrah = $totalBerasMuzakkiKgFitrah - $totalBerasMustahikKgFitrah;
        $totalSaldoBerasLFitrah = $totalBerasMuzakkiLFitrah - $totalBerasMustahikLFitrah;

        // Menghitung total saldo beras (dalam kilogram dan liter) untuk kategori Fidyah
        $totalSaldoBerasKgFidyah = $totalBerasMuzakkiKgFidyah - $totalBerasMustahikKgFidyah;
        $totalSaldoBerasLFidyah = $totalBerasMuzakkiLFidyah - $totalBerasMustahikLFidyah;

        // Mendapatkan semua data RT dari tabel RW
        $allRt = Rw::pluck('rt')->toArray();

        // Inisialisasi array untuk menyimpan jumlah mustahiq untuk setiap RT
        $rtData = [];

        // Menghitung jumlah mustahiq untuk setiap RT
        foreach ($allRt as $rt) {
            // Hitung jumlah mustahiq berdasarkan RT dari model Mustahik
            $jumlahMustahiq = Mustahik::whereHas('rw', function ($query) use ($rt) {
                $query->where('rt', $rt);
            })->where('status', '2')->count();
            // Masukkan jumlah mustahiq ke dalam array $rtData
            $rtData[] = $jumlahMustahiq;
        }

        // Mendapatkan label RT untuk digunakan dalam grafik
        $rtLabels = $allRt;

        // Menghitung jumlah mustahiq untuk wilayah lain dari tabel Mustahik
        $jumlahMustahiqWilayahLain = Mustahik::whereNull('rw_id')->where('status', '2')->count();

        // Menambahkan jumlah mustahiq wilayah lain ke dalam array $rtData
        $rtData[] = $jumlahMustahiqWilayahLain;
        
        // Menambahkan label untuk wilayah lain
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
