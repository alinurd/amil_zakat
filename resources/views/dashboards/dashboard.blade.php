<x-app-layout :assets="$assets ?? []">
   <div class="row" >
      <div class="col-md-12 col-lg-12">
         <div class="row row-cols-1">
            <div class="d-slider1 overflow-hidden ">
               <ul class="swiper-wrapper list-inline m-0 p-0 mb-2">
                  <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                     <div class="card-body">
                        <div class="progress-widget">
                           <div id="circle-progress-01" class="circle-progress-01 circle-progress circle-progress-primary text-center" data-min-value="0" data-max-value="100" data-value="90" data-type="percent">
                              <svg class="card-slie-arrow " width="24" height="24px" viewBox="0 0 24 24">
                                 <path fill="currentColor" d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                              </svg>
                           </div>
                           <div class="progress-detail">
                              <a href="{{route('muzakki.index')}}" title="Lihat Muzakki Detail">
                                 <p class="mb-2">Total Transaksi Muzakki</p>
                              </a>
                              <h4 class="counter" style="visibility: visible;" title="Invocie:{{ $TransactionsmuzakkiH }} | Muzakki:{{ $Transactionsmuzakki }}">{{ $TransactionsmuzakkiH }}/{{ $Transactionsmuzakki}}</h4>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                     <div class="card-body">
                        <div class="progress-widget">
                           <div id="circle-progress-02" class="circle-progress-01 circle-progress circle-progress-info text-center" data-min-value="0" data-max-value="100" data-value="80" data-type="percent">
                              <svg class="card-slie-arrow " width="24" height="24" viewBox="0 0 24 24">
                                 <path fill="currentColor" d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                              </svg>
                           </div>
                           <div class="progress-detail">
                              <a href="{{route('mustahik.index')}}" title="Lihat Mustahiq Detail">
                                 <p class="mb-2">Total Transaksi Mustahiq</p>
                              </a>
                              <h4 class="counter">{{ $Transactionsmustahik }}</h4>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                     <div class="card-body">
                        <div class="progress-widget">
                           <div id="circle-progress-03" class="circle-progress-01 circle-progress circle-progress-primary text-center" data-min-value="0" data-max-value="100" data-value="70" data-type="percent">
                              <svg class="card-slie-arrow " width="24" viewBox="0 0 24 24">
                                 <path fill="currentColor" d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                              </svg>
                           </div>
                           <div class="progress-detail">
                              <p class="mb-2">Total Saldo Uang</p>
                              <h4 class="counter" style="visibility: visible;">Rp{{ number_format($totalSaldoUang) }}</h4>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                     <div class="card-body">
                        <div class="progress-widget">
                           <div id="circle-progress-04" class="circle-progress-01 circle-progress circle-progress-info text-center" data-min-value="0" data-max-value="100" data-value="60" data-type="percent">
                              <svg class="card-slie-arrow " width="24px" height="24px" viewBox="0 0 24 24">
                                 <path fill="currentColor" d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                              </svg>
                           </div>
                           <div class="progress-detail">
                              <p class="mb-2">Total Saldo Beras</p>
                              <h4 class="counter">{{ $totalSaldoBerasKg }} Kg | {{ $totalSaldoBerasL }} Liter</h4>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
               <div class="swiper-button swiper-button-next"></div>
               <div class="swiper-button swiper-button-prev"></div>
            </div>
         </div>

         <div class="row row-cols-1">
            <div class="d-slider1 overflow-hidden">
               <ul class="swiper-wrapper list-inline m-0 p-0 mb-2">
                     @foreach ($createdByData as $data)
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                           <div class="card-body">
                                 <div class="progress-widget">                                    
                                    <div class="progress-detail">
                                       <strong class="text-black">Pendapatan Petugas Zakat <span class="text-primary">Muzakki:</span></strong> {{ $data['user'] }} <br><br>
                                       <span class="text-primary" style="font-size: 16px;">Uang:</span> Rp{{ number_format($data['total_uang'], 2) }} <br>
                                       <span class="text-primary" style="font-size: 16px;">Beras (Kg):</span> {{ number_format($data['total_beras_kg'], 2) }} Kg <br>
                                       <span class="text-primary" style="font-size: 16px;">Beras (Liter):</span> {{ number_format($data['total_beras_liter'], 2) }} Liter
                                    </div>
                                 </div>
                           </div>
                        </li>
                     @endforeach
               </ul>
               <div class="swiper-button swiper-button-next"></div>
               <div class="swiper-button swiper-button-prev"></div>
            </div>
         </div>
      </div>


      <div class="alert alert-bottom alert-warning alert-dismissible fade show" id="card-body" style="display: none;" role="alert">
      <div class="card-body"> 
        <center>
            <strong>
                <p class="mb-2">Masa Aktif Aplikasi Anda Akan Segera Berahir Pada <br><u><strong> 15 Februari 2025 00:00:00</strong></u> </p>
                <small class="text-muted">Pastikan anda sudah membackup semua data & segera lakukan aktivasi </small>
                <div class="card">
                    <div class="card-body">
                        <span id="countdown" style="color:red"></span>
                    </div>
                </div>
            </strong>
            <div class="bd-example table-responsive d-none">
                <table class="table table-sm table-bordered">
                    <tr>
                        <td width="60px">Domain</td>
                        <td  width="5px">:</td>
                        <td>https://www.zis-alhasanah.com</td>
                    </tr>
                    <tr>
                        <td width="50px">Mulai</td>
                        <td  width="5px">:</td>
                        <td>2025-03-11</td>
                    </tr>
                    <tr>
                        <td width="60px">Berakhir</td>
                        <td  width="5px">:</td>
                        <td>2025-03-11</td>
                    </tr>
                    <tr>
                        <td width="60px">Periode Tagihan</td>
                        <td  width="5px">:</td>
                        <td>Tahunan (Bayar Setiap 12 Bulan)</td>
                    </tr>
                </table>
            </div>
        </center>
    </div>
    <script>
        // Fungsi untuk hitung mundur
        function updateCountdown() {
            const targetDate = new Date('feb 15, 2025 00:00:00').getTime();
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance <= 0) {
                document.getElementById("countdown").innerHTML = "Waktu Habis!";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML =
                `${days} hari ${hours} : ${minutes} : ${seconds}`;
        }

        // Menampilkan card-body setelah 3 detik
        setTimeout(() => {
            document.getElementById('card-body').style.display = 'block';
        }, 3000);

        // Memperbarui hitungan mundur setiap detik
        setInterval(updateCountdown, 1000);
    </script>
</div>

   </div>



   </div>
</x-app-layout>