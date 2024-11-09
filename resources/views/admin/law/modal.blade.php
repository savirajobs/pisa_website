<div class="modal fade modal-xl" id="addDataPost" tabindex="-1" aria-labelledby="addDataPostLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addDataPostLabel">Tambah Dasar Hukum</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addPostForm" action="{{ route('admin.law.store') }}" method="POST" enctype="multipart/form-data"
                class="row g-3 needs-validation" novalidate>
                @csrf <!-- {{ csrf_field() }} -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Dasar Hukum</label>
                        <input type="text" class="form-control" id="post_title"
                            placeholder="Masukkan nama dasar hukum" name="post_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="uploadPdf" class="form-label">Unggah File</label>
                        <input type="file" name="mediaPdf[]" class="form-control" id="uploadPdf" multiple>
                        <iframe id="pdfPreview" style="width: 100%; height: 500px; display: none;"></iframe>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="is_publish">Terbitkan?</label>
                            <br>
                            <input type="radio" name="is_publish" id="is_publish_yes" value="1">
                            <label for="is_publish_yes">Ya</label>

                            <input type="radio" name="is_publish" id="is_publish_no" value="0">
                            <label for="is_publish_no">Tidak</label>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-xl" id="editPostModal" tabindex="-1" aria-labelledby="editDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModalLabel">Ubah Dasar Hukum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPostForm" action="#" method="POST" enctype="multipart/form-data"
                class="row g-3 needs-validation" novalidate>
                @csrf <!-- {{ csrf_field() }} -->
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="post_id" name="post_id" required>
                    <div class="mb-3">
                        <label for="editPost_title" class="form-label">Nama Dasar Hukum</label>
                        <input type="text" class="form-control" id="editpost_title" name="post_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="pdf" class="form-label">File Tersimpan</label>
                        <div class="overflow-auto">
                            <div id="pdf-list" class="row d-flex flex-nowrap">
                                <!-- Pdf will be dynamically added here -->
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Unggah File</label>
                        <input type="file" class="form-control" name="pdf[]" id="pdf" multiple
                            accept="pdf/*">
                        <div class="overflow-auto">
                            <iframe id="pdfPreview2" style="width: 100%; height: 500px; display: none;"></iframe>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="is_publish">Terbitkan?</label>
                            <br>

                            <input type="radio" name="is_publish" id="is_publish_yes_edit" value="1">
                            <label for="is_publish_yes">Ya</label>

                            <input type="radio" name="is_publish" id="is_publish_no_edit" value="0">
                            <label for="is_publish_no">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        value="Reset - form.reset()">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Mendapatkan elemen iframe dan menyimpan src aslinya
    const iframe = document.getElementById('pdfPreview');
    // Menghapus src saat modal ditutup
    $('#addDataPost').on('hidden.bs.modal', function() {
        iframe.src = '';
    });

    // Mengembalikan src asli saat modal dibuka
    $('#addDataPost').on('shown.bs.modal', function() {
        iframe.src = '';
    });

    function clearIframe() {
        const iframe = document.getElementById('pdfPreview2');
        iframe.src = 'about:blank'; // Ganti ke halaman kosong
        iframe.style.display = 'none';
    }

    // Panggil fungsi ini sesuai event yang Anda inginkan
    window.onload = clearIframe;
</script>
