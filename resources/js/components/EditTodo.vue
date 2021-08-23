<template>
  <div>
    <div class="modal fade" id="editTodo" tabindex="-1" role="dialog" aria-labelledby="addNewUserLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewUserLabel">Edit User</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form
              @submit.prevent="editTodo"
              @keydown="form.onKeydown($event)"
            >
              <div class="form-group">
                <input
                  v-model="form.body"
                  type="text"
                  name="body"
                  placeholder="Name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('body') }"
                />
                <has-error :form="form" field="body"></has-error>
              </div>
              <div class="form-group">
                <select
                  name="is_complete"
                  v-model="form.is_complete"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('is_complete') }"
                >
                  <option value="">Please Select...</option>
                  <option value="1">Complete</option>
                  <option value="0">Incomplete</option>
                </select>
                <has-error :form="form" field="is_complete"></has-error>
              </div>
              <div class="pull-right">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                >
                  Close
                </button>
                <button
                  :disabled="form.busy"
                  type="submit"
                  class="btn btn-primary"
                >
                  Edit Todo
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from "../event-bus";
export default {
  data: function () {
    return {
      form: new Form({
        id: "",
        body: "",
        is_complete: "",
      }),
    };
  },
  mounted() {
    EventBus.$on("editTodoInfo", (data) => {
      this.form.fill(data);
    });
  },
  methods: {
    editTodo(){
            this.$Progress.start();
            this.form.post('/todo-list/update')
            .then( response => {

                this.form.reset();
                toast.fire({
                icon: 'success',
                title: 'Todo edited successfully'
                });
                $('#editTodo').modal('hide');
                this.$Progress.finish()

                var oTable = $('#laravel_datatable').dataTable();
                oTable.fnDraw(false);
              })
              .catch( error => {
                  console.log(error)
                  this.$Progress.fail()
                  swal("Wrong!", "Please fill all the required feild!", "error");
              })

        },
  },
};
</script>
