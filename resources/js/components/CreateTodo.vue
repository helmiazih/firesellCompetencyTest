<template>
  <div>
    <div class="modal fade" id="addNewTodo" tabindex="-1" role="dialog" aria-labelledby="addNewUserLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewUserLabel">Add New</h5>
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
              @submit.prevent="addNewTodo"
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
                  Add Todo
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
export default {
  data: function () {
    return {
      users: [],
      newAddedUser: "",
      form: new Form({
        name: "",
        email: "",
        role: "",
        password: "",
      }),
    };
  },
  methods: {
    addNewTodo(){
            this.$Progress.start();
            this.form.post('/todo-list/store')
            .then( response => {

                this.form.reset();
                toast.fire({
                icon: 'success',
                title: 'Todo created successfully'
                });
                $('#addNewTodo').modal('hide');
                this.$Progress.finish()

                var oTable = $('#laravel_datatable').dataTable();
                oTable.fnDraw(false);
              })
              .catch( error => {
                  this.$Progress.fail()
                  swal("Wrong!", "Something went wrong!", "error");
              })
        },
  },
};
</script>

<style scoped>

</style>
