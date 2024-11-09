<div class="modal fade modal-xl" id="replyFeedback" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModalLabel">Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="replyForm" action="{{ route('admin.feedback.update') }}" method="POST"
                enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                @csrf <!-- {{ csrf_field() }} -->
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="feedback_id" name="feedback_id" required>
                    <span class="badge text-bg-success verified-email" style="float:right;">Verified</span>
                    <span class="badge text-bg-warning duplication-status" style="float:right;">No Duplication</span>

                    <div class="mb-3">
                        <label for="editPost_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="replyTitle" name="feedback_title" required
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label for="editslug" class="form-label">Sender</label>
                        <input type="text" class="form-control" id="replySender" name="sender_name" required
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label for="editslug" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="replyPhone" name="phone" required disabled>
                    </div>
                    <div class="mb-3">
                        <label for="editslug" class="form-label">Email</label>
                        <input type="text" class="form-control" id="replyEmail" name="email" required disabled>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Isi Pesan</label>
                        <textarea class="form-control" id="replyFeedbackDesc" rows="4" name="feedback_desc" disabled></textarea>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="is_spam">Spam Checker :</label>
                        <br>

                        <input type="radio" name="is_spam" id="is_spam_yes" value="1">
                        <label for="is_spam_yes">Spam</label>

                        <input type="radio" name="is_spam" id="is_spam_no" value="0">
                        <label for="is_spam_no">Not Spam</label>
                    </div> --}}
                    {{-- <div class="mb-3">
                        <label for="is_spam">Is it duplication?</label>
                        <br>

                        <input type="radio" name="is_duplicate" id="is_duplicate_yes" value="1">
                        <label for="is_duplicate_yes">Yes</label>

                        <input type="radio" name="is_duplicate" id="is_duplicate_no" value="0">
                        <label for="is_duplicate_no">No</label>
                    </div> --}}
                    {{-- <div class="mb-3">
                        <div class="overflow-auto">
                            <div id="reply-feedback" class="row d-flex flex-nowrap">
                                <!-- Reply will be dynamically added here -->
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        value="Reset - form.reset()">Close</button>
                    {{-- <button type="submit" class="btn btn-primary">Reply</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>

