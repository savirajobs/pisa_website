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



		var table = $('#posted').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: "{{ route('admin.post.apis') }}",
				method: "GET"
			},
			columns: [
				
				{ data: 'post_title' },
				{ data: 'is_publish' },
				{ data: 'published_at' },
				{ data: 'upcoming_date' },
				{ data: 'created_by' },
				{ data: 'action', orderable: false, searchable: false }
			]
		});

		var table = $('#post_draft').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: "{{ route('admin.post.post_draft') }}",
				method: "GET"
			},
			columns: [
				
				{ data: 'post_title' },
				{ data: 'is_publish' },
				{ data: 'published_at' },
				{ data: 'upcoming_date' },
				{ data: 'created_by' },
				{ data: 'action', orderable: false, searchable: false }
			]
		});

		var table = $('#post_all').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: "{{ route('admin.post.post_all') }}",
				method: "GET"
			},
			columns: [
				
				{ data: 'post_title' },
				{ data: 'is_publish' },
				{ data: 'published_at' },
				{ data: 'upcoming_date' },
				{ data: 'created_by' },
				{ data: 'action', orderable: false, searchable: false }
			]
		});

		function resetForm(modalId) {
			$(modalId).find('form')[0].reset();
		}

		$('#addDataModal').on('show.bs.modal', function (event) {
			console.log('Modal is being shown');
		});

		$('#addPostForm').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: "{{ route('admin.post.store') }}",
				type: 'POST',
				data: $(this).serialize(),
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


		$('#addDataModal').on('hidden.bs.modal', function (event) {
			console.log('Modal has been hidden');
			resetForm('#addDataModal');
		});

		var post_id;
		var toggle_publish;

		// Menampilkan modal dan mengisi data
		$(document).on('click', '.edit-btn', function() {
			var button = $(this); // Tombol yang diklik
			post_id = button.data('id'); // Ambil ID dari data-id tombol
			console.log('post id:', post_id);

			$.ajax({
				url: "{{ route('admin.post.edit') }}",
				type: 'GET',
				data: { post_id: post_id },
				success: function(response) {
					if (response.status === 'success') {
						if (response.data.is_publish === 1){
							toggle_publish = 'Checked';
						}else{
							toggle_publish = '';
						}

						$('#editpost_title').val(response.data.post_title);
						$('#editpost_type').val(response.data.post_type);
						$('#editcategory_id').val(response.data.category_id);
						$('#editpost_desc').val(response.data.post_desc);
						$('#editis_publish').val(toggle_publish);
						$('#editpublished_at').val(moment(response.data.published_at).format("YYYY-MM-DD"));
						$('#editupcoming_date').val(moment(response.data.upcoming_date).format("YYYY-MM-DD"));
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

		$('#editPostForm').on('submit', function(e) {
			e.preventDefault();

			$.ajax({
				url: "{{ route('admin.post.update') }}",
				type: 'POST',
				data: {
					_token: $('meta[name="csrf-token"]').attr('content'),
					post_id: post_id, // Kirim ID user dari variabel global
					post_title: $('#editpost_title').val(),
					post_type: $('#editpost_type').val(),
					category_id: $('#editcategory_id').val(),
					post_desc: $('#editpost_desc').val(),
					is_publish: $('#editis_publish').val(),
					published_at: $('#editpublished_at').val(),
					upcoming_date: $('#editupcoming_date').val(),
				},
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
							message: response.error || 'An unexpected error occurred.',
							position: 'topRight'
						});
					}
				}
			});
		});


		$(document).on("click", ".delete-btn", function () {
			var id = $(this).data('id');

			// Cek apakah ID adalah 1, karena tidak boleh dihapus
			if (id == 1) {
				iziToast.info({
					title: 'Info',
					message: 'This user cannot be deleted.',
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
						data: { id: id, _token: '{{ csrf_token() }}' },
						success: function(response) {
							$('#userID').DataTable().ajax.reload(); // Reload DataTable

							Swal.fire(
								'Deleted!',
								'User has been deleted.',
								'success'
							);
						},
						error: function(xhr) {
							var response = JSON.parse(xhr.responseText);
							Swal.fire(
								'Error!',
								response.error || 'An unexpected error occurred.',
								'error'
							);
						}
					});
				}
			});
		});



	});
</script>