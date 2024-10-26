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
            $('#addPostForm, #editPostForm')[0].reset();
            $('.error.text-danger').html(null);
            $('#addPostForm, #editPostForm').removeClass('was-validated');
            $('.invalid-feedback').html(null);
            $('#editor, #editpost_desc').summernote('reset');
            $('#imagePreview').html('');
            $('#image-list').html('');
        });

        $('#editPostModal').on('hidden.bs.modal', function() {
            $('#editPostForm')[0].reset();
            $('.error.text-danger').html(null);
            $('#editPostForm').removeClass('was-validated');
            $('.invalid-feedback').html(null);
            $('#imagePreview').html('');
            $('#image-list').html('');
        });
        // End of Summernote setting

        var table = $('#settingPage').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.setting.apis') }}",
                method: "GET"
            },
            columns: [

                {
                    data: 'post_type'
                },
                {
                    data: 'post_desc'
                },
                {
                    data: 'updated_at'
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

        // function resetForm(modalId) {
        // 	$(modalId).find('form')[0].reset();
        // }

        $('#addDataModal').on('show.bs.modal', function(event) {
            console.log('Modal is being shown');
        });

        $('#addDataModal').on('hidden.bs.modal', function(event) {
            console.log('Modal has been hidden');
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

        document.getElementById('uploadImage').addEventListener('change', function() {
            handleFileUpload(this, 'imagePreview');
        });

        var post_id;

        // Menampilkan modal dan mengisi data
        $(document).on('click', '.edit-btn', function() {
            var button = $(this); // Tombol yang diklik
            post_id = button.data('id'); // Ambil ID dari data-id tombol
            //console.log('post id:', post_id);

            $.ajax({
                url: "{{ route('admin.setting.edit') }}",
                type: 'GET',
                data: {
                    post_id: post_id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        console.log(response);
                        $('#post_id').val(response.data.post_id);
                        $('#editPostTitle').val(response.data.post_title);
                        $('#editpost_desc').summernote('code', response.data.post_desc);
                        $('#editembedvideo').val(response.data.notes); 

                        $.ajax({
                            url: "{{ route('admin.setting.media') }}",
                            method: 'GET',
                            data: {
                                post_id: post_id,
                            },
                            success: function(image) {
                                console.log(image);
                                if (image.length === 0) {
                                    $('#image-list').append(
                                        '<p class="text-muted text-center">Tidak ada foto untuk ditampilkan.</p>'
                                    );
                                } else {
                                    $('#image-list').html('');
                                    image.forEach(image => {                                        
                                        $('#image-list').append(`
											<div class="photo-item col-md-4 mb-3" data-photo-id="${image.media_id}">
												<div class="position-relative">
													<img src="/images/${image.file_name}" alt="Photo" class="img-thumbnail bg-success-subtle">
													<button type="button" class="btn-close close-photo-btn" aria-label="Close"></button>
												</div>
											</div>
										`);
                                    });
                                }
                            },
                            dataType: 'json'
                        });
                    }

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
            console.log(formData);

             // Mengecek data yang memiliki .remove-photo lalu mengambil photo-id
            $('.remove-photo').each(function() {
                let photoId = $(this).data('photo-id');
                deletedPhotos.push(photoId);
            });

            formData.append('deleted_photos', deletedPhotos.join(','));
            
            $.ajax({
                url: "{{ route('admin.setting.update') }}",
                method: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        // Reload DataTable setelah sukses update
                        $('#settingPage').DataTable().ajax.reload();
                        console.log(response);

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
</script>
