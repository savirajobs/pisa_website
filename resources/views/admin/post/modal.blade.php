<div class="modal fade modal-xl" id="addDataPost" tabindex="-1" aria-labelledby="addDataPostLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addDataPostLabel">Add Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addPostForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Content Title</label>
                        <input type="text" class="form-control" id="name" placeholder="Content Tittle" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="content_type" class="form-label">Content Type</label>
                        <select class="form-select" id="content_type" name="content_type" required>
                            <option value="">Select Content Type</option>
                            <option value="super-admin">Law</option>
                            <option value="admin">Facility</option>
                            <option value="admin">News</option>
                            <option value="admin">Activity</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="content_type" class="form-label">Content Category</label>
                        <select class="form-select" id="content_type" name="content_type" required>
                            <option value="">Select Content Category</option>
                            <option value="super-admin">Content</option>
                            <option value="admin">News</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Content Description</label>
                        <textarea class="form-control" id="editor" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Content Media</label>
                        <input class="form-control" type="file" id="formFileMultiple" multiple>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Publish</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Published On</label>
                        <input type="date" class="form-control" id="date" required  name="date" >
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Upcomping Date</label>
                        <input type="date" class="form-control" id="date" required  name="date" >
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