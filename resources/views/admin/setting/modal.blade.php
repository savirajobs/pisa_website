<div class="modal fade modal-xl" id="editPostModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModalLabel">Edit Page</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPostForm" action="{{ route('admin.post.update') }}" method="POST"
                enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                @csrf <!-- {{ csrf_field() }} -->
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="post_id" name="post_id" required>
                    <div class="mb-3">
                        <label for="editPost_title" class="form-label">Page Title</label>
                        <input type="text" class="form-control" id="editPostTitle" name="post_title" required
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label for="post_desc" class="form-label">Page Description</label>
                        <textarea class="form-control" id="editpost_desc" rows="3" name="post_desc" required></textarea>
                    </div>
                    <div class="mb-3">
                        <!-- PENGULANGAN GAMBAR UNTUK MENAMPILKAN GAMBAR DARI TABEL PHOTOS ADA DI SINI -->
                        <div class="form-group">
                            <label for="images" class="form-label">Image Saved</label>
                            <div class="overflow-auto">
                                <div id="image-list" class="row d-flex flex-nowrap">
                                    <!-- Photos will be dynamically added here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="uploadImage" class="form-label">Change Image</label>
                        <input type="file" name="images[]" class="form-control" id="uploadImage">
                        <div id="imagePreview" class="row mt-3"></div>
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
