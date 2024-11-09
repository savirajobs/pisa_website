<div class="modal fade modal-xl" id="addDataCategory" tabindex="-1" aria-labelledby="addDataPostLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addDataCategoryLabel">Buat Kategori</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCategoryForm" action="{{ route('admin.category.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="category_name" placeholder="Masukkan kategori"
                            name="category_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" placeholder="Masukkan slug"
                            name="slug" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeButton" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-xl" id="editCategoryModal" tabindex="-1" aria-labelledby="editDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModalLabel">Ubah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editcategory_name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="editcategory_name" name="category_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editslug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="editslug" name="slug" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Reset - form.reset()">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
