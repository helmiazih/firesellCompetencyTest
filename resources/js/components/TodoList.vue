<template>
  <div class="container">
    <h2>Todo List</h2>
    <button
      id="element2"
      class="btn btn-success add-new"
      data-toggle="modal"
      data-target="#addNewTodo"
    >
      Add New <i class="fas fa-tasks fa-fw"></i>
    </button>
    <create />
    <edit />
    <div class="pt-3">
      <table class="table table-bordered table-striped" id="laravel_datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>No.</th>
            <th>Body</th>
            <th>Complete</th>
            <th>User</th>
            <th>Created at</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</template>

<script>
import Create from "./CreateTodo.vue";
import Edit from "./EditTodo.vue";
import EventBus from "../event-bus";
export default {
  components: { Create, Edit },
  data: function () {
    return {
      users: {},
    };
  },
  created() {
    $(document).ready(function () {
      $.ajaxSetup({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
      });
      $("#laravel_datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "/todo",
          type: "GET",
        },
        columns: [
          {
            data: "id",
            name: "id",
            visible: false,
          },
          {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            orderable: false,
            searchable: false,
          },
          {
            data: "body",
            name: "body",
          },
          {
            data: "is_complete",
            name: "is_complete",
          },
          {
            data: "user.name",
            name: "user.name",
          },
          {
            data: "created_at",
            name: "created_at",
          },
          {
            data: "action",
            name: "action",
            orderable: false,
          },
        ],
        order: [[0, "desc"]],
      });
    });

    $("body").on("click", ".edit-todo", function () {
      var todo_id = $(this).data("id");
      $.get('todo-list/' + todo_id + '/edit', function (data) {
        $("#editTodo").modal("show");
        EventBus.$emit("editTodoInfo", data);
      });
    });

    $("body").on("click", "#delete-todo", function () {
      var todo_id = $(this).data("id");

      if (confirm("Are You sure want to delete !")) {
        $.ajax({
          type: "get",
          url: "/todo-list/delete/" + todo_id,
          success: function (data) {
            toast.fire({
              icon: "success",
              title: "Todo deleted successfully",
            });

            var oTable = $("#laravel_datatable").dataTable();
            oTable.fnDraw(false);
          },
          error: function (data) {
            console.log("Error:", data);
          },
        });
      }
    });
  },
  methods: {},
};
</script>