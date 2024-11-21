<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>

<script>
    // GLOBAL SETUP
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $(document).ready(function() {
        var table = $('#table-gallery');
        //========================================================================DATATABLE
        $('#table-gallery').DataTable({
            ajax: "{{ route('admin.gallery.apis') }}",
            processing: true,
            serverSide: true,
            columns: [{
                    data: 'post_title',
                    name: 'post_title'
                    //title: 'Nama Album'
                },
                {
                    data: 'is_publish',
                    name: 'is_publish',
                    //title: 'Diterbitkan
                },
                {
                    data: 'name',
                    name: 'name'
                    //title: 'Kreator'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                    //title: 'Tanggal Pos'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });

        $('#table-video').DataTable({
            ajax: "{{ route('admin.gallery.video') }}",
            processing: true,
            serverSide: true,
            columns: [{
                    data: 'post_title',
                    name: 'post_title'
                    //title: 'Nama Album'
                },
                {
                    data: 'is_publish',
                    name: 'is_publish',
                    //title: 'Diterbitkan
                },
                {
                    data: 'name',
                    name: 'name'
                    //title: 'Kreator'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                    //title: 'Tanggal Pos'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
    });

    $('#modal-add-gallery').on('show.bs.modal', function(event) {
        $("#modal-add-gallery").modal();
        $('#imagePreview').html(null);
        $('#upload-form')[0].reset();
        $('#uploadImages').val('');
        console.log('Modal is being shown');
    });

    $('#modal-add-video').on('show.bs.modal', function(event) {
        $("#modal-add-video").modal();
        $('#videoPreview').html(null);
        $('#uploadVideo-form')[0].reset();
        $('#uploadVideo').val('');
        console.log('Modal is being shown');
    });

    //For reset modal edit gallery
    $("#reset-btn").click(function() {
        document.getElementById("upload-form").reset();
        $("#modal-add-gallery").modal();
        $('#imagePreview').html(null);

        document.getElementById("uploadVideo-form").reset();
        $("#modal-add-video").modal();
        $('#videoPreview').html(null);
        //$('#image-list').html(null);
        //$('#imagePreviewOnEdit').html(null);
    });

    //Display preview images
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

    document.getElementById('update-image').addEventListener('change', function() {
        handleFileUpload(this, 'imagePreviewOnEdit');
    });

    function resetForm(modalId) {
        $(modalId).find('form')[0].reset();
    }

    //Menambahkan Galeri Foto
    $('#upload-form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('admin.gallery.store') }}",
            method: 'POST',
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                // Reload the DataTable
                $('#table-gallery').DataTable().ajax.reload();

                // Show success toast notification
                iziToast.success({
                    title: 'Success',
                    message: response.success,
                    position: 'topRight'
                });

                // Hide the modal and reset the form
                $('#modal-add-gallery').modal('hide');
                resetForm('#upload-form'); // Ensure this resets the correct form
                $('#upload-form')[0].reset();
                $('#uploadImages').val('');
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
                        message: response.error || 'An unexpected error occurred.',
                        position: 'topRight'
                    });
                }
            }
        });
    });

    //Menambahkan Galeri Video
    $('#uploadVideo-form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('admin.gallery.store') }}",
            method: 'POST',
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                // Reload the DataTable
                $('#table-video').DataTable().ajax.reload();

                // Show success toast notification
                iziToast.success({
                    title: 'Success',
                    message: response.success,
                    position: 'topRight'
                });

                // Hide the modal and reset the form
                $('#modal-add-video').modal('hide');
                resetForm('#uploadVideo-form'); // Ensure this resets the correct form
                $('#uploadVideo-form')[0].reset();
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
                        message: response.error || 'An unexpected error occurred.',
                        position: 'topRight'
                    });
                }
            }
        });
    });

    //Show value on edit form
    $('body').on('click', '.btn-edit', function(e) {
        $('#upload-form-edit')[0].reset();
        $('#update-image').val('');
        //$('#imagePreviewOnEdit').attr('src', '').hide();

        let id = $(this).data('id');
        $.ajax({
            url: "{{ route('admin.gallery.edit') }}",
            method: 'GET',
            data: {
                id: id
            },
            success: function(response) {
                console.log(response);
                $('.modal-edit-gallery').modal('show');
                $('.edit-title').val(response.post_title);
                $('.edit-desc').val(response.post_desc);
                $('.edit-slug').val(response.slug);
                $('#post_id').val(response.post_id);
                $('#edit_category_id').val(response.category_id);
                $('#old_slug').val(response.slug);

                if (response.event_at) {
                    $('#edit_img_event_at').val(moment(response.event_at,
                        "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD"));
                }

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
                    url: "{{ route('admin.gallery.media') }}",
                    method: 'GET',
                    data: {
                        id: id
                    },
                    success: function(images) {
                        console.log(images);
                        if (images.length === 0) {
                            $('#image-list').append(
                                '<p class="text-muted text-center">Tidak ada foto untuk ditampilkan.</p>'
                            );
                        } else {
                            $('#image-list').html('');
                            images.forEach(images => {
                                $('#image-list').append(`
                                <div class="image-item col-md-4 mb-3" data-image-id="${images.media_id}">
                                    <div class="position-relative">
                                        <img src="/images/${images.file_name}" alt="Images" class="img-thumbnail bg-success-subtle">
                                        <button type="button" class="btn-close close-image-btn" aria-label="Close" style="position: absolute;"></button>
                                    </div>
                                </div>
                            `);
                            });
                        }
                    },
                    dataType: 'json'
                });
            },
            dataType: 'json'
        });
    });

    $('body').on('click', '.btn-video-edit', function(e) {
        $('#uploadVideo-form-edit')[0].reset();
        $('#update-video').val('');
        //$('#imagePreviewOnEdit').attr('src', '').hide();

        let id = $(this).data('id');
        $.ajax({
            url: "{{ route('admin.gallery.edit') }}",
            method: 'GET',
            data: {
                id: id
            },
            success: function(response) {
                console.log(response);
                $('.modal-edit-video').modal('show');
                $('.video-title').val(response.post_title);
                $('.video-desc').val(response.post_desc);
                $('.video-slug').val(response.slug);
                $('#video_post_id').val(response.post_id);
                $('#edit_video_category_id').val(response.category_id);
                $('#video_old_slug').val(response.slug);
                $('#video-embedded').val(response.notes);

                if (response.event_at) {
                    $('#edit_vid_event_at').val(moment(response.event_at,
                        "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD"));
                }

                // Atur nilai radio button di modal sesuai dengan nilai dari response
                if (response.is_publish !== undefined) {
                    if (response.is_publish == 1) {
                        $('#video_is_publish_yes_edit').prop('checked',
                            true); // Pilih 'Yes' di modal
                    } else {
                        $('#video_is_publish_no_edit').prop('checked',
                            true); // Pilih 'No' di modal
                    }
                } else {
                    // Jika tidak ada nilai yang dikirim dari server
                    $('#video_is_publish_yes_edit').prop('checked', false);
                    $('#video_is_publish_no_edit').prop('checked', false);
                }

                //check kolom notes
                if (response.notes === null) {
                    $('#video-list').append(
                        '<p class="text-muted text-center">Tidak ada Video untuk ditampilkan.</p>'
                    );
                } else {
                    $('#video-list').html('');
                    $('#video-list').append(`
                                <div class="image-item col-md-4 mb-3" data-image-id="${response.post_id}">
                                    <div class="position-relative">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" width="100%" height="300" src="${ response.notes }"></iframe>
                                        </div>
                                    </div>
                                </div>
                            `);
                }
            },
            dataType: 'json'
        });
    });

    //close images and move to deleted images
    $(document).on('click', '.close-image-btn', function() {
        let imageItem = $(this).closest('.image-item');
        imageItem.addClass('remove-image');
        imageItem.find('img').remove();
        $(this).remove();
        imageItem.attr('hidden', true);
    });

    //submit form edit
    $(document).on('submit', '#upload-form-edit, #uploadVideo-form-edit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let deletedImages = [];

        // Mengecek data yang memiliki .remove-image lalu mengambil image-id
        $('.remove-image').each(function() {
            let imageId = $(this).data('image-id');
            deletedImages.push(imageId);
        });

        formData.append('deleted_images', deletedImages.join(','));

        $.ajax({
            url: "{{ route('admin.gallery.update') }}",
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#modal-edit-gallery').modal('hide');
                $('#modal-edit-video').modal('hide');
                $('#table-gallery').DataTable().ajax.reload();
                $('#table-video').DataTable().ajax.reload();

                Swal.fire(
                    'Update Success',
                    'Gallery has been updated.',
                    'success'
                );
                $("#modal-edit-gallery").modal();
                $("#modal-edit-video").modal();
                $('#image-list').html(null);
                $('#imagePreviewOnEdit').html(null);
                $('#video-list').html(null);
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
                        message: response.error || 'An unexpected error occurred.',
                        position: 'topRight'
                    });
                }
            }
        });
    });

    //Delete Galeri
    $(document).on('click', '.btn-delete', function() {
        var post_id = $(this).data('id');
        //console.log(post_id);

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
                    url: "{{ route('admin.gallery.destroy') }}",
                    data: {
                        post_id: post_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#table-gallery').DataTable().ajax
                            .reload(); // Reload DataTable
                        $('#table-video').DataTable().ajax
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
</script>
