<div class="main-panel">
    <div class="main-header">
      <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="index.html" class="logo">
            <img
              src="{{ asset('assets/img/logo.png') }}"
              alt="navbar brand"
              class="navbar-brand"
              height="20"
            />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <!-- Navbar Header -->
      <nav
        class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
      >
        <div class="container-fluid">

          <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li
              class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
            >
              <a
                class="nav-link dropdown-toggle"
                data-bs-toggle="dropdown"
                href="#"
                role="button"
                aria-expanded="false"
                aria-haspopup="true"
              >
                <i class="fa fa-search"></i>
              </a>
              <ul class="dropdown-menu dropdown-search animated fadeIn">
                <form class="navbar-left navbar-form nav-search">
                  <div class="input-group">
                    <input
                      type="text"
                      placeholder="Search ..."
                      class="form-control"
                    />
                  </div>
                </form>
              </ul>
            </li>

            <?php
              use Illuminate\Support\Facades\Auth;
              use App\Models\Ticketing;
              use App\Models\Quotations;
              use App\Models\QuotationNegotiation; 
              use App\Models\PurchaseOrders;
              use App\Models\ProformaInvoice;
              use App\Models\ProformaInvoicePaymentProof;

              $userId = Auth::id();
              $user = Auth::user();

              $unreadMessagesQuotations = Quotations::where('is_viewed_distributor', 0)
                ->where('user_id', Auth::id()) // Filter berdasarkan user_id member yang sedang login
                ->orderBy('created_at', 'desc')
                ->get();

                
                $unreadNegotiations = QuotationNegotiation::where('is_viewed_distributor', 0)
              ->whereHas('quotation', function ($query) use ($userId) {
                  $query->where('user_id', $userId); // Filter berdasarkan user_id
              })
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadNegotiationsClose = QuotationNegotiation::where('is_viewed_distributor', 0)
              ->where('status', 'close') // Filter berdasarkan status 'close'
              ->whereHas('quotation', function ($query) use ($userId) {
                  $query->where('user_id', $userId); // Filter quotations berdasarkan user_id
              })
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadMessagesPOAcc = PurchaseOrders::where('is_viewed_distributor', 0)
              ->where('status', 'approved') // Filter berdasarkan status 'acc'
              ->where('user_id', Auth::id()) // Filter berdasarkan user_id member yang sedang login
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadMessagesPORej = PurchaseOrders::where('is_viewed_distributor', 0)
              ->where('status', 'rejected') // Filter berdasarkan status 'acc'
              ->where('user_id', Auth::id()) // Filter berdasarkan user_id member yang sedang login
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadMessagesPI = ProformaInvoice::where('is_viewed_distributor', 0)
              ->whereHas('purchaseOrder', function ($query) {
                  $query->where('user_id', Auth::id()); // Filter berdasarkan user_id pada PurchaseOrder
              })
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadMessagesProofDPAcc = ProformaInvoicePaymentProof::where('is_viewed_distributor', 0)
              ->whereHas('proformaInvoice.purchaseOrder', function ($query) {
                  $query->where('user_id', Auth::id()); // Filter berdasarkan user_id pada PurchaseOrder
              })
              ->where('status', 'accepted')
              ->where('payment_type', 'dp') // Filter payment_type = dp
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadMessagesProofDPRej = ProformaInvoicePaymentProof::where('is_viewed_distributor', 0)
              ->whereHas('proformaInvoice.purchaseOrder', function ($query) {
                  $query->where('user_id', Auth::id()); // Filter berdasarkan user_id pada PurchaseOrder
              })
              ->where('status', 'rejected')
              ->where('payment_type', 'dp') // Filter payment_type = dp
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadMessagesProofBLAcc = ProformaInvoicePaymentProof::where('is_viewed_distributor', 0)
              ->whereHas('proformaInvoice.purchaseOrder', function ($query) {
                  $query->where('user_id', Auth::id()); // Filter berdasarkan user_id pada PurchaseOrder
              })
              ->where('status', 'accepted')
              ->where('payment_type', 'balance') // Filter payment_type = balance
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadMessagesProofBLRej = ProformaInvoicePaymentProof::where('is_viewed_distributor', 0)
              ->whereHas('proformaInvoice.purchaseOrder', function ($query) {
                  $query->where('user_id', Auth::id()); // Filter berdasarkan user_id pada PurchaseOrder
              })
              ->where('status', 'rejected')
              ->where('payment_type', 'balance') // Filter payment_type = balance
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadMessagesQuotationClose = Quotations::where('is_viewed_distributor', 0)
                ->where('user_id', Auth::id()) // Filter berdasarkan user_id member yang sedang login
                ->where('status', 'close')
                ->orderBy('created_at', 'desc')
                ->get();





              $unreadCount = $unreadMessagesQuotations->count() + $unreadNegotiations->count() + $unreadNegotiationsClose->count() + $unreadMessagesPOAcc->count() + $unreadMessagesPORej->count()+ $unreadMessagesPI->count() + $unreadMessagesProofDPAcc->count() + $unreadMessagesProofDPRej->count() + $unreadMessagesProofBLAcc->count() + $unreadMessagesProofBLRej->count() + $unreadMessagesQuotationClose->count();
              ?>

              <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                      class="nav-link dropdown-toggle"
                      href="#"
                      id="messageDropdown"
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                  >
                      <i class="fa fa-bell">
                          @if($unreadCount > 0)
                              <span class="badge badge-danger">{{ $unreadCount }}</span>
                          @endif
                      </i>
                  </a>
                  <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                      <li>
                          <div class="dropdown-title d-flex justify-content-between align-items-center">
                              Pesan
                              <a href="{{ route('messages.index') }}" class="small">Tandai semua terbaca</a>
                          </div>
                      </li>
                      <li>
                        <div class="message-notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                @foreach ($unreadMessagesQuotations as $quotation)
                                    <a href="{{ route('distributor.quotations.show', $quotation->id) }}" 
                                       class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                                        <!-- Icon and Time -->
                                        <div class="me-3 text-center">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle 
                                                @if($quotation->status === 'approved')
                                                    bg-success
                                                @else
                                                    bg-warning
                                                @endif
                                                text-white" style="width: 40px; height: 40px;">
                                                <i class="fa fa-file-alt fa-lg"></i>
                                            </div>
                                            <small class="text-muted d-block mt-1">
                                                {{ $quotation->created_at->format('H:i') }}
                                            </small>
                                        </div>
                    
                                        <!-- Notification Content -->
                                        <div class="flex-grow-1">
                                            <!-- Header -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-dark">
                                                    @if ($quotation->status === 'approved' && !$quotation->is_viewed_distributor)
                                                        Quotation Diterima
                                                    @else
                                                        Notifikasi Quotation
                                                    @endif
                                                </span>
                                                <span class="badge bg-primary text-white">Quotation</span>
                                            </div>
                    
                                            <!-- Quotation Info -->
                                            <p class="text-dark mb-2">
                                                Produk: <strong>{{ $quotation->product_name }}</strong>
                                            </p>
                    
                                            <!-- Status Information -->
                                            <p class="text-secondary mb-0">
                                                @if ($quotation->status === 'approved' && !$quotation->is_viewed_distributor)
                                                    Permintaan quotation Anda telah diterima. Silakan melanjutkan untuk membuat PO.
                                                @else
                                                    Status: <strong>{{ ucfirst($quotation->status) }}</strong>
                                                @endif
                                            </p>
                                        </div>
                                    </a>
                                @endforeach

                                @foreach ($unreadNegotiations as $negotiation)
                                  <a href="{{ route('distributor.quotations.negotiation.show', $negotiation->id) }}" 
                                    class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                                      <!-- Icon and Time -->
                                      <div class="me-3 text-center">
                                          <div class="d-flex align-items-center justify-content-center rounded-circle 
                                              bg-info text-white" style="width: 40px; height: 40px;">
                                              <i class="fa fa-handshake fa-lg"></i>
                                          </div>
                                          <small class="text-muted d-block mt-1">
                                              {{ $negotiation->created_at->format('H:i') }}
                                          </small>
                                      </div>

                                      <!-- Notification Content -->
                                      <div class="flex-grow-1">
                                          <div class="d-flex justify-content-between align-items-center">
                                              <span class="fw-bold text-dark">
                                                  Negosiasi Diperbarui
                                              </span>
                                              <span class="badge bg-success text-white">Negosiasi</span>
                                          </div>
                                          <p class="text-dark mb-2">
                                              Produk: <strong>{{ $negotiation->quotation->product_name }}</strong>
                                          </p>
                                          <p class="text-secondary mb-0">
                                              Admin telah memberikan tanggapan untuk negosiasi Anda. 
                                              @if($negotiation->status === 'accepted')
                                                  Negosiasi telah disetujui.
                                              @elseif($negotiation->status === 'rejected')
                                                  Negosiasi telah ditolak.
                                              @else
                                                  Status: <strong>{{ ucfirst($negotiation->status) }}</strong>
                                              @endif
                                          </p>
                                      </div>
                                  </a>
                              @endforeach

                              @foreach ($unreadNegotiationsClose as $negotiation)
                                <a href="{{ route('distributor.quotations.negotiation.show', $negotiation->id) }}" 
                                  class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                                    <!-- Icon and Time -->
                                    <div class="me-3 text-center">
                                        <div class="d-flex align-items-center justify-content-center rounded-circle 
                                            bg-info text-white" style="width: 40px; height: 40px;">
                                            <i class="fa fa-handshake fa-lg"></i>
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            {{ $negotiation->created_at->format('H:i') }}
                                        </small>
                                    </div>

                                    <!-- Notification Content -->
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-dark">
                                                Negosiasi Selesai
                                            </span>
                                            <span class="badge bg-success text-white">Negosiasi</span>
                                        </div>
                                        <p class="text-dark mb-2">
                                            Produk: <strong>{{ $negotiation->quotation->product_name }}</strong>
                                        </p>
                                        <p class="text-secondary mb-0">
                                            Negosiasi Anda dengan status <strong>{{ ucfirst($negotiation->status) }}</strong> telah selesai.
                                        </p>
                                    </div>
                                </a>
                            @endforeach


                            @foreach ($unreadMessagesPOAcc as $po)
                            <a href="{{ route('distributor.quotations.index', $po->id) }}" 
                               class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                                <!-- Icon and Time -->
                                <div class="me-3 text-center">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle 
                                        bg-success text-white" style="width: 40px; height: 40px;">
                                        <i class="fa fa-check-circle fa-lg"></i>
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        {{ $po->created_at->format('H:i') }}
                                    </small>
                                </div>
                    
                                <!-- Notification Content -->
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-dark">
                                            PO Disetujui
                                        </span>
                                        <span class="badge bg-success text-white">Approved</span>
                                    </div>
                                    <p class="text-dark mb-2">
                                        Purchase Order ID: <strong>{{ $po->id }}</strong>
                                    </p>
                                    <p class="text-secondary mb-0">
                                        Purchase Order Anda telah disetujui. Silakan menunggu admin untuk mengirim Proforma Invoice.
                                    </p>
                                </div>
                            </a>
                        @endforeach

                        @foreach ($unreadMessagesPORej as $po)
                        <a href="{{ route('distributor.quotations.index', $po->id) }}" 
                           class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                            <!-- Icon and Time -->
                            <div class="me-3 text-center">
                                <div class="d-flex align-items-center justify-content-center rounded-circle 
                                    bg-danger text-white" style="width: 40px; height: 40px;">
                                    <i class="fa fa-times-circle fa-lg"></i>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    {{ $po->created_at->format('H:i') }}
                                </small>
                            </div>
                
                            <!-- Notification Content -->
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">
                                        PO Ditolak
                                    </span>
                                    <span class="badge bg-danger text-white">Rejected</span>
                                </div>
                                <p class="text-dark mb-2">
                                    Purchase Order ID: <strong>{{ $po->id }}</strong>
                                </p>
                                <p class="text-secondary mb-0">
                                    Purchase Order Anda ditolak. Silakan ajukan ulang PO anda.
                                </p>
                            </div>
                        </a>
                    @endforeach

                    @foreach ($unreadMessagesPI as $pi)
                    <a href="{{ route('distributor.proformainvoice.index', $pi->purchaseOrder->quotation->id) }}" 
                      class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                        <!-- Icon and Time -->
                        <div class="me-3 text-center">
                            <div class="d-flex align-items-center justify-content-center rounded-circle 
                                bg-primary text-white" style="width: 40px; height: 40px;">
                                <i class="fa fa-file-invoice fa-lg"></i>
                            </div>
                            <small class="text-muted d-block mt-1">
                                {{ $pi->created_at->format('H:i') }}
                            </small>
                        </div>
            
                        <!-- Notification Content -->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark">
                                    Proforma Invoice Diterima
                                </span>
                                <span class="badge bg-primary text-white">PI</span>
                            </div>
                            <p class="text-dark mb-2">
                                Purchase Order ID: <strong>{{ $pi->purchaseOrder->id }}</strong>
                            </p>
                            <p class="text-secondary mb-0">
                                Admin telah memberikan Proforma Invoice. Silakan lakukan pembayaran sesuai Proforma Invoice.
                            </p>
                        </div>
                    </a>
                    @endforeach


                    @foreach ($unreadMessagesProofDPAcc as $proof)
                      <a href="{{ route('distributor.proformainvoice.index', $proof->proformaInvoice->purchaseOrder->quotation_id) }}" 
                        class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                          <!-- Icon and Time -->
                          <div class="me-3 text-center">
                              <div class="d-flex align-items-center justify-content-center rounded-circle 
                                  bg-success text-white" style="width: 40px; height: 40px;">
                                  <i class="fa fa-check-circle fa-lg"></i>
                              </div>
                              <small class="text-muted d-block mt-1">
                                  {{ $proof->created_at->format('H:i') }}
                              </small>
                          </div>
              
                          <!-- Notification Content -->
                          <div class="flex-grow-1">
                              <div class="d-flex justify-content-between align-items-center">
                                  <span class="fw-bold text-dark">
                                      Bukti Pembayaran DP Diterima
                                  </span>
                                  <span class="badge bg-success text-white">Accepted</span>
                              </div>
                              <p class="text-dark mb-2">
                                  Proforma Invoice ID: <strong>{{ $proof->proformaInvoice->id }}</strong>
                              </p>
                              <p class="text-secondary mb-0">
                                  Bukti pembayaran DP Anda telah diterima. Silakan melanjutkan pembayaran pelunasan.
                              </p>
                          </div>
                      </a>
                  @endforeach
              
                  <!-- Payment Proof Rejected Notifications -->
                  @foreach ($unreadMessagesProofDPRej as $proof)
                      <a href="{{ route('distributor.proformainvoice.index', $proof->proformaInvoice->purchaseOrder->quotation_id) }}" 
                        class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                          <!-- Icon and Time -->
                          <div class="me-3 text-center">
                              <div class="d-flex align-items-center justify-content-center rounded-circle 
                                  bg-danger text-white" style="width: 40px; height: 40px;">
                                  <i class="fa fa-times-circle fa-lg"></i>
                              </div>
                              <small class="text-muted d-block mt-1">
                                  {{ $proof->created_at->format('H:i') }}
                              </small>
                          </div>
              
                          <!-- Notification Content -->
                          <div class="flex-grow-1">
                              <div class="d-flex justify-content-between align-items-center">
                                  <span class="fw-bold text-dark">
                                      Bukti Pembayaran DP Ditolak
                                  </span>
                                  <span class="badge bg-danger text-white">Rejected</span>
                              </div>
                              <p class="text-dark mb-2">
                                  Proforma Invoice ID: <strong>{{ $proof->proformaInvoice->id }}</strong>
                              </p>
                              <p class="text-secondary mb-0">
                                  Bukti pembayaran DP Anda ditolak. Silakan kirim ulang bukti pembayaran dengan benar.
                              </p>
                          </div>
                      </a>
                  @endforeach


                  @foreach ($unreadMessagesProofBLAcc as $proof)
                  <a href="{{ route('distributor.proformainvoice.index', $proof->proformaInvoice->purchaseOrder->quotation_id) }}" 
                    class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                      <!-- Icon and Time -->
                      <div class="me-3 text-center">
                          <div class="d-flex align-items-center justify-content-center rounded-circle 
                              bg-success text-white" style="width: 40px; height: 40px;">
                              <i class="fa fa-check-circle fa-lg"></i>
                          </div>
                          <small class="text-muted d-block mt-1">
                              {{ $proof->created_at->format('H:i') }}
                          </small>
                      </div>

                      <!-- Notification Content -->
                      <div class="flex-grow-1">
                          <div class="d-flex justify-content-between align-items-center">
                              <span class="fw-bold text-dark">
                                  Pembayaran Balance Diterima
                              </span>
                              <span class="badge bg-success text-white">Accepted</span>
                          </div>
                          <p class="text-dark mb-2">
                              Proforma Invoice ID: <strong>{{ $proof->proformaInvoice->id }}</strong>
                          </p>
                          <p class="text-secondary mb-0">
                              Pembayaran sesi terakhir Anda telah diterima. Transaksi telah selesai. Terima kasih!
                          </p>
                      </div>
                  </a>
              @endforeach


              @foreach ($unreadMessagesProofBLRej as $proof)
              <a href="{{ route('distributor.proformainvoice.index', $proof->proformaInvoice->purchaseOrder->quotation_id) }}" 
                class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                  <!-- Icon and Time -->
                  <div class="me-3 text-center">
                      <div class="d-flex align-items-center justify-content-center rounded-circle 
                          bg-danger text-white" style="width: 40px; height: 40px;">
                          <i class="fa fa-times-circle fa-lg"></i>
                      </div>
                      <small class="text-muted d-block mt-1">
                          {{ $proof->created_at->format('H:i') }}
                      </small>
                  </div>

                  <!-- Notification Content -->
                  <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-center">
                          <span class="fw-bold text-dark">
                              Pembayaran Balance Ditolak
                          </span>
                          <span class="badge bg-danger text-white">Rejected</span>
                      </div>
                      <p class="text-dark mb-2">
                          Proforma Invoice ID: <strong>{{ $proof->proformaInvoice->id }}</strong>
                      </p>
                      <p class="text-secondary mb-0">
                          Pembayaran sesi terakhir Anda ditolak. Silakan kirim ulang bukti pembayaran untuk menyelesaikan transaksi.
                      </p>
                  </div>
              </a>
          @endforeach


          @foreach ($unreadMessagesQuotationClose as $quotation)
          <a href="{{ route('distributor.quotations.show', $quotation->id) }}" 
            class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
              <!-- Icon and Time -->
              <div class="me-3 text-center">
                  <div class="d-flex align-items-center justify-content-center rounded-circle 
                      bg-info text-white" style="width: 40px; height: 40px;">
                      <i class="fa fa-file-alt fa-lg"></i>
                  </div>
                  <small class="text-muted d-block mt-1">
                      {{ $quotation->created_at->format('H:i') }}
                  </small>
              </div>

              <!-- Notification Content -->
              <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-center">
                      <span class="fw-bold text-dark">
                          Quotation Selesai
                      </span>
                      <span class="badge bg-info text-white">Close</span>
                  </div>
                  <p class="text-dark mb-2">
                      Quotation ID: <strong>{{ $quotation->id }}</strong>
                  </p>
                  <p class="text-secondary mb-0">
                      Quotation Anda telah selesai diproses. Jika ada hal yang membingungkan, silakan hubungi admin.
                  </p>
              </div>
          </a>
      @endforeach

                

                    
                                {{-- If no notifications --}}
                                @if ($unreadCount === 0)
                                    <p class="text-center text-muted my-3">Tidak ada notifikasi baru.</p>
                                @endif
                            </div>
                        </div>
                    </li>
                    
                      <li>
                          <a class="see-all" href="{{ route('messages.index') }}">Lihat semua pesan<i class="fa fa-angle-right"></i></a>
                      </li>
                  </ul>
              </li>

          




            <li class="nav-item topbar-user dropdown hidden-caret">
              <a
                class="dropdown-toggle profile-pic"
                data-bs-toggle="dropdown"
                href="#"
                aria-expanded="false"
              >
                <div class="avatar-sm">
                  <img
                    src="{{ $user->profile_photo ? asset($user->profile_photo) : asset('assets/img/logo.png') }}"
                    alt="..."
                    class="avatar-img rounded-circle object-fit-contain"
                  />
                </div>
                <span class="profile-username">
                  <span class="op-7">Halo,</span>
                  <span class="fw-bold">{{ Auth::user()->company_name }}</span>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-user animated fadeIn">
                <div class="dropdown-user-scroll scrollbar-outer">
                  <li>
                    <div class="user-box">
                      <div class="avatar-lg">
                        <img
                        src="{{ $user->profile_photo ? asset($user->profile_photo) : asset('assets/img/logo.png') }}"
                        alt="image profile"
                        class="avatar-img rounded object-fit-contain"
                      />
                      </div>
                      <div class="u-text">
                        <h4>{{ Auth::user()->company_name }}</h4>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>

                    <a href="{{ route('distributor.profile.index') }}" class="dropdown-item">Data Akun</a>


                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                     Keluar
                 </a>

                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                 </form>

                  </li>
                </div>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
      <!-- End Navbar -->
    </div>
