<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('post')
        }
    });
    // Start of Summernote setting
    $(document).ready(function() {
        $('#editDataModal').on('hidden.bs.modal', function() {
            $('.error.text-danger').html(null);
            $('.invalid-feedback').html(null);
            $('#editDataModal').modal('hide');
        });

        var table = $('#consultation').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.feedback.consultation') }}",
                method: "GET"
            },
            columns: [

                {
                    data: 'feedback_title',
                    render: function(data, type, row) {
                        // Contoh kondisi untuk menampilkan "new"
                        if (row.is_new) { // Misalnya jika ada field `is_new` dari server
                            return '<span class="badge bg-primary" style="float:left; margin-right:5px;">New</span> ' +
                                data;
                        }
                        return data; // Jika bukan "new", tampilkan data biasa
                    }
                },
                {
                    data: 'sender_name'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'reply_status'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        var table = $('#complaint').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.feedback.complaint') }}",
                method: "GET"
            },
            columns: [

                {
                    data: 'feedback_title',
                    render: function(data, type, row) {
                        // Contoh kondisi untuk menampilkan "new"
                        if (row.is_new) { // Misalnya jika ada field `is_new` dari server
                            return '<span class="badge bg-primary" style="float:left; margin-right:5px;">New</span> ' +
                                data;
                        }
                        return data; // Jika bukan "new", tampilkan data biasa
                    }
                },
                {
                    data: 'sender_name'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'reply_status'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#replyFeedback').on('show.bs.modal', function(event) {
            console.log('Modal is being shown');
        });

        $('#replyFeedback').on('hidden.bs.modal', function(event) {
            console.log('Modal has been hidden');
        });

        var feedback_id;

        // Menampilkan modal dan mengisi data
        $(document).on('click', '.reply-btn', function() {
            var button = $(this); // Tombol yang diklik
            feedback_id = button.data('id'); // Ambil ID dari data-id tombol
            console.log('Feedback id:', feedback_id);

            $.ajax({
                url: "{{ route('admin.feedback.edit') }}",
                type: 'GET',
                data: {
                    feedback_id: feedback_id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        console.log(response.data)
                        $('#feedback_id').val(response.data.feedback_id);
                        $('#replyTitle').val(response.data.feedback_title);
                        $('#replySender').val(response.data.sender_name);
                        $('#replyEmail').val(response.data.email);
                        $('#replyPhone').val(response.data.phone);
                        $('#replyFeedbackDesc').val(response.data.feedback_desc);
                        $('.verified-email').val(response.data.verification_status);

                        // Set nilai spam feedback
                        if (response.data.is_spam !== undefined) {
                            if (response.data.is_spam == 1) {
                                $('#is_spam_yes').prop('checked',
                                    true); // Pilih 'Yes' di modal
                            } else {
                                $('#is_spam_no').prop('checked',
                                    true); // Pilih 'No' di modal
                            }
                        } else {
                            // Jika tidak ada nilai yang dikirim dari server
                            $('#is_spam_yes').prop('checked', false);
                            $('#is_spam_no').prop('checked', false);
                        }

                        // Set nilai duplikasi feedback
                        /*if (response.data.is_duplicate !== undefined) {
                            if (response.data.is_duplicate == 1) {
                                $('#is_duplicate_yes').prop('checked',
                                    true); // Pilih 'Yes' di modal
                            } else {
                                $('#is_duplicate_no').prop('checked',
                                    true); // Pilih 'No' di modal
                            }
                        } else {
                            // Jika tidak ada nilai yang dikirim dari server
                            $('#is_duplicate_yes').prop('checked', false);
                            $('#is_duplicate_no').prop('checked', false);
                        }*/

                        $.ajax({
                            url: "{{ route('admin.feedback.getReply') }}",
                            method: 'GET',
                            data: {
                                feedback_id: feedback_id
                            },
                            success: function(reply) {
                                console.log(reply.reply_id);
                                $('#reply-feedback').html('');
                                if (reply.reply_id) {
                                    $('#reply-feedback').append(`
										<div class="mb-3">
											<label for="reply" class="form-label">Reply</label>
											<textarea class="form-control" id="reply" rows="4" name="reply" disabled>${reply.reply_desc}</textarea>
										</div>
								 	`);
                                } else {
                                    $('#reply-feedback').append(`
										<div class="mb-3">
											<label for="reply" class="form-label">Reply</label>
											<textarea class="form-control" id="reply" rows="4" name="reply" placeholder="Please type here to reply"></textarea>
										</div>
								 	`);
                                }
                            },
                            dataType: 'json'
                        });
                    }

                    $('#replyFeedback').modal('show');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    iziToast.error({
                        title: 'Error',
                        message: 'An error occurred while fetching post data.',
                        position: 'topRight'
                    });
                }
            });
        });

        $('#replyForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.feedback.update') }}",
                method: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.status === 'success') {
                        $('#consultation').DataTable().ajax.reload();
                        $('#complaint').DataTable().ajax.reload();

                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });
                        $('#replyFeedback').modal('hide'); // Tutup modal
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    var response = JSON.parse(xhr.responseText);

                    if (xhr.status === 422) {
                        var errors = response.errors;
                        $.each(errors, function(field, messages) {
                            iziToast.error({
                                title: 'Validation Error',
                                message: messages.join(', '),
                                position: 'topRight'
                            });
                        });
                    } else {
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
