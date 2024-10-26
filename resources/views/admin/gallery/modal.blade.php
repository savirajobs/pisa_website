<!-- MODAL INSERT -->
<div class="modal fade modal-xl" id="modal-add-gallery" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true"
    destroyOnClose={true}>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addDataModalLabel">Add Gallery</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card">
                <div class="card-body">
                    {{-- <form id="upload-form" enctype="multipart/form-data" class="row g-3 needs-validation"
                        action="{{ route('admin.gallery.store') }}" method="POST" novalidate> --}}
                    <form id="upload-form" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="category_id" value="6" id="category_id">
                        <div class="mb-3">
                            <div class="form-group" <label for="title" class="form-label">Gallery Title</label>
                                <input type="text" name="post_title" class="form-control" id="insert_title"
                                    placeholder="-- insert gallery name --">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group" <label for="desc" class="form-label">Description</label>
                                <textarea name="post_desc" class="form-control" id="insert_desc" placeholder="-- insert description --" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="uploadImages" class="form-label">Upload Image</label>
                            <input type="file" name="images[]" class="form-control" id="uploadImages" multiple>
                            <div id="imagePreview" class="row mt-3"></div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="is_publish">Publish?</label>
                                <br>
                                <input type="radio" name="is_publish" id="is_publish_yes" value="1">
                                <label for="is_publish_yes">Yes</label>

                                <input type="radio" name="is_publish" id="is_publish_no" value="0">
                                <label for="is_publish_no">No</label>
                            </div>
                        </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="submit" id="submit" class="btn btn-primary" style="float:right;">
                        <i class="fa fa-save"></i> Save
                    </button>
                    {{-- <button type="reset" name="reset" id="reset-btn" class="btn btn-danger">
                        <i class="fa fa-sync"></i> Reset
                    </button> --}}
                    {{-- <a class="btn btn-dark" style="float:right;data-bs-dismiss="modal" id="close-btn" 
                        href="{{ route('admin.gallery.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a> --}}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="float:right; margin-right:5px;" value="Reset - form.reset()">Back</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- MODAL EDIT-->
<div class="modal fade modal-xl modal-edit-gallery" id="modal-edit-gallery" tabindex="-1"
    aria-labelledby="modalEditGalleryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditGalleryLabel">Edit Gallery</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card">
                <div class="card-body">
                    <form id="upload-form-edit" enctype="multipart/form-data" class="row g-3 needs-validation"
                        action="#" method="POST" novalidate>
                        @csrf
                        <input type="hidden" name="post_id" id="post_id">
                        <input type="hidden" name="category_id" id="category_id">
                        <input type="hidden" class="form-control" id="old_slug" name="old_slug" required>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="title" class="form-label">Gallery Title</label>
                                <input type="text" name="title" class="form-control edit-title" id="edit-title"
                                    required>
                                <small id="edit_title_error" class="error text-danger"></small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editslug" class="form-label">Slug</label>
                            <input type="text" class="form-control edit-slug" id="edit-slug" name="slug"
                                required>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control edit-desc" name="desc" id="edit-desc"></textarea>
                                <small id="description_error" class="error text-danger"></small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- PENGULANGAN GAMBAR UNTUK MENAMPILKAN GAMBAR DARI TABEL PHOTOS ADA DI SINI -->
                            <div class="form-group">
                                <label for="images" class="form-label">Images</label>
                                <div class="overflow-auto">
                                    <div id="image-list" class="row d-flex flex-nowrap">
                                        <!-- Photos will be dynamically added here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="updateImages" class="form-label">Add Images</label>
                                <input type="file" class="form-control update-image" name="images[]"
                                    id="update-image" multiple accept="image/*">
                                {{-- <div class="overflow-auto"> --}}
                                <div id="imagePreviewOnEdit" src="" alt="Image Preview" syle="display:none;"
                                    class="row mt-3">
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="is_publish">Publish?</label>
                                <br>

                                <input type="radio" name="is_publish" id="is_publish_yes_edit" value="1">
                                <label for="is_publish_yes">Yes</label>

                                <input type="radio" name="is_publish" id="is_publish_no_edit" value="0">
                                <label for="is_publish_no">No</label>
                            </div>
                        </div>
                </div>
                <div class="card-footer">
                    <button type="button" id="cancel-btn" class="btn btn-secondary" style="float:right;"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary submit-edit-btn"
                        style="float:right; margin-right:5px;">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-xl" id="modal-add-video" tabindex="-1" aria-labelledby="addDataModalLabel"
    aria-hidden="true" destroyOnClose={true}>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addDataModalLabel">Add Video</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card">
                <div class="card-body">
                    <form id="uploadVideo-form" enctype="multipart/form-data" class="row g-3 needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="category_id" value="7" id="category_id">
                        <div class="mb-3">
                            <div class="form-group" <label for="title" class="form-label">Gallery Video
                                Title</label>
                                <input type="text" name="post_title" class="form-control" id="insert_title"
                                    placeholder="-- insert gallery name --">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group" <label for="desc" class="form-label">Description</label>
                                <textarea name="post_desc" class="form-control" id="insert_desc" placeholder="-- insert description --"
                                    rows="4"></textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="uploadVideos" class="form-label">Upload Video</label>
                            <input type="file" name="videos[]" class="form-control" id="uploadVideos">
                            {{-- <div id="videoPreview" class="row mt-3"></div> --}}
                            <video id="videoPreview" width="320" height="240" controls style="display: none;">
                                <source id="videoSource" src="" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="is_publish">Publish?</label>
                                <br>
                                <input type="radio" name="is_publish" id="is_publish_yes" value="1">
                                <label for="is_publish_yes">Yes</label>

                                <input type="radio" name="is_publish" id="is_publish_no" value="0">
                                <label for="is_publish_no">No</label>
                            </div>
                        </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="submit" id="submit" class="btn btn-primary"
                        style="float:right;">
                        <i class="fa fa-save"></i> Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="float:right; margin-right:5px;" value="Reset - form.reset()">Back</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-xl modal-edit-video" id="modal-edit-video" tabindex="-1"
    aria-labelledby="modalEditGalleryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditGalleryLabel">Edit Video Gallery</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card">
                <div class="card-body">
                    <form id="uploadVideo-form-edit" enctype="multipart/form-data" class="row g-3 needs-validation"
                        action="#" method="POST" novalidate>
                        @csrf
                        <input type="hidden" name="post_id" id="video_post_id">
                        <input type="hidden" name="category_id" id="video_category_id">
                        <input type="hidden" name="old_slug" id="video_old_slug">
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="title" class="form-label">Gallery Video Title</label>
                                <input type="text" name="title" class="form-control video-title"
                                    id="video-title" required>
                                <small id="edit_title_error" class="error text-danger"></small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editslug" class="form-label">Slug</label>
                            <input type="text" class="form-control video-slug" id="video-slug" name="slug"
                                required>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control video-desc" name="desc" id="video-desc"></textarea>
                                <small id="description_error" class="error text-danger"></small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- PENGULANGAN GAMBAR UNTUK MENAMPILKAN GAMBAR DARI TABEL PHOTOS ADA DI SINI -->
                            <div class="form-group">
                                <label for="videos" class="form-label">Videos</label>
                                <div class="overflow-auto">
                                    <div id="video-list" class="row d-flex flex-nowrap">
                                        <!-- Photos will be dynamically added here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="updateVideo" class="form-label">Add Videos</label>
                                <input type="file" class="form-control update-image" name="videos[]"
                                    id="update-video" multiple accept="video/*">
                                {{-- <div class="overflow-auto"> --}}
                                <div id="videoPreviewOnEdit" src="" alt="Video Preview" syle="display:none;"
                                    class="row mt-3">
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="is_publish">Publish?</label>
                                <br>

                                <input type="radio" name="is_publish" id="video_is_publish_yes_edit"
                                    value="1">
                                <label for="is_publish_yes">Yes</label>

                                <input type="radio" name="is_publish" id="video_is_publish_no_edit"
                                    value="0">
                                <label for="is_publish_no">No</label>
                            </div>
                        </div>
                </div>
                <div class="card-footer">
                    <button type="button" id="cancel-btn" class="btn btn-secondary" style="float:right;"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary submit-edit-btn"
                        style="float:right; margin-right:5px;">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
