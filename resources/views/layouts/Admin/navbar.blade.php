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

              use App\Models\Message;
              use App\Models\Ticketing;
              use App\Models\User;
              use App\Models\Quotations;
              use App\Models\QuotationNegotiation;
              use App\Models\PurchaseOrders;
              use App\Models\ProformaInvoicePaymentProof;


              // Fetch notifications
              $unreadQuotations = Quotations::where('status', 'pending')
              ->where('is_viewed_admin', 0) // Only fetch where both conditions are true
              ->orderBy('created_at', 'desc')
                  ->get();
                
                  $unreadQuotationClose = Quotations::where('status', 'close')
                  ->Where('is_viewed_admin', 0)
                  ->orderBy('created_at', 'desc')
                  ->get();

              $unreadMessagesTicketing = Ticketing::where(function ($query) {
                  $query->where('is_viewed_admin', 0)
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('status', 'Batal')
                                    ->where('is_viewed_admin', 0);
                        });
              })->orderBy('created_at', 'desc')->get();

              $unreadMessages = Message::where('status', 0)->orderBy('created_at', 'desc')->get();
              $unreadMessagesDistributor = User::where('type', 2)->where('is_verified', 0)->orderBy('created_at', 'desc')->get();

              $unreadNegotiations = QuotationNegotiation::where('is_viewed_admin', 0)
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadMessagesPO = PurchaseOrders::where('is_viewed_admin', 0)
              ->where('status', 'pending')
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadMessagesPayment = ProformaInvoicePaymentProof::where('is_viewed_admin', 0)
              ->orderBy('created_at', 'desc')
              ->get();

              $unreadCount = $unreadMessages->count() 
              + $unreadMessagesTicketing->count() 
              + $unreadMessagesDistributor->count() 
              + $unreadQuotations->count()
              + $unreadNegotiations->count()
              + $unreadMessagesPO->count()
              + $unreadMessagesPayment->count()
              + $unreadQuotationClose->count();

              ?>
              

              <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-bell">
                          @if ($unreadCount > 0)
                              <span class="badge badge-danger">{{ $unreadCount }}</span>
                          @endif
                      </i>
                  </a>
                  <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                      <li>
                          <div class="dropdown-title d-flex justify-content-between align-items-center">
                              Notifikasi
                              <a href="{{ route('messages.index') }}" class="small">Tandai semua terbaca</a>
                          </div>
                      </li>
                      <li>
                          <div class="message-notif-scroll scrollbar-outer">
                              <div class="notif-center">
                                  {{-- General Messages --}}
                                  @foreach ($unreadMessages as $message)
                                      <a href="{{ route('messages.show', $message->id) }}" class="d-flex align-items-start p-3 mb-2 bg-white rounded shadow-sm text-decoration-none hover-shadow">
                                          <div class="me-3 text-center">
                                              <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                  <i class="fa fa-envelope fa-lg"></i>
                                              </div>
                                              <small class="text-muted d-block mt-1">{{ $message->created_at->format('H:i') }}</small>
                                          </div>
                                          <div class="flex-grow-1">
                                              <div class="d-flex justify-content-between align-items-center">
                                                  <span class="fw-bold text-dark">{{ $message->name }}</span>
                                                  <span class="small text-muted">{{ $message->created_at->diffForHumans() }}</span>
                                              </div>
                                              <p class="text-dark mb-0">
                                                  {{ Str::limit($message->subject, 40) }}
                                              </p>
                                          </div>
                                      </a>
                                  @endforeach

                                  {{-- Ticketing Notifications --}}
                                  @foreach ($unreadMessagesTicketing as $ticket)
                                      <a href="{{ route('admin.ticketing.index') }}" class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                                          <div class="me-3 text-center">
                                              <div class="rounded-circle bg-{{ $ticket->status == 'Batal' ? 'danger' : 'success' }} text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                  <i class="fa fa-ticket-alt fa-lg"></i>
                                              </div>
                                              <small class="text-muted d-block mt-1">{{ $ticket->created_at->format('H:i') }}</small>
                                          </div>
                                          <div class="flex-grow-1">
                                              <div class="d-flex justify-content-between align-items-center">
                                                  <span class="fw-bold text-dark">{{ $ticket->status == 'Batal' ? 'Tiket Dibatalkan' : 'Tiket Baru' }}</span>
                                                  <span class="badge bg-primary text-white">Tiketing</span>
                                              </div>
                                              <p class="text-dark mb-2">
                                                  <strong>{{ $ticket->user->company_name }}</strong> 
                                                  {{ $ticket->status == 'Batal' ? 'membatalkan tiket layanan:' : 'mengirimkan tiket baru dengan layanan:' }}
                                                  <strong>{{ $ticket->service_type }}</strong>.
                                              </p>
                                          </div>
                                      </a>
                                  @endforeach

                                  {{-- Distributor Verification --}}
                                  @foreach ($unreadMessagesDistributor as $distributor)
                                      <a href="{{ route('distributors.show', $distributor->id) }}" class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                                          <div class="me-3 text-center">
                                              <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                  <i class="fa fa-building fa-lg"></i>
                                              </div>
                                              <small class="text-muted d-block mt-1">{{ $distributor->created_at->format('H:i') }}</small>
                                          </div>
                                          <div class="flex-grow-1">
                                              <div class="d-flex justify-content-between align-items-center">
                                                  <span class="fw-bold text-dark">Verifikasi Distributor</span>
                                                  <span class="badge bg-warning text-dark">Distributor</span>
                                              </div>
                                              <p class="text-dark mb-2">
                                                  Perusahaan <strong>{{ $distributor->company_name }}</strong>, dengan PIC <strong>{{ $distributor->name }}</strong>, sedang menunggu verifikasi dari admin.
                                              </p>
                                          </div>
                                      </a>
                                  @endforeach

                                  {{-- Quotation Notifications --}}
                                  @foreach ($unreadQuotations as $quotation)
                                      <a href="{{ route('admin.quotations.show', $quotation->id) }}" class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                                          <div class="me-3 text-center">
                                              <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                  <i class="fa fa-file-alt fa-lg"></i>
                                              </div>
                                              <small class="text-muted d-block mt-1">{{ $quotation->created_at->format('H:i') }}</small>
                                          </div>
                                          <div class="flex-grow-1">
                                              <div class="d-flex justify-content-between align-items-center">
                                                  <span class="fw-bold text-dark">Quotation Baru</span>
                                                  <span class="badge bg-primary text-white">Quotation</span>
                                              </div>
                                              <p class="text-dark mb-2">
                                                  Permintaan Quotation untuk <strong>{{ $quotation->recipient_company }}</strong> sedang menunggu tanggapan admin.
                                              </p>
                                          </div>
                                      </a>
                                  @endforeach

                                  <!-- Negotiation Notifications -->
                                    @foreach ($unreadNegotiations as $negotiation)
                                    <a href="{{ route('admin.quotations.negotiation.show', $negotiation->id) }}" class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                                        <div class="me-3 text-center">
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fa fa-handshake fa-lg"></i>
                                            </div>
                                            <small class="text-muted d-block mt-1">{{ $negotiation->created_at->format('H:i') }}</small>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-dark">Negosiasi Quotation</span>
                                                <span class="badge bg-secondary text-white">Negosiasi</span>
                                            </div>
                                            <p class="text-dark mb-2">
                                                Quotation <strong>#{{ $negotiation->quotation->quotation_number }}</strong> memiliki permintaan negosiasi dari distributor.
                                            </p>
                                        </div>
                                    </a>
                                    @endforeach

                                    <!-- Purchase Order Notifications -->
                                    @foreach ($unreadMessagesPO as $po)
                                    <a href="{{ route('admin.purchaseorder.index', $po->id) }}" class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                                        <div class="me-3 text-center">
                                            <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fa fa-file-alt fa-lg"></i>
                                            </div>
                                            <small class="text-muted d-block mt-1">{{ $po->created_at->format('H:i') }}</small>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-dark">Pengajuan PO</span>
                                                <span class="badge bg-info text-white">PO</span>
                                            </div>
                                            <p class="text-dark mb-2">
                                                <strong>{{ $po->user->company_name }}</strong> mengajukan purchase order dengan nomor <strong>#{{ $po->po_number }}</strong>.
                                            </p>
                                        </div>
                                    </a>
                                    @endforeach

                                    <!-- Payment Proof Notifications -->
                                    @foreach ($unreadMessagesPayment as $payment)
                                    <a href="{{ route('admin.proformainvoice.index', $payment->proformaInvoice->quotation_id) }}" 
                                      class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                                          <div class="me-3 text-center">
                                              <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                  <i class="fa fa-money-check-alt fa-lg"></i>
                                              </div>
                                              <small class="text-muted d-block mt-1">{{ $payment->created_at->format('H:i') }}</small>
                                          </div>
                                          <div class="flex-grow-1">
                                              <div class="d-flex justify-content-between align-items-center">
                                                  <span class="fw-bold text-dark">Bukti Pembayaran</span>
                                                  <span class="badge bg-warning text-dark">{{ ucfirst($payment->payment_type) }}</span>
                                              </div>
                                              <p class="text-dark mb-2">
                                                  <strong>{{ $payment->proformaInvoice->pi_number ?? 'Unknown' }}</strong><br>
                                                  <strong>Perusahaan:</strong> {{ $payment->proformaInvoice->purchaseOrder->user->company_name ?? 'Tidak diketahui' }}<br>
                                                  <strong>Catatan:</strong> <em>{{ $payment->remarks ?? 'Tidak ada catatan.' }}</em>
                                              </p>
                                          </div>
                                      </a>
                                  @endforeach


                                  @foreach ($unreadQuotationClose as $quotation)
                                    <a href="{{ route('admin.quotations.show', $quotation->id) }}" 
                                      class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                                        <div class="me-3 text-center">
                                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fa fa-check-circle fa-lg"></i>
                                            </div>
                                            <small class="text-muted d-block mt-1">{{ $quotation->created_at->format('H:i') }}</small>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-dark">Quotation Selesai</span>
                                                <span class="badge bg-success text-white">Closed</span>
                                            </div>
                                            <p class="text-dark mb-2">
                                                <strong>Nomor Quotation:</strong> {{ $quotation->quotation_number }}<br>
                                                <strong>Perusahaan:</strong> {{ $quotation->recipient_company ?? 'Tidak diketahui' }}<br>
                                                <em>Quotation ini telah selesai. Klik untuk melihat detailnya.</em>
                                            </p>
                                        </div>
                                    </a>
                                @endforeach






                                  {{-- No Notifications --}}
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
                    src="{{ asset('assets/img/logo.png') }}"
                    alt="..."
                    class="avatar-img rounded-circle object-fit-contain"
                  />
                </div>
                <span class="profile-username">
                  <span class="op-7">Halo,</span>
                  <span class="fw-bold">{{ Auth::user()->name }}</span>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-user animated fadeIn">
                <div class="dropdown-user-scroll scrollbar-outer">
                  <li>
                    <div class="user-box">
                      <div class="avatar-lg">
                        <img
                          src="{{ asset('assets/img/logo.png') }}"
                          alt="image profile"
                          class="avatar-img rounded object-fit-contain"
                        />
                      </div>
                      <div class="u-text">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                      </div>
                    </div>
                  </li>

                
                  <li>
                    <div class="dropdown-divider"></div>

                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                      Ubah Password
                  </button>


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






    <!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <form id="changePasswordForm" action="{{ route('admin.changePassword') }}" method="POST">
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <!-- Current Password -->
                  <div class="mb-3">
                      <label for="current_password" class="form-label">Password Saat Ini</label>
                      <input type="password" name="current_password" id="current_password" class="form-control" required>
                  </div>

                  <!-- New Password -->
                  <div class="mb-3">
                      <label for="new_password" class="form-label">Password Baru</label>
                      <input type="password" name="new_password" id="new_password" class="form-control" required>
                  </div>

                  <!-- Confirm New Password -->
                  <div class="mb-3">
                      <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                      <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
          </form>
      </div>
  </div>
</div>
