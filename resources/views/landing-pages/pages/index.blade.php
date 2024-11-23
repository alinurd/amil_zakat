<x-app-layout layout="landing">
    <style>
        .toast {
            z-index: 9999; /* Menjadikan elemen paling atas */
            position: fixed; /* Memastikan elemen tetap di posisi yang sama saat digulir */
            top: 50%; /* Menggeser elemen ke tengah vertikal */
            left: 50%; /* Menggeser elemen ke tengah horizontal */
            transform: translate(-50%, -50%); /* Menengahkan elemen */
        }

        .card-hp .col-md-3 {
            border-radius: 50px 0 0 50px; /* Border radius untuk kolom kiri */
        }
        .card-hp .col-md-9 {
            border-radius: 0 50px 50px 0; /* Border radius untuk kolom kanan */
        }

        @media (max-width: 767px) {
            .header-hp {
                height: auto; /* Ubah ketinggian menjadi otomatis */
                margin-top: 0; /* Hapus margin-top */
                padding-top: 25px; /* Tambahkan padding untuk memberi ruang antara elemen */
            }
        }

        @media (max-width: 768px) {
        .card-hp {
            width: 100%; /* Lebar card untuk mobile */
        }
        .card-hp .row {
            display: flex; /* Mengatur tata letak menjadi flexbox */
            flex-direction: column; /* Menjadikan tata letak menjadi vertikal */
            border-radius: 0; /* Menghapus border radius */
        }
        .card-hp .col-md-3, .card-hp .col-md-9 {
            flex: 1; /* Memastikan kolom menyesuaikan ukuran */
            background: #118146; /* Warna latar belakang untuk versi mobile */
            border-radius: 0; /* Menghapus border radius */
            text-align: center;
        }
        .card-hp h6 {
            text-align: center; /* Rata tengah teks */
            margin: 12px auto;
        }

        .nav.nav-tabs {
            margin-top: 30px;
            text-align: center;
            display: flex;
            justify-content: center;
        } 
        .nav.nav-tabs.mb-3 .nav-link {
            margin-right: 10px; /* Atur jarak antara setiap tombol navigasi */
            margin-bottom: 10px; /* Atur jarak antara tombol navigasi dan elemen di bawahnya */
        }

        }
    </style>

     @if (session('success'))
        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#007aff"></rect></svg>
                <strong class="me-auto">Pengajuan Mustahiq</strong>
                <small class="text-muted text-success">Successfully</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
            Pengajuan anda berhasil ditambahkan
            </div>
        </div>
    @endif

    <div class="container m-auto">
        <div class="iq-navbar-header mb-4 header-hp" style="height: 80px; margin-top: -30px;">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-md-9">
                    <div>
                        <img src="{{asset('images/dashboard/header.jpg')}}" style="width: 100%;">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary text-white btn-sm mr-2" href="{{route('mustahikuser.create')}}">
                            <svg width="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.7689 8.3818H22C22 4.98459 19.9644 3 16.5156 3H7.48444C4.03556 3 2 4.98459 2 8.33847V15.6615C2 19.0154 4.03556 21 7.48444 21H16.5156C19.9644 21 22 19.0154 22 15.6615V15.3495H17.7689C15.8052 15.3495 14.2133 13.7975 14.2133 11.883C14.2133 9.96849 15.8052 8.41647 17.7689 8.41647V8.3818ZM17.7689 9.87241H21.2533C21.6657 9.87241 22 10.1983 22 10.6004V13.131C21.9952 13.5311 21.6637 13.8543 21.2533 13.8589H17.8489C16.8548 13.872 15.9855 13.2084 15.76 12.2643C15.6471 11.6783 15.8056 11.0736 16.1931 10.6122C16.5805 10.1509 17.1573 9.88007 17.7689 9.87241ZM17.92 12.533H18.2489C18.6711 12.533 19.0133 12.1993 19.0133 11.7877C19.0133 11.3761 18.6711 11.0424 18.2489 11.0424H17.92C17.7181 11.0401 17.5236 11.1166 17.38 11.255C17.2364 11.3934 17.1555 11.5821 17.1556 11.779C17.1555 12.1921 17.4964 12.5282 17.92 12.533ZM6.73778 8.3818H12.3822C12.8044 8.3818 13.1467 8.04812 13.1467 7.63649C13.1467 7.22487 12.8044 6.89119 12.3822 6.89119H6.73778C6.31903 6.89116 5.9782 7.2196 5.97333 7.62783C5.97331 8.04087 6.31415 8.37705 6.73778 8.3818Z" fill="currentColor"></path>
                            </svg> &ensp;
                            Mustahiq
                        </a>&nbsp;
                        <a class="btn btn-primary btn-sm text-white" href="{{ route('login') }}">
                            <svg width="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.08 22H7.91C4.38 22 2 19.729 2 16.34V7.67C2 4.28 4.38 2 7.91 2H16.08C19.62 2 22 4.28 22 7.67V16.34C22 19.729 19.62 22 16.08 22ZM14.27 11.25H7.92C7.5 11.25 7.17 11.59 7.17 12C7.17 12.42 7.5 12.75 7.92 12.75H14.27L11.79 15.22C11.65 15.36 11.57 15.56 11.57 15.75C11.57 15.939 11.65 16.13 11.79 16.28C12.08 16.57 12.56 16.57 12.85 16.28L16.62 12.53C16.9 12.25 16.9 11.75 16.62 11.47L12.85 7.72C12.56 7.43 12.08 7.43 11.79 7.72C11.5 8.02 11.5 8.49 11.79 8.79L14.27 11.25Z" fill="currentColor"></path>
                            </svg>
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>

        <div class="row">
            <div class="form-group col-md-4">
                <select name="#" id="#" class="form-control">
                    <option value="">Pilih Tahun</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <button type="button" name="next" class="btn next1 btn-primary next action-button float-left" value="Next" style="background: #118146;">Filter</button>
            </div>
        </div>

        <div class="bd-example">
            <nav>
                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Total Pemasukan</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Total Penyaluran</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">

                <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-bottom border-4 border-0 border-info">
                                <div class="card mb-1" style="background: #118146;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="h3 p-3 rounded bg-soft-light text-white">
                                                    Fitrah
                                                </div>
                                            </div>
                                            <div>
                                                <div class="badge m-3">
                                                    <span class="h4 text-white d-md-inline d-none">Uang:</span>
                                                    <span class="badge bg-primary"><b class="h4 text-white">Rp{{ number_format($totalPemasukanFitrah, 0) }}.-</b></span>
                                                </div>
                                                <h6 class="text-white">Beras: {{ number_format($totalBerasMuzakkiLFitrah, 1) }} Liter &amp; {{ number_format($totalBerasMuzakkiKgFitrah, 0) }} Kg</h6>
                                            </div>
                                            <div></div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-bottom border-4 border-0 border-info">
                                <div class="card mb-1" style="background: #118146;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="h3 p-3 rounded bg-soft-light text-white">
                                                    Fidyah
                                                </div>
                                            </div>
                                            <div>
                                                <div class="badge m-3">
                                                    <span class="h4 text-white">Uang:</span>
                                                </div>
                                                <span class="badge bg-primary"><b class="h4 text-white">Rp{{ number_format($totalPemasukanFidyah, 0) }}.-</b></span>
                                                <h6 class="text-white">Beras: {{ number_format($totalBerasMuzakkiLFidyah, 1) }} Liter &amp; {{ number_format($totalBerasMuzakkiKgFidyah, 0) }} Kg</h6>
                                            </div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: -2%;">
                        <div class="col-md-6">
                                <div class="card border-bottom border-4 border-0 border-info">
                                    <div class="card mb-1" style="background: #118146;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="h3 p-3 rounded bg-soft-light text-white">
                                                        Maal
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="badge m-3">
                                                        <span class="h4 text-white">Uang:</span>
                                                    </div>
                                                    <span class="badge bg-primary"><b class="h4 text-white">Rp{{ number_format($totalPemasukanMaal, 0) }}.-</b></span>
                                                </div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="card border-bottom border-4 border-0 border-info">
                                    <div class="card mb-1" style="background: #118146;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="h3 p-3 rounded bg-soft-light text-white">
                                                        Infaq
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="badge m-3">
                                                        <span class="h4 text-white">Uang:</span>
                                                    </div>
                                                    <span class="badge bg-primary"><b class="h4 text-white">Rp{{ number_format($totalPemasukanInfaq, 0) }}.-</b></span>
                                                </div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-bottom border-4 border-0 border-info">
                                <div class="card mb-1" style="background: #118146;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="h3 p-3 rounded bg-soft-light text-white">
                                                    Fitrah
                                                </div>
                                            </div>
                                            <div>
                                                <div class="badge m-3">
                                                    <span class="h4 text-white d-md-inline d-none">Uang:</span>
                                                    <span class="badge bg-primary"><b class="h4 text-white">Rp{{ number_format($totalPengeluaranFitrah, 0) }}.-</b></span>
                                                </div>
                                                <h6 class="text-white">Beras: {{ number_format($totalBerasMustahikLFitrah, 1) }} Liter &amp; {{ number_format($totalBerasMustahikKgFitrah, 0) }} Kg</h6>
                                            </div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-bottom border-4 border-0 border-info">
                                <div class="card mb-1" style="background: #118146;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="h3 p-3 rounded bg-soft-light text-white">
                                                    Fidyah
                                                </div>
                                            </div>
                                            <div>
                                                <div class="badge m-3">
                                                    <span class="h4 text-white">Uang:</span>
                                                </div>
                                                <span class="badge bg-primary"><b class="h4 text-white">Rp{{ number_format($totalPengeluaranFidyah, 0) }}.-</b></span>
                                                <h6 class="text-white">Beras: {{ number_format($totalBerasMustahikLFidyah, 1) }} Liter &amp; {{ number_format($totalBerasMustahikKgFidyah, 0) }} Kg</h6>
                                            </div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: -2%;">
                        <div class="col-md-6">
                                <div class="card border-bottom border-4 border-0 border-info">
                                    <div class="card mb-1" style="background: #118146;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="h3 p-3 rounded bg-soft-light text-white">
                                                        Maal
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="badge m-3">
                                                        <span class="h4 text-white">Uang:</span>
                                                    </div>
                                                    <span class="badge bg-primary"><b class="h4 text-white">Rp{{ number_format($totalPengeluaranMaal, 0) }}.-</b></span>
                                                </div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="card border-bottom border-4 border-0 border-info">
                                    <div class="card mb-1" style="background: #118146;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="h3 p-3 rounded bg-soft-light text-white">
                                                        Infaq
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="badge m-3">
                                                        <span class="h4 text-white">Uang:</span>
                                                    </div>
                                                    <span class="badge bg-primary"><b class="h4 text-white">Rp{{ number_format($totalPengeluaranInfaq, 0) }}.-</b></span>
                                                </div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card mt-1">
            <div class="card-body">
                <div class="d-flex flex-column">
                    <div class="mb-5">
                        <h6 style="color: #118145;">Area Distribusi dan Jumlah Mustahiq</h6>
                    </div>
                    <div class="border rounded">
                        <div id="extrachart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-hp" style="width: 97%; margin: 30px auto;">
            <div class="row">
                <div class="col-md-3 col-sm-12" style="background: #118146;">
                    <a href="{{ route('uisheet') }}">
                        <h6 class="text-white text-center mt-3">Masjid Al Hasanah</h6> 
                    </a>
                </div>
                <div class="col-md-9 col-sm-12 bg-light">
                    <p class="mt-3" style="color: #118146;">Taman Meruya Ilir, Blok B13 No.1, Kembangan, Jakarta Barat | +6221 256 844 72</p>
                </div>
            </div>
        </div>

    </div>
    

</x-app-layout>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div id="extrachart"></div>

@php
    $greenColors = [
        '#5cb85c', '#4cae4c', '#449d44', '#398439', '#2e732e',
        '#256625', '#1b541b', '#104410', '#0a330a', '#032203',
        '#0a330a', '#104410', '#1b541b', '#256625', '#2e732e',
        '#398439', '#449d44', '#5cb85c', '#5cb85c'
    ];
@endphp
 
<script>
    $(document).ready(function() {
        let seriesData = [];

        @php
            $colorIndex = 0;
        @endphp

        @foreach($rtData as $index => $data)
            @if($index < count($rtLabels) - 1)
                seriesData.push({
                    name: 'RT{{ str_pad($index + 1, 3, "0", STR_PAD_LEFT) }}',
                    data: [{{ $data }}],
                    color: '{{ $greenColors[$colorIndex++] }}'
                });
            @endif
        @endforeach

        seriesData.push({
            name: 'Wilayah Lainnya',
            data: [{{ end($rtData) }}],
            color: '{{ $greenColors[count($rtLabels) - 1] }}' 
        });

        const options = {
            series: seriesData,
            chart: {
                type: 'bar',
                height: 500,
                sparkline: {
                    enabled: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '58%',
                    borderRadius: 6,
                },
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                show: true,
                width: 2,
                curve: 'smooth',
                colors: ['transparent']
            },
            xaxis: {
                categories: ['JUMLAH MUSTAHIQ BERDASARKAN AREA '],
            },
            yaxis: {
                title: {
                    text: ''
                },
                max: 100, // Batas tinggi grafik
                tickAmount: 5 // Jumlah label pada sumbu y
            },
            fill: {
                opacity: 1,
                colors: @json($greenColors)
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "" + val + " Jiwa"
                    }
                }
            }
        };
        
        const chart = new ApexCharts(document.querySelector("#extrachart"), options);
        chart.render();
    }); 
</script>



