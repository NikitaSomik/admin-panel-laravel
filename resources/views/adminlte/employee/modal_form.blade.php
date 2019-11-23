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
                    <label class="control-label col-md-4" >First Name : </label>
                    <div class="col-md-8">
                        <input type="text" name="first_name" id="first_name" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" >Last Name : </label>
                    <div class="col-md-8">
                        <input type="text" name="last_name" id="last_name" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Company : </label>
                    <div class="col-md-8">
                        <select class=" select-company" id="company" name="company_id">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Email : </label>
                    <div class="col-md-8">
                        <input type="text" name="email" id="email" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Phone : </label>
                    <div class="col-md-8">
                        <input type="text" name="phone" id="phone" />
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
