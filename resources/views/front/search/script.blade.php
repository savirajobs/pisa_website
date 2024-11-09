<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    document.getElementById('search-icon').addEventListener('click', function() {
        // Ambil nilai dari input pencarian
        let keyword = document.getElementById('search-input').value;

        $.ajax({
            url: "{{ route('frontend.search') }}", // URL endpoint
            method: "GET",
            data: {
                keyword: keyword
            }, // Data yang dikirim
            success: function(response) {
                console.log("OK"); // Proses respons dari server
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

</script>
