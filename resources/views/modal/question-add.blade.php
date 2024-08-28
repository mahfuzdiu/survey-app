<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add question and multiple options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('questions.store')}}" method="post">
                    @method('POST')
                    @csrf
                    <div class="form-group">
                        <label>Question</label>
                        <textarea name="question" type="text" class="form-control form-control-sm" placeholder="Write your question" required></textarea>
                    </div>

                    <div class="options">
                        <div class="d-flex justify-content-between mb-2">
                            <h6>Add Options</h6>
                            <button id="addOptions" style="padding: 0 6px; line-height: 0" type="button" class="btn btn-sm btn-outline-primary">+</button>
                        </div>
                        <div class="form-group">
                            <input name="options[]" type="text" class="form-control form-control-sm" placeholder="Option 1" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-outline-primary float-right" onclick="return confirm('Are you sure?')">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
