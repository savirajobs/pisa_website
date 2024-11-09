<div class="modal fade modal-xl" id="addDataPost" tabindex="-1" aria-labelledby="addDataPostLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addDataPostLabel">Buat Pos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addPostForm" action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data"
                class="row g-3 needs-validation" novalidate>
                @csrf <!-- {{ csrf_field() }} -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Judul Pos</label>
                        <input type="text" class="form-control" id="post_title" placeholder="Masukkan judul pos"
                            name="post_title" required>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="name" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug"
                            required>
                    </div> --}}
                    <div class="mb-3">
                        <label for="post_type" class="form-label">Tipe Pos</label>
                        <select class="form-select" id="post_type" name="post_type" required>
                            <option value="" selected>Pilih tipe pos</option>
                            @foreach ($posttypes as $post_type)
                                <option value="{{ $post_type->type_id }}">{{ $post_type->type_desc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori Pos</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="" selected>Pilih kategori pos</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editor" placeholder="Masukkan deskripsi pos" rows="3" name="post_desc"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="uploadImages" class="form-label">Unggah Media</label>
                        <input type="file" name="images[]" class="form-control" id="uploadImages" multiple>
                        <div id="imagePreview" class="row mt-3"></div>
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
                    <div class="mb-3">
                        <label for="event_date" class="form-label">Tanggal Event</label>
                        <input type="date" class="form-control" id="event_date" name="event_date">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <input type="text" class="form-control" id="notes" name="notes"
                            placeholder="Masukkan catatan khusus">
                    </div>
                    {{-- <div class="mb-3">
                        <label for="name" class="form-label">Upcoming Date</label>
                        <input type="date" class="form-control" id="upcoming_date" name="upcoming_date">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeButton" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Post</button>
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
                <h5 class="modal-title" id="editDataModalLabel">Ubah Pos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPostForm" action="#" method="POST" enctype="multipart/form-data"
                class="row g-3 needs-validation" novalidate>
                @csrf <!-- {{ csrf_field() }} -->
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="post_id" name="post_id" required>
                    <input type="hidden" class="form-control" id="old_slug" name="old_slug" required>
                    <div class="mb-3">
                        <label for="editPost_title" class="form-label">Judul Pos</label>
                        <input type="text" class="form-control" id="editpost_title" name="post_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editslug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="editslug" name="slug" required>
                    </div>
                    <div class="mb-3">
                        <label for="post_type" class="form-label">Tipe Pos</label>
                        <select class="form-select" id="editpost_type" name="post_type" required>
                            <option value="" selected>Pilih tipe pos</option>
                            @foreach ($posttypes as $post_type)
                                <option value="{{ $post_type->type_id }}">{{ $post_type->type_desc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori Pos</label>
                        <select class="form-select" id="editcategory_id" name="category_id">
                            <option value="" selected>Pilih kategori pos</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editpost_desc" rows="3" name="post_desc"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="photos" class="form-label">Media Tersimpan</label>
                        <div class="overflow-auto">
                            <div id="photo-list" class="row d-flex flex-nowrap">
                                <!-- Photos will be dynamically added here -->
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Unggah Media</label>
                        <!-- <input class="form-control" type="file" id="formFileMultiple" name="post_media" multiple> -->
                        <input type="file" class="form-control" name="photos[]" id="photos" multiple
                            accept="image/*">
                        <div class="overflow-auto">
                            <div id="imagePreview2" class="row mt-3 d-flex flex-nowrap"></div>
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
                    <div class="mb-3">
                        <label for="event_date" class="form-label">Tanggal Event</label>
                        <input type="date" class="form-control" id="editevent_date" name="event_date">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <input type="text" class="form-control" id="editnotes" name="notes">
                    </div>

                    {{-- <div class="mb-3">
                        <label for="name" class="form-label">Published At</label>
                        <input type="date" class="form-control" id="editpublished_at" name="published_at">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Upcoming Date</label>
                        <input type="date" class="form-control" id="editupcoming_date" name="upcoming_date">
                    </div> --}}
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
