<div class="modal fade modal-xl" id="addDataPost" tabindex="-1" aria-labelledby="addDataPostLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addDataPostLabel">Add Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addPostForm" action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Post Title</label>
                        <input type="text" class="form-control" id="post_title" placeholder="Post Title" name="post_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="post_type" class="form-label">Post Type</label>
                        <select class="form-select" id="post_type" name="post_type" required>
                            <option value="" selected>Select Post Type</option>
                            @foreach ($posttypes as $post_type)
                                <option  value="{{$post_type->type_id}}">{{$post_type->type_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Post Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="" selected>Select Post Category</option>
                            @foreach ($categories as $category)
                                <option  value="{{$category->category_id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Post Description</label>
                        <textarea class="form-control" id="editor" rows="3" name="post_desc"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Post Media</label>
                        <input class="form-control" type="file" id="formFileMultiple" name="post_media" multiple>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_publish" name="is_publish">
                            <label class="form-check-label" for="is_publish">Publish</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Published At</label>
                        <input type="date" class="form-control" id="published_at"  name="published_at" >
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Upcomping Date</label>
                        <input type="date" class="form-control" id="upcoming_date"  name="upcoming_date" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRole" class="form-label">Role</label>
                        <select class="form-select" id="editRole" name="role" required>
                            <option value="">Select Role</option>
                            <option value="super-admin">Super Admin</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password (optional)</label>
                        <input type="password" class="form-control" id="editPassword" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>