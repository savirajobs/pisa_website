<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('post')
        }
    });

    $(document).ready(function() {
        $('#addDataPost, #editPostModal').on('hidden.bs.modal', function() {
            $('.error.text-danger').html(null);
            $('#addPostForm, #editPostForm').removeClass('was-validated');
            $('.invalid-feedback').html(null);
            $('#pdfPreview').html('');
            $('#pdfPreview').html(null);
            $('#pdfPreview2').html('');
        });

        $('#editPostModal').on('hidden.bs.modal', function() {
            $('#editPostForm')[0].reset();
            $('.error.text-danger').html(null);
            $('#editPostForm').removeClass('was-validated');
            $('.invalid-feedback').html(null);
            $('#pdfPreview').html('');
            $('#pdfPreview2').html('');
            $('#pdf-list').html('');
            //location.reload();
        });

        var table = $('#law').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.law.apis') }}",
                method: "GET"
            },
            columns: [

                {
                    data: 'post_title'
                },
                {
                    data: 'is_publish'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'name'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function resetForm(modalId) {
            $(modalId).find('form')[0].reset();
        }

        $('#addDataPost').on('show.bs.modal', function(event) {
            $("#addDataPost").modal();
            $('#pdfPreview').html(null);
            $('#addPostForm')[0].reset();
            $('#uploadPdf').val('');
            console.log('Modal is being shown');
        });

        $('#addPostForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.law.store') }}",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $('#law').DataTable().ajax.reload();

                    iziToast.success({
                        title: 'Success',
                        message: response.success,
                        position: 'topRight'
                    });

                    $('#addDataPost').modal('hide');
                    resetForm('#addDataPost');
                    $('#addPostForm')[0].reset();
                    $('#uploadPdf').val('');
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#insert_' + key + '_error').text(value[0]);
                    });
                }
            });
        });

        function handleFileUpload(inputElement, previewElementId) {
            const pdfPreview = document.getElementById(previewElementId);
            pdfPreview.innerHTML = '';

            const files = inputElement.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.classList.add('col-md-4', 'mb-3');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'bg-primary-subtle');

                    col.appendChild(img);
                    pdfPreview.appendChild(col);
                };

                reader.readAsDataURL(file);
            }
        }

        document.getElementById('uploadPdf').addEventListener('change', function() {
            handleFileUpload(this, 'pdfPreview');
        });

        document.getElementById('pdf').addEventListener('change', function() {
            handleFileUpload(this, 'pdfPreview2');
        });

        document.getElementById('uploadPdf').addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.type === 'application/pdf') {
                const fileURL = URL.createObjectURL(file);
                const pdfPreview = document.getElementById('pdfPreview');
                pdfPreview.src = fileURL;
                pdfPreview.style.display = 'block';
            }
        });

        document.getElementById('pdf').addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.type === 'application/pdf') {
                const fileURL = URL.createObjectURL(file);
                const pdfPreview = document.getElementById('pdfPreview2');
                pdfPreview.src = fileURL;
                pdfPreview.style.display = 'block';
            }
        });

        $('#addDataModal').on('hidden.bs.modal', function(event) {
            console.log('Modal has been hidden');
            resetForm('#addDataModal');
        });

        // Menampilkan modal dan mengisi data
        $(document).on('click', '.btn-edit', function() {
            var button = $(this); // Tombol yang diklik
            post_id = button.data('id'); // Ambil ID dari data-id tombol

            $.ajax({
                url: "{{ route('admin.law.edit') }}",
                type: 'GET',
                data: {
                    post_id: post_id
                },
                success: function(response) {

                    console.log(response);

                    $('#post_id').val(response.post_id);
                    $('#editpost_title').val(response.post_title);

                    // Atur nilai radio button di modal sesuai dengan nilai dari response
                    if (response.is_publish !== undefined) {
                        if (response.is_publish == 1) {
                            $('#is_publish_yes_edit').prop('checked',
                                true); // Pilih 'Yes' di modal
                        } else {
                            $('#is_publish_no_edit').prop('checked',
                                true); // Pilih 'No' di modal
                        }
                    } else {
                        // Jika tidak ada nilai yang dikirim dari server
                        $('#is_publish_yes_edit').prop('checked', false);
                        $('#is_publish_no_edit').prop('checked', false);
                    }

                    $.ajax({
                        url: "{{ route('admin.law.media') }}",
                        method: 'GET',
                        data: {
                            post_id: post_id,
                        },
                        success: function(getPdf) {
                            if (getPdf.length === 0) {
                                $('#pdf-list').append(
                                    '<p class="text-muted text-center">Tidak ada media law untuk ditampilkan.</p>'
                                );
                            } else {
                                $('#pdf-list').html('');
                                getPdf.forEach(pdf => {
                                    console.log(pdf);
                                    $('#pdf-list').append(`
											<div class="pdf-item col-md-4 mb-3" data-pdf-id="${pdf.media_id}">
												<div class="position-relative">
                                                    <embed src="/pdf/${pdf.file_name}" alt="Pdf" width="800px" height="500" />
													<button type="button" class="btn-close close-pdf-btn" aria-label="Close"></button>
												</div>
											</div>
										`);
                                });
                            }
                        },
                        dataType: 'json'
                    });
                    $('#editPostModal').modal('show');
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

        // CLOSE PHOTO = Menambahkan .remove-pdf pada div .photo-item agar dapat di hapus melalui submit
        $(document).on('click', '.close-pdf-btn', function() {
            let pdfItem = $(this).closest('.pdf-item');
            pdfItem.addClass('remove-pdf');
            pdfItem.find('img').remove();
            $(this).remove();
            pdfItem.attr('hidden', true);
        });

        $('#editPostForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let deletedPdf = [];

            //console.log(formData);

            // Mengecek data yang memiliki .remove-photo lalu mengambil photo-id
            $('.remove-pdf').each(function() {
                let pdfId = $(this).data('pdf-id');
                deletedPdf.push(pdfId);
            });

            formData.append('deleted_pdf', deletedPdf.join(','));

            $.ajax({
                url: "{{ route('admin.law.update') }}",
                method: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        // Reload DataTable setelah sukses update
                        $('#law').DataTable().ajax.reload();

                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });
                        $('#editPostModal').modal('hide'); // Tutup modal
                        resetForm('#editPostModal'); // Reset form
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

    $(document).on('click', '.btn-delete', function() {
        var post_id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, jalankan AJAX request untuk delete
                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('admin.law.destroy') }}",
                    data: {
                        post_id: post_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#law').DataTable().ajax
                            .reload(); // Reload DataTable

                        Swal.fire(
                            'Deleted!',
                            'Dasar Hukum has been deleted.',
                            'success'
                        );
                    },
                    error: function(xhr) {
                        var response = JSON.parse(xhr.responseText);
                        Swal.fire(
                            'Error!',
                            response.error ||
                            'An unexpected error occurred.',
                            'error'
                        );
                    }
                });
                //     }
                // });
            };
        });
    });
</script>
