@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Todo List</h2>
    <a href="javascript:void(0)" class="btn btn-info " id="create-new-product">Add New</a>
    <br><br>
    <table class="table table-bordered table-striped" id="laravel_datatable">
        <thead>
            <tr>
                <th>ID </th>
                <th>No. </th>
                <th>Body</th>
                <th>Complete</th>
                <th>User</th>
                <th>Created at</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<div class="modal fade" id="ajax-product-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="productCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="todoForm" name="todoForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Body</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="body" name="body" placeholder="Enter Body" value="" maxlength="50">
                            <span class="invalid-body text-danger" id="invalid-body" role="alert">
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

<div class="modal fade" id="ajax-product-modal2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="productCrudModal2">Edit Todo</h4>
            </div>
            <div class="modal-body">
                <form id="todoForm2" name="todoForm2" class="form-horizontal">
                    <div class="form-group">
                        <input type="text" name="todo_id" id="todo_id" value="" hidden>
                        <label for="body_edit" class="col-sm-2 control-label">Body</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="body_edit" name="body_edit" placeholder="Enter Body" value="" maxlength="50">
                            <span class="invalid-body-edit text-danger" id="invalid-body-edit" role="alert">
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="complete_edit" class="col-sm-2 control-label">Complete</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="complete_edit" id="complete_edit">
                                <option value="{{ \App\Models\TodoList::STATUS_INCOMPLETE }}">Incomplete
                                </option>
                                <option value="{{ \App\Models\TodoList::STATUS_COMPLETE }}">Complete
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save2" value="create">Save
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
                url: "/todo",
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
                    data: 'body',
                    name: 'body'
                },
                {
                    data: 'is_complete',
                    name: 'is_complete'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
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

        $('#create-new-product').click(function() {
            $('#btn-save').val("create-product");
            $('#todoForm').trigger("reset");
            $('#productCrudModal').html("Add New Todo");
            $('#ajax-product-modal').modal('show');
        });

        $('body').on('click', '.edit-product', function() {
            var product_id = $(this).data('id');
            console.log(product_id);
            $.get('todo-list/' + product_id + '/edit', function(data) {
                $('#body-error').hide();
                $('#product_code-error').hide();
                $('#description-error').hide();
                $('#btn-save2').val("edit-product");
                $('#ajax-product-modal2').modal('show');
                $('#todo_id').val(data.id);
                $('#user_id').val(data.user_id);
                $('#body_edit').val(data.body);
                $('#complete_edit').val(data.is_complete);
            })
        });

        $('body').on('click', '#delete-product', function() {

            var product_id = $(this).data("id");

            if (confirm("Are You sure want to delete !")) {
                $.ajax({
                    type: "get",
                    url: "/todo-list/delete/" + product_id,
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
                    url: "/todo-list/store",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#todoForm').trigger("reset");
                        $('#ajax-product-modal').modal('hide');
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

    if ($("#todoForm2").length > 0) {
        $("#todoForm2").validate({

            submitHandler: function(form) {

                var actionType = $('#btn-save2').val();
                $('#btn-save2').html('Sending..');

                $.ajax({
                    data: $('#todoForm2').serialize(),
                    url: "/todo-list/update",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#todoForm2').trigger("reset");
                        $('#ajax-product-modal2').modal('hide');
                        $('#btn-save2').html('Save Changes');
                        var oTable = $('#laravel_datatable').dataTable();
                        oTable.fnDraw(false);

                    },
                    error: function(data) {
                        if (data.status === 422) {
                            var errors = $.parseJSON(data.responseText);
                            $.each(errors, function(key, value) {
                                if ($.isPlainObject(value)) {
                                    $.each(value, function(key, value) {
                                        $('#invalid-' + key + '-edit').html(value)
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