<script>
    // GLOBAL SETUP
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $(document).ready(function() {
        $('#upload-feedback').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('frontend.feedback.store') }}",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {

                    // Show success toast notification
                    iziToast.success({
                        title: 'Success',
                        message: response.success,
                        position: 'topRight'
                    });

                    // Hide the modal and reset the form                   
                    resetForm('#upload-feedback'); // Ensure this resets the correct form
                    $('#upload-feedback')[0].reset();
                    $('#upload-feedback').val('');
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

    });
</script>
