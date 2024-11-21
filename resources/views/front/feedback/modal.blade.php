<!-- Modal -->
<div class="modal top fade" id="otp_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-mdb-backdrop="true" data-mdb-keyboard="true">
    <div class="modal-dialog modal-dialog-centered text-center d-flex justify-content-center">
        <div class="modal-content w-75">
            <div class="modal-body p-4">
                <img src="{{ asset('/asset/img/pisa-logo.png') }}" alt="avatar"
                    class="rounded-circle position-absolute top-0 start-50 translate-middle h-50" />
                <form id="insertOTP" method="POST">
                    @csrf
                    <input type="hidden" name="otp_phone" id="otp_phone" class="form-control otp_phone">
                    <input type="hidden" name="otp_id" id="otp_id" class="form-control otp_id">
                    <input type='hidden' name="otp_sender" id="otp_sender" class="form-control otp_sender"
                    <div>
                        <h5 class="pt-5 my-3">Konfirmasi OTP</h5>

                        <!-- password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="otp" id="otp_value" name="otp_value" class="form-control otp_value" />
                            <label class="form-label" for="otp">OTP</label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary"
                            id="sendOTP">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
