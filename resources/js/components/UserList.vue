<template>
  <div class="container">
    <h2>User List</h2>
    <button
      id="element2"
      class="btn btn-success add-new"
      data-toggle="modal"
      data-target="#addNewUser"
    >
      Add New <i class="fas fa-user-plus fa-fw"></i>
    </button>
    <create/>
    <edit/>
    <br /><br />

    <table class="table table-bordered table-striped" id="laravel_datatable">
      <thead>
        <tr>
          <th>ID</th>
          <th>No.</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Created at</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</template>

<script>
import Create from "./Create.vue";
import Edit from "./Edit.vue";
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
          url: "/",
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
            data: "name",
            name: "name",
          },
          {
            data: "email",
            name: "email",
          },
          {
            data: "role",
            name: "role",
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

    $("body").on("click", "#delete-product", function () {
      var user_id = $(this).data("id");

      if (confirm("Are You sure want to delete !")) {
        $.ajax({
          type: "get",
          url: "/delete-user/" + user_id,
          success: function (data) {
            toast.fire({
              icon: "success",
              title: "User deleted successfully",
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

    $("body").on("click", ".edit-product", function () {
      var user_id = $(this).data("id");
      $.get("/edit-user/" + user_id, function (data) {
        $("#editUser").modal("show");
        EventBus.$emit("editUserInfo", data);
      });
    });
  },
  methods: {
  },
};
</script>