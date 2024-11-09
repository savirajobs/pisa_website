<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    document.getElementById('reload_captcha').addEventListener('click', function() {
        let captchaImage = document.getElementById('captcha-image');
        captchaImage.src = '/captcha-image?' + new Date()
            .getTime(); // Menambahkan timestamp untuk menghindari cache
    });


    $(document).ready(function() {
        $('#upload_feedback').on('submit', function(e) {
            let form = $('#upload_feedback')[0]
            let data = new FormData(form)
            e.preventDefault();

            $.ajax({
                url: "{{ route('frontend.feedback.store') }}",
                method: 'POST',
                data: data,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {

                    // Pastikan modal sudah ada, kemudian tampilkan
                    $('#otp_modal').modal('show');
                    $('#otp_phone').val(response.otp_phone);

                    // Hide the modal and reset the form          

                    $('#upload_feedback')[0].reset();
                    $('#upload_feedback').val('');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    var response = JSON.parse(xhr.responseText);

                    // Check if it's a validation error (status code 422)
                    if (xhr.status === 422) {
                        var errors = response.errors;

                        // Display validation errors using iziToast
                        $.each(errors, function(field, messages) {
                            iziToast.error({
                                title: 'Validation Error',
                                message: messages.join(', '),
                                position: 'topRight'
                            });
                        });
                    } else {
                        // Show a generic error message for other errors
                        iziToast.error({
                            title: 'Error',
                            message: response.error ||
                                'An unexpected error occurred.',
                            position: 'topRight'
                        });
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#insertOTP').on('submit', function(e) {
                e.preventDefault();

                // Ambil nilai dari input
                var otpPhone = $('.otp_phone').val();
                var otpValue = $('.otp_value').val();

                console.log('otp phone : ', otpPhone, ' otp value : ', otpValue);

                $.ajax({
                    url: "{{ route('frontend.feedback.otp') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}", // Tambahkan CSRF token
                        otp_phone: otpPhone,
                        otp_value: otpValue
                    },
                    success: function(response) {
                        // Sembunyikan modal dan reset form
                        $('#otp_modal').modal('hide');
                        resetForm('#otp_modal');

                        // Tampilkan notifikasi sukses
                        iziToast.success({
                            title: 'Success',
                            message: response.success,
                            position: 'topRight'
                        });

                        $('#insertOTP')[0].reset();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        var response = JSON.parse(xhr.responseText);

                        // Jika error 422 (validasi gagal)
                        if (xhr.status === 422) {
                            var errors = response.errors;

                            // Tampilkan pesan error validasi menggunakan iziToast
                            $.each(errors, function(field, messages) {
                                iziToast.error({
                                    title: 'Validation Error',
                                    message: messages.join(', '),
                                    position: 'topRight'
                                });
                            });
                        } else {
                            // Tampilkan pesan error umum untuk error lainnya
                            iziToast.error({
                                title: 'Error',
                                message: response.error ||
                                    'An unexpected error occurred.',
                                position: 'topRight'
                            });
                        }
                    }
                });
            });
        });

        function resetForm(modalId) {
            $(modalId).find('form')[0].reset();
        }

    });
</script>
