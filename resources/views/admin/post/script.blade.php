<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('post')
        }
    });
    // Start of Summernote setting
    $(document).ready(function() {
        $('#editor, #editpost_desc').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['para', ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull']]
                ['height', ['height']]
            ],
        });

        $('#addDataPost, #editPostModal').on('hidden.bs.modal', function() {
            $('.error.text-danger').html(null);
            $('#addPostForm, #editPostForm').removeClass('was-validated');
            $('.invalid-feedback').html(null);
            $('#imagePreview').html('');
            $('#imagePreview2').html('');
            $('.show_image').html('');
            $('#editor, #editpost_desc').summernote('reset');
        });

        $('#editPostModal').on('hidden.bs.modal', function() {
            $('#editPostForm')[0].reset();
            $('.error.text-danger').html(null);
            $('#editPostForm').removeClass('was-validated');
            $('.invalid-feedback').html(null);
            $('#imagePreview2').html('');
            $('.show_image').html('');
            //location.reload();
        });
        // End of Summernote setting

        document.getElementById('closeButton').addEventListener('click', function() {
            document.getElementById('addPostForm').reset();
        });

        var table = $('#posted').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.post.apis') }}",
                method: "GET"
            },
            columns: [

                {
                    data: 'post_title'
                },
                /*{
                    data: 'slug'
                },*/
                {
                    data: 'type_desc'
                },
                {
                    data: 'category_name'
                },
                {
                    data: 'is_publish'
                },
                {
                    data: 'event_at'
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

        var table = $('#post_draft').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.post.postdraft') }}",
                method: "GET"
            },
            columns: [

                {
                    data: 'post_title'
                },
                /*{
                    data: 'slug'
                },*/
                {
                    data: 'type_desc'
                },
                {
                    data: 'category_name'
                },
                {
                    data: 'is_publish'
                },
                {
                    data: 'event_at'
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

        var table = $('#post_all').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.post.postall') }}",
                method: "GET"
            },
            columns: [

                {
                    data: 'post_title'
                },
                /*{
                    data: 'slug'
                },*/
                {
                    data: 'type_desc'
                },
                {
                    data: 'category_name'
                },
                {
                    data: 'is_publish'
                },
                {
                    data: 'event_at'
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

        $('#addDataModal').on('show.bs.modal', function(event) {
            console.log('Modal is being shown');
        });

        $('#addPostForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.post.store') }}",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $('#posted').DataTable().ajax.reload();
                    $('#post_draft').DataTable().ajax.reload();
                    $('#post_all').DataTable().ajax.reload();

                    iziToast.success({
                        title: 'Success',
                        message: response.success,
                        position: 'topRight'
                    });

                    $('#addDataPost').modal('hide');
                    resetForm('#addDataPost');
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

        function handleFileUpload(inputElement, previewElementId) {
            const imagePreview = document.getElementById(previewElementId);
            imagePreview.innerHTML = '';

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
                    imagePreview.appendChild(col);
                };

                reader.readAsDataURL(file);
            }
        }

        document.getElementById('uploadImages').addEventListener('change', function() {
            handleFileUpload(this, 'imagePreview');
        });

        document.getElementById('photos').addEventListener('change', function() {
            handleFileUpload(this, 'imagePreview2');
        });

        $('#addDataModal').on('hidden.bs.modal', function(event) {
            console.log('Modal has been hidden');
            resetForm('#addDataModal');
        });

        // Menampilkan modal dan mengisi data
        $(document).on('click', '.edit-btn', function() {
            var button = $(this); // Tombol yang diklik
            post_id = button.data('id'); // Ambil ID dari data-id tombol

            $.ajax({
                url: "{{ route('admin.post.edit') }}",
                type: 'GET',
                data: {
                    post_id: post_id
                },
                success: function(response) {

                    console.log(response);

                    $('#post_id').val(response.post_id);
                    $('#editpost_title').val(response.post_title);
                    $('#editslug').val(response.slug);
                    $('#old_slug').val(response.slug);
                    $('#editpost_type').val(response.post_type);
                    $('#editcategory_id').val(response.category_id);
                    $('#editpost_desc').summernote('code', response.post_desc);
                    $('#editnotes').val(response.notes);

                    if (response.event_at) {
                        $('#editevent_date').val(moment(response.event_at,
                            "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD"));
                    }

                    /*if (response.upcoming_date) {
                        $('#editupcoming_date').val(moment(response.upcoming_date,
                            "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD"));
                    }*/

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
                        url: "{{ route('admin.post.media') }}",
                        method: 'GET',
                        data: {
                            post_id: post_id,
                        },
                        success: function(photos) {
                            if (photos.length === 0) {
                                $('#photo-list').append(
                                    '<p class="text-muted text-center">Tidak ada foto untuk ditampilkan.</p>'
                                );
                            } else {
                                $('#photo-list').html('');
                                photos.forEach(photo => {
                                    console.log(photo);
                                    $('#photo-list').append(`
											<div class="photo-item col-md-4 mb-3" data-photo-id="${photo.media_id}">
												<div class="position-relative">
													<img src="/images/${photo.file_name}" alt="Photo" class="img-thumbnail bg-success-subtle">
													<button type="button" class="btn-close close-photo-btn" aria-label="Close"></button>
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

        // CLOSE PHOTO = Menambahkan .remove-photo pada div .photo-item agar dapat di hapus melalui submit
        $(document).on('click', '.close-photo-btn', function() {
            let photoItem = $(this).closest('.photo-item');
            photoItem.addClass('remove-photo');
            photoItem.find('img').remove();
            $(this).remove();
            photoItem.attr('hidden', true);
        });

        $('#editPostForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let deletedPhotos = [];

            //console.log(formData);

            // Mengecek data yang memiliki .remove-photo lalu mengambil photo-id
            $('.remove-photo').each(function() {
                let photoId = $(this).data('photo-id');
                deletedPhotos.push(photoId);
            });

            formData.append('deleted_photos', deletedPhotos.join(','));

            $.ajax({
                url: "{{ route('admin.post.update') }}",
                method: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        // Reload DataTable setelah sukses update
                        $('#posted').DataTable().ajax.reload();
                        $('#post_draft').DataTable().ajax.reload();
                        $('#post_all').DataTable().ajax.reload();

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

        $(document).on("click", ".delete-btn", function() {
            var post_id = $(this).data('id');

            // Cek apakah ID adalah 1, karena tidak boleh dihapus
            if (post_id == 1) {
                iziToast.info({
                    title: 'Info',
                    message: 'This Post cannot be deleted.',
                    position: 'topRight'
                });
                return;
            }

            // Gunakan SweetAlert2 untuk konfirmasi
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
                        url: "{{ route('admin.post.destroy') }}",
                        data: {
                            post_id: post_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#posted').DataTable().ajax
                                .reload(); // Reload DataTable
                            $('#post_draft').DataTable().ajax
                                .reload(); // Reload DataTable
                            $('#post_all').DataTable().ajax
                                .reload(); // Reload DataTable

                            Swal.fire(
                                'Deleted!',
                                'Post has been deleted.',
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
                }
            });
        });



    });
</script>
