
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="form_result_store"></div>
            <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="control-label col-md-4" >Name : </label>
                    <div class="col-md-8">
                        <input type="text" name="name" id="name" class="form-control" />
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Email : </label>
                    <div class="col-md-8">
                        <input type="text" name="email" id="email" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Select Company Logo : </label>
                    <div class="col-md-8">
                        <input type="file" name="logo" id="logo" />
                        <span id="store_logo"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Website : </label>
                    <div class="col-md-8">
                        <input type="text" name="website" id="website" />
                    </div>
                </div>
                <br />
                <div class="form-group align-content-center" >
                    <input type="hidden" name="action" id="action" />
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="submit" name="action_button" id="action_button" class="btn btn-primary" value="Add" />
                </div>
            </form>
        </div>
    </div>
</div>

