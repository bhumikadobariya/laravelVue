<style scoped>
  .action-link {
    cursor: pointer;
  }

  .m-b-none {
    margin-bottom: 0;
  }
</style>

<template>
   <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Dashboard</h3>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Users</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                  </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tr>
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
                <tr v-for="user in users">
                  <td>
                    {{user.name}}
                  </td>
                  <td>{{user.email}}</td>
                  <td class="col-sm-3">
                    <div class="btn-group">
                        <button class="btn btn-primary" @click="editPassword(user)">
                          Edit Password
                        </button>
                        <button class="btn btn-warning" @click="edit(user)">
                          Edit
                        </button>
                        <button class="btn btn-danger" @click="deleteUser(user)">
                          Delete
                        </button>
                    </div>
                  </td>
                </tr>
              </table>

              <passport_clients></passport_clients>
              <passport_authorized_clients></passport_authorized_clients>
              <passport_personal_access_tokens></passport_personal_access_tokens>

            </div>
          </div>
        </div>

      </div>
      <!-- Edit user Modal -->
    <div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            <h4 class="modal-title">
              Edit user
            </h4>
          </div>

          <div class="modal-body">
            <!-- Form Errors -->
            <div class="alert alert-danger" v-if="editForm.errors.length > 0">
              <p><strong>Whoops!</strong> Something went wrong!</p>
              <br>
              <ul>
                <!-- <li v-for="error in editForm.errors">
                  {{ error }}
                </li> -->
              </ul>
            </div>

            <!-- Edit user Form -->
            <form class="form-horizontal" role="form">
              <!-- Name -->
              <div class="form-group">
                <label class="col-md-3 control-label">Name</label>

                <div class="col-md-7">
                  <input id="edit-user-name" type="text" class="form-control"
                                              @keyup.enter="update" v-model="editForm.name">

                  <span class="error text-danger" v-if="errorsEditForm.name">
                    @{{ errorsEditForm['name'] }}
                  </span>
                </div>
              </div>

              <!-- Email -->
              <div class="form-group">
                <label class="col-md-3 control-label">Email</label>

                <div class="col-md-7">
                  <input type="text" class="form-control" name="email"
                                  @keyup.enter="update" v-model="editForm.email">

                  <span class="error text-danger" v-if="errorsEditForm.email">
                    @{{ errorsEditForm['email'] }}
                  </span>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal Actions -->
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <button type="button" class="btn btn-primary" @click="update">
              Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>
      <!-- Edit user Password -->
    <div class="modal fade" id="modal-edit-password" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            <h4 class="modal-title">
              Edit User's Password
            </h4>
          </div>

          <div class="modal-body">

            <!-- Edit Password Form -->
            <form class="form-horizontal" role="form">
              <!-- Password -->
              <div class="form-group">
                <label class="col-md-3 control-label">Old Password</label>

                <div class="col-md-7">
                  <input id="old_password" name="old_password" type="text" class="form-control"
                                              @keyup.enter="updatePassword"/>

                  <!-- <span class="error text-danger" v-if="errorsEditForm.name">
                    @{{ errorsEditForm['name'] }}
                  </span> -->
                </div>
                <br/>
                <div class="form-group">
                <label class="col-md-3 control-label">New Password</label>

                <div class="col-md-7">
                  <input id="password" name="password" type="text" class="form-control"
                                              @keyup.enter="updatePassword"/>

                  <!-- <span class="error text-danger" v-if="errorsEditForm.name">
                    @{{ errorsEditForm['name'] }}
                  </span> -->
                </div>
              </div>

            </form>
          </div>

          <!-- Modal Actions -->
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <button type="button" class="btn btn-primary" @click="updatePassword">
             update password
            </button>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</template>

<script>

// import { stack_bottomright, show_stack_success, show_stack_error, show_stack_info } from './../Pnotice.js'
import passport_clients from './passport/Clients.vue'
import passport_authorized_clients from './passport/AuthorizedClients.vue'
import passport_personal_access_tokens from './passport/PersonalAccessTokens.vue'

export default {
  components: {
    passport_clients,
    passport_authorized_clients,
    passport_personal_access_tokens
  },

  ready () {
    this.fetchUsers();
    this.prepareComponent();
  },
  /**
   * Prepare the component (Vue 2.x).
   */
  mounted() {
    this.prepareComponent();
  },
  data () {
    return {
      users: {},
      errorsEditForm:{
        name:null,
        email:null
      },

      editForm: {
        errors: [],
        name: '',
        email: '',
        password:''
      },

      userPassword: {
        password:'',
        old_password:''
      }
    }
  },
  methods: {
    /**
     * Prepare the component.
     */
    prepareComponent() {
      // this.fetchUsers();

      $('#modal-edit-user').on('shown.bs.modal', () => {
        $('#edit-user-name').focus();
      });

      $('#modal-edit-password').on('shown.bs.modal', () => {
        $('#old_password').focus();
      });
    },
    fetchUsers () {
      this.$http({url: '/api/users', method: 'GET'}).then(function (response) {
        console.log(response.data);
        this.$set('users', response.data)
      })
    },
    deleteUser (user) {
      let self = this
      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this user!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it',
      }).then(function() {
        self.users.$remove(user)
        self.$http.delete('/api/users/' + user.id, user).then(function (response) {
          swal(
            'Deleted!',
            'Your user has been deleted.',
            'success'
          );
        }, function (response){
          show_stack_error('Failed to delete user', response)
        })
      }, function(dismiss) {
        // dismiss can be 'cancel', 'overlay', 'close', 'timer'
        if (dismiss === 'cancel') {
          swal(
            'Cancelled',
            'Your user is safe :)',
            'error'
          );
        }
      });
    },

    editPassword(user) {
      this.userPassword.id = user.id;
      this.userPassword.password = user.password;

      $('#modal-edit-password').modal('show');
    },
    /**
     * Edit the given user.
     */
    edit (user) {
      this.editForm.id = user.id;
      this.editForm.name = user.name ? user.name: null;
      this.editForm.email = user.email;

      $('#modal-edit-user').modal('show');
    },
    /**
     * Update the Users being edited.
     */
    update() {
      this.persistUsers(
        'put', '/api/users/' + this.editForm.id,
        this.editForm, '#modal-edit-user'
      );
    },

    updatePassword() {
      this.persistUsersPassword(
        'post', '/api/user/' + this.users.id +'/updatePassword',
        this.userPassword, '#modal-edit-password'
      );
    },
    /**
     * Persist the Users to storage using the given form.
     */
    persistUsersPassword(method, uri, form, modal) {
      form.errors = [];
      console.log(uri,"yyyyyyyyy");

      this.$http[method](uri, form)
        .then(response => {
          // this.errorsEditForm.name= this.errorsEditForm.email = null;
          this.fetchUsers();

          form.password = '';
          form.old_password = '';
          form.errors = [];

          $(modal).modal('hide');
        })
        .catch(response => {
          var Data = JSON.parse(response.body);
          if (typeof response.data === 'object') {
              // this.errorsEditForm.name = Data.errors.name;
              // this.errorsEditForm.email = Data.errors.email;
          } else {
            // this.errorsEditForm.name= this.errorsEditForm.email = null;
            form.errors = ['Something went wrong. Please try again.'];
          }
        });
    },
    /**
     * Persist the Users to storage using the given form.
     */
    persistUsers(method, uri, form, modal) {
      form.errors = [];

      this.$http[method](uri, form)
        .then(response => {
          this.errorsEditForm.name= this.errorsEditForm.email = null;
          this.fetchUsers();

          form.name = '';
          form.email = '';
          form.errors = [];

          $(modal).modal('hide');
        })
        .catch(response => {
          var Data = JSON.parse(response.body);
          if (typeof response.data === 'object') {
              this.errorsEditForm.name = Data.errors.name;
              this.errorsEditForm.email = Data.errors.email;
          } else {
            this.errorsEditForm.name= this.errorsEditForm.email = null;
              form.errors = ['Something went wrong. Please try again.'];
          }
        });
    },
  }
}
</script>
