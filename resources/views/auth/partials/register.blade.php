<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <a href="#" class="prev-btn d-none">
                        <i class="fas fa-chevron-left me-2"></i>
                    </a>
                    <h5 class="modal-title fw-bold ms-2" id="registerModalLabel">Daftar</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="progress mb-4" style="height: 10px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" id="progressBar" style="width: 25%;"></div>
                </div>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="multiStepForm">
                    @csrf

                    <!-- Step 1 -->
                    <div id="step-1" class="step">
                        <h5 class="text-center mb-4 fw-bold">Step 1: Account Details</h5>
                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control rounded-pill" name="email" placeholder="Enter your email" required>
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control rounded-pill" name="password" placeholder="Enter your password" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" type="password" class="form-control rounded-pill" name="password_confirmation" placeholder="Confirm your password" required>
                        </div>

                        <div class="d-grid">
                            <button type="button" class="btn btn-primary rounded-pill next-btn">Next</button>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div id="step-2" class="step d-none">
                        <h5 class="text-center mb-4 fw-bold">Step 2: Contact Information</h5>
                        <!-- Phone Number -->
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                            <input id="phone" type="text" class="form-control rounded-pill" name="phone" placeholder="Enter your phone number" required>
                        </div>

                        <!-- Address -->
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <textarea id="address" class="form-control rounded" name="address" placeholder="Enter your address" required></textarea>
                        </div>

                        <!-- Company Name -->
                        <div class="form-group mb-3">
                            <label for="company_name" class="form-label">{{ __('Company Name') }}</label>
                            <input id="company_name" type="text" class="form-control rounded-pill" name="company_name" placeholder="Enter your company name" required>
                        </div>

                        <div class="d-grid">
                            <button type="button" class="btn btn-primary rounded-pill next-btn">Next</button>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div id="step-3" class="step d-none">
                        <h5 class="text-center mb-4 fw-bold">Step 3: PIC Information</h5>
                        <!-- Name (PIC) -->
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">{{ __('Name (PIC)') }}</label>
                            <input id="name" type="text" class="form-control rounded-pill" name="name" placeholder="Enter PIC's name" required>
                        </div>

                        <!-- PIC's Phone Number -->
                        <div class="form-group mb-3">
                            <label for="pic_phone" class="form-label">{{ __("PIC's Phone Number") }}</label>
                            <input id="pic_phone" type="text" class="form-control rounded-pill" name="pic_phone" placeholder="Enter PIC's phone number" required>
                        </div>

                        <div class="d-grid">
                            <button type="button" class="btn btn-primary rounded-pill next-btn">Next</button>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div id="step-4" class="step d-none">
                        <h5 class="text-center mb-4 fw-bold">Step 4: Upload Documents</h5>
                        <!-- Upload Deed of Establishment -->
                        <div class="form-group mb-3">
                            <label for="deed_of_establishment" class="form-label">{{ __('Upload Deed of Establishment (Akta)') }}</label>
                            <input id="deed_of_establishment" type="file" class="form-control rounded-pill" name="deed_of_establishment" required>
                        </div>

                        <!-- Upload NIB Document -->
                        <div class="form-group mb-3">
                            <label for="nib_document" class="form-label">{{ __('Upload NIB Document') }}</label>
                            <input id="nib_document" type="file" class="form-control rounded-pill" name="nib_document" required>
                        </div>

                        <div class="d-grid">
                            <!-- Tombol Finish -->
                            <button type="submit" id="finishBtn" class="btn btn-success rounded-pill d-none">Finish</button>
                        </div>
                    </div>


                    <!-- Step 5 -->
                    <div id="step-5" class="step d-none">
                        <div class="text-center">
                            <!-- Pesan Berhasil -->
                            <div id="successMessage" class="d-none">
                                <h5 class="fw-bold mb-3 text-success">Registrasi Berhasil</h5>
                                <p id="successText" class="mb-3">Akun Anda berhasil didaftarkan. Silakan tunggu konfirmasi dari admin.</p>
                                <button type="button" class="btn btn-primary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                            </div>
                            <!-- Pesan Gagal -->
                            <div id="errorMessage" class="d-none">
                                <h5 class="fw-bold mb-3 text-danger">Registrasi Gagal</h5>
                                <p id="errorText" class="mb-3">Ada kesalahan saat pendaftaran. Silakan coba lagi.</p>
                                <button type="button" class="btn btn-danger rounded-pill" id="refreshBtn">Kembali</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>




<script>
   document.addEventListener('DOMContentLoaded', function () {
    const steps = document.querySelectorAll('.step');
    const progressBar = document.getElementById('progressBar');
    const prevBtn = document.querySelector('.prev-btn');
    const form = document.getElementById('multiStepForm');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    const successText = document.getElementById('successText');
    const errorText = document.getElementById('errorText');
    const finishBtn = document.getElementById('finishBtn');
    const refreshBtn = document.getElementById('refreshBtn');


    let currentStep = 0;
    let isFinalStep = false; // Flag untuk step terakhir
    let isError = false;     // Flag untuk menandai error di Step 5


        // Fungsi validasi input kosong
    function validateInputs(inputs) {
    let isValid = true;
        inputs.forEach(input => {
            if (input.value.trim() === '' || input.files?.length === 0) {
                isValid = false;
            }
        });
        return isValid;
    }


        // Observasi perubahan input di Step 4
        const step4Inputs = document.querySelectorAll('#step-4 input');
    step4Inputs.forEach(input => {
        input.addEventListener('input', () => {
            if (validateInputs(step4Inputs)) {
                finishBtn.classList.remove('d-none'); // Tampilkan tombol Finish
            } else {
                finishBtn.classList.add('d-none'); // Sembunyikan tombol Finish
            }
        });
    });

    
    // Tombol "Next"
    document.querySelectorAll('.next-btn').forEach((btn) => {
        btn.addEventListener('click', function () {
            steps[currentStep].classList.add('d-none');
            currentStep += 1;
            steps[currentStep].classList.remove('d-none');
            progressBar.style.width = `${((currentStep + 1) / steps.length) * 100}%`;
            updatePrevBtnVisibility();
        });
    });

    // Tombol "Prev"
    prevBtn.addEventListener('click', function () {
        steps[currentStep].classList.add('d-none');
        currentStep -= 1;
        steps[currentStep].classList.remove('d-none');
        progressBar.style.width = `${((currentStep + 1) / steps.length) * 100}%`;
        updatePrevBtnVisibility();
    });

    // Event Listener untuk Submit Form
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            // Tampilkan Step 5 untuk sukses
            steps[currentStep].classList.add('d-none');
            currentStep = 4; // Pindah ke Step 5
            steps[currentStep].classList.remove('d-none');
            progressBar.style.width = "100%";

            successText.textContent = data.message;
            successMessage.classList.remove('d-none');
            errorMessage.classList.add('d-none');

            isFinalStep = true;
            isError = false; // Tidak ada error
            updatePrevBtnVisibility();
        })
        .catch(error => {
            // Tampilkan Step 5 untuk gagal
            steps[currentStep].classList.add('d-none');
            currentStep = 4; // Pindah ke Step 5
            steps[currentStep].classList.remove('d-none');
            progressBar.style.width = "100%";

            let errorMessages = "";
            for (let key in error.errors) {
                errorMessages += `${error.errors[key][0]}\n`;
            }
            errorText.textContent = errorMessages || "Terjadi kesalahan saat pendaftaran.";
            errorMessage.classList.remove('d-none');
            successMessage.classList.add('d-none');

            isFinalStep = true;
            isError = true; // Ada error
            updatePrevBtnVisibility();
        });
    });

    // Fungsi visibilitas tombol "Prev"
    function updatePrevBtnVisibility() {
        if (currentStep === 0 || (isFinalStep && !isError)) { 
            prevBtn.classList.add('d-none'); // Sembunyikan tombol Prev di Step 5 berhasil
        } else {
            prevBtn.classList.remove('d-none'); // Tampilkan tombol Prev jika ada error
        }
    }


    // Tambahkan event listener untuk refresh halaman
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function () {
            location.reload(); // Refresh halaman
        });
    }

});

</script>

