@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User List</h2>
    <a href="javascript:void(0)" class="btn btn-info " id="create-new-user">Add New</a>
    <br><br>

    <table class="table table-bordered table-striped" id="laravel_datatable">
        <thead>
            <tr>
                <th>ID </th>
                <th>No. </th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created at</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<div class="modal fade" id="ajax-user-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="todoForm" name="todoForm" class="form-horizontal">
                    <div class="form-group">
                        <input type="text" name="user_id" id="user_id" value="" hidden>
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="" maxlength="50">
                            <span class="invalid-name text-danger" id="invalid-name" role="alert">
                            </span>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">E-mail</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter E-mail" value="" maxlength="50">
                            <span class="invalid-email text-danger" id="invalid-email" role="alert">
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role" class="col-sm-2 control-label">Role</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="role" id="role">
                                <option value="" selected>Please select...</option>
                                <option value="{{ \App\Models\User::STATUS_ADMIN }}">Admin
                                </option>
                                <option value="{{ \App\Models\User::STATUS_USER }}">User
                                </option>
                            </select>
                            <span class="invalid-role text-danger" id="invalid-role" role="alert">
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" value="" maxlength="50">
                            <span class="invalid-password text-danger" id="invalid-password" role="alert">
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save
                        </button>
                    </div>

            </div>
            <div class="modal-footer">

            </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script>
    var SITEURL = '{{URL::to(' / ')}}';
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#laravel_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/",
                type: 'GET',
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    'visible': false
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

        $('#create-new-user').click(function() {
            $('#btn-save').val("create-product");
            $('#todoForm').trigger("reset");
            $('#userCrudModal').html("Add New User");
            $('#ajax-user-modal').modal('show');
        });

        $('body').on('click', '.edit-product', function() {
            var user_id = $(this).data('id');
            console.log(user_id);
            $.get('/edit-user/' + user_id, function(data) {
                $('#body-error').hide();
                $('#product_code-error').hide();
                $('#description-error').hide();
                $('#userCrudModal').html("Edit User");
                $('#btn-save').val("edit-product");
                $('#ajax-user-modal').modal('show');
                $('#user_id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#role').val(data.role);
            })
        });

        $('body').on('click', '#delete-product', function() {

            var user_id = $(this).data("id");

            if (confirm("Are You sure want to delete !")) {
                $.ajax({
                    type: "get",
                    url: "/delete-user/" + user_id,
                    success: function(data) {
                        var oTable = $('#laravel_datatable').dataTable();
                        oTable.fnDraw(false);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }
        });

    });

    if ($("#todoForm").length > 0) {
        $("#todoForm").validate({

            submitHandler: function(form) {

                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');
                $.ajax({
                    data: $('#todoForm').serialize(),
                    url: "/add-user",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#todoForm').trigger("reset");
                        $('#ajax-user-modal').modal('hide');
                        $('#btn-save').html('Save Changes');
                        var oTable = $('#laravel_datatable').dataTable();
                        oTable.fnDraw(false);

                    },
                    error: function(data) {
                        if (data.status === 422) {
                            var errors = $.parseJSON(data.responseText);
                            $.each(errors, function(key, value) {
                                if ($.isPlainObject(value)) {
                                    $.each(value, function(key, value) {
                                        $('#invalid-' + key).html(value)
                                    });
                                }
                            });
                        }
                    }
                });
            }
        })
    }
</script>
@endsection