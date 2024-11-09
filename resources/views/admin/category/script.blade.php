<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('post')
        }
    });
    $(document).ready(function() {
        $('#insert_content, #edit_content').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ol', 'paragraph']]
            ],
        });

        document.getElementById('closeButton').addEventListener('click', function() {
            document.getElementById('addCategoryForm').reset();
        });

        var table = $('#category').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.category.apis') }}",
                method: "GET"
            },
            columns: [

                {
                    data: 'category_name'
                },
                {
                    data: 'slug'
                },
                {
                    data: 'name'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'updated_at'
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

        $('#addCategoryForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.category.store') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#category').DataTable().ajax.reload();
                    iziToast.success({
                        title: 'Success',
                        message: response.success,
                        position: 'topRight'
                    });
                    $('#addDataCategory').modal('hide');
                    resetForm('#addDataCategory');
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


        $('#addDataModal').on('hidden.bs.modal', function(event) {
            console.log('Modal has been hidden');
            resetForm('#addDataModal');
        });

        var category_id;

        // Menampilkan modal dan mengisi data
        $(document).on('click', '.edit-btn', function() {
            var button = $(this); // Tombol yang diklik
            category_id = button.data('id'); // Ambil ID dari data-id tombol
            console.log('Category id:', category_id);

            $.ajax({
                url: "{{ route('admin.category.edit') }}",
                type: 'GET',
                data: {
                    category_id: category_id
                },
                success: function(response) {
                    if (response.status === 'success') {

                        $('#editcategory_name').val(response.data.category_name);
                        $('#editslug').val(response.data.slug);
                    }

                    $('#editCategoryModal').modal('show');
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

        $('#editCategoryForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.category.update') }}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    category_id: category_id, // Kirim ID user dari variabel global
                    category_name: $('#editcategory_name').val(),
                    slug: $('#editslug').val(),
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Reload DataTable setelah sukses update
                        $('#category').DataTable().ajax.reload();

                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });
                        $('#editCategoryModal').modal('hide'); // Tutup modal
                        resetForm('#editCategoryModal'); // Reset form
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
            var category_id = $(this).data('id');

            // Cek apakah ID adalah 1, karena tidak boleh dihapus
            if (category_id == 1) {
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
                        url: "{{ route('admin.category.destroy') }}",
                        data: {
                            category_id: category_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#category').DataTable().ajax
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
