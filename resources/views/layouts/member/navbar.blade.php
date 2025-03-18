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

// Fetch unread messages for the logged-in member
$unreadMessagesTicketing = Ticketing::where('is_viewed_member', 0)
    ->where('user_id', Auth::id()) // Filter berdasarkan user_id member yang sedang login
    ->orderBy('created_at', 'desc')
    ->get();

$user = Auth::user();

$unreadCount = $unreadMessagesTicketing->count();
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
                    @foreach ($unreadMessagesTicketing as $ticket)
                        <a href="{{ route('member.ticketing.show', $ticket->id) }}" 
                           class="d-flex align-items-start p-3 mb-2 bg-light rounded shadow-sm text-decoration-none hover-shadow">
                            <!-- Icon and Time -->
                            <div class="me-3 text-center">
                                <div class="d-flex align-items-center justify-content-center rounded-circle 
                                    @if($ticket->service_type === 'Permintaan Data' && $ticket->status === 'Close')
                                        bg-info
                                    @else
                                        bg-success
                                    @endif
                                    text-white" style="width: 40px; height: 40px;">
                                    <i class="fa fa-ticket-alt fa-lg"></i>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    {{ $ticket->created_at->format('H:i') }}
                                </small>
                            </div>

                            <!-- Notification Content -->
                            <div class="flex-grow-1">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">
                                        @if($ticket->service_type === 'Permintaan Data' && $ticket->status === 'Close')
                                            Permintaan Data Dikirim
                                        @else
                                            Status Tiket Anda
                                        @endif
                                    </span>
                                    <span class="badge bg-primary text-white">Tiketing</span>
                                </div>

                                <!-- Service and Technician Info -->
                                <p class="text-dark mb-2">
                                    Layanan: <strong>{{ $ticket->service_type }}</strong>
                                </p>

                                <!-- Status Information -->
                                <p class="text-secondary mb-0">
                                    @if($ticket->service_type === 'Permintaan Data' && $ticket->status === 'Close')
                                        Data permintaan Anda telah dikirim.
                                    @else
                                        Status saat ini: <strong>{{ ucfirst($ticket->status) }}</strong>
                                        @if($ticket->status == 'Progress')
                                            <span>ditangani oleh: {{ $ticket->technician }}</span>
                                        @endif
                                    @endif
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
                    <a href="{{ route('member.profile.index') }}" class="dropdown-item">Data Akun</a>

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
