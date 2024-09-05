<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(document).ready(function() {
		var table = $('#userID').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: "{{ route('admin.users.apis') }}",
				method: "POST"
			},
			columns: [
				{ data: 'name' },
				{ data: 'email' },
				{ data: 'role' },
				{ data: 'updated_at' },
				{ data: 'action', orderable: false, searchable: false }
			]
		});

		function resetForm(modalId) {
			$(modalId).find('form')[0].reset();
		}

		$('#addDataModal').on('show.bs.modal', function (event) {
			console.log('Modal is being shown');
		});

		$('#addUserForm').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: "{{ route('admin.users.store') }}",
				type: 'POST',
				data: $(this).serialize(),
				success: function(response) {
					$('#userID').DataTable().ajax.reload();
					iziToast.success({
						title: 'Success',
						message: response.success,
						position: 'topRight'
					});
					$('#addDataModal').modal('hide');
					resetForm('#addDataModal');
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

		var userId;

		// Menampilkan modal dan mengisi data
		$(document).on('click', '.edit-btn', function() {
			var button = $(this); // Tombol yang diklik
			userId = button.data('id'); // Ambil ID dari data-id tombol
			console.log('user id:', userId);

			$.ajax({
				url: "{{ route('admin.users.edit') }}",
				type: 'GET',
				data: { id: userId },
				success: function(response) {
					if (response.status === 'success') {
						$('#editName').val(response.data.name);
						$('#editEmail').val(response.data.email);
						$('#editRole').val(response.data.role);
						$('#editPassword').val(''); // Kosongkan input password
					}

					$('#editDataModal').modal('show');
				},
				error: function(xhr) {
					console.log(xhr.responseText);
					iziToast.error({
						title: 'Error',
						message: 'An error occurred while fetching user data.',
						position: 'topRight'
					});
				}
			});
		});

		$('#editUserForm').on('submit', function(e) {
			e.preventDefault();

			$.ajax({
				url: "{{ route('admin.users.update') }}",
				type: 'POST',
				data: {
					_token: $('meta[name="csrf-token"]').attr('content'),
					id: userId, // Kirim ID user dari variabel global
					name: $('#editName').val(),
					email: $('#editEmail').val(),
					role: $('#editRole').val(),
					password: $('#editPassword').val() // Password opsional
				},
				success: function(response) {
					if (response.status === 'success') {
						// Reload DataTable setelah sukses update
						$('#userID').DataTable().ajax.reload();
						
						iziToast.success({
							title: 'Success',
							message: response.message,
							position: 'topRight'
						});
						$('#editDataModal').modal('hide'); // Tutup modal
						resetForm('#editDataModal'); // Reset form
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
			if (id == 1) {
				iziToast.info({
					title: 'Info',
					message: 'This user cannot be deleted.',
					position: 'topRight'
				});
				return;
			}

			if (confirm('Are you sure you want to delete this user?')) {
				$.ajax({
					type: 'DELETE',
					url: "{{ route('admin.users.destroy') }}",
					data: { id: id, _token: '{{ csrf_token() }}' },
					success: function(response) {
						$('#userID').DataTable().ajax.reload();
						iziToast.success({
							title: 'Success',
							message: response.success,
							position: 'topRight'
						});
					},
					error: function(xhr) {
						console.log(xhr.responseText);
						var response = JSON.parse(xhr.responseText);
						iziToast.error({
							title: 'Error',
							message: response.error || 'An unexpected error occurred.',
							position: 'topRight'
						});
					}
				});
			}
		});


	});
</script>