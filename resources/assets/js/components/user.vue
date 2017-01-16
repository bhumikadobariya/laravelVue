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

      <!-- top tiles -->
      <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
          <div class="count">{{users.length}}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-clock-o"></i> OAuth Clients</span>
          <div class="count">{{oauthclients.length}}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-user"></i> Personal Access Tokens</span>
          <div class="count green">{{personalAccessTokens.length}}</div>
        </div>
      </div>
      <!-- /top tiles -->


      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="dashboard_graph">

            <div class="row x_title">
              <div class="col-md-6">
                <h3>Network Activities <small>Graph title sub-title</small></h3>
              </div>
              <div class="col-md-6">
                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                  <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                </div>
              </div>
            </div>

            <div class="col-md-9 col-sm-9 col-xs-12">
              <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
              <div style="width: 100%;">
                <div id="canvas_dahs" class="demo-placeholder" style="width: 100%; height:270px;"></div>
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
              <div class="x_title">
                <h2>Top Campaign Performance</h2>
                <div class="clearfix"></div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-6">
                <div>
                  <p>Facebook Campaign</p>
                  <div class="">
                    <div class="progress progress_sm" style="width: 76%;">
                      <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80"></div>
                    </div>
                  </div>
                </div>
                <div>
                  <p>Twitter Campaign</p>
                  <div class="">
                    <div class="progress progress_sm" style="width: 76%;">
                      <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-6">
                <div>
                  <p>Conventional Media</p>
                  <div class="">
                    <div class="progress progress_sm" style="width: 76%;">
                      <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40"></div>
                    </div>
                  </div>
                </div>
                <div>
                  <p>Bill boards</p>
                  <div class="">
                    <div class="progress progress_sm" style="width: 76%;">
                      <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="clearfix"></div>
          </div>
        </div>
      </div>


      <div class="page-title">
        <div class="title_left">
          <h3>Dashboard</h3>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">

        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="x_panel tile">
            <div class="x_title">
              <h2>Users</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0">
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
                  <td class="col-md-3">
                    <div class="nav align-centre">
                      <a @click="editPassword(user)"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                      <a @click="edit(user)"><i class="fa fa-gear"></i></a>&nbsp;&nbsp;&nbsp;
                       <a @click="deleteUser(user)"><i class="fa fa-remove"></i></a>
                    </div>
                  </td>
                </tr>
              </table>

            </div>
          </div>
        </div>

        <passport_clients></passport_clients>
        <passport_authorized_clients></passport_authorized_clients>
        <passport_personal_access_tokens></passport_personal_access_tokens>

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
            <!-- Form Errors -->
            <div class="alert alert-danger" v-if="errorsPasswordForm.errors.length > 0">
              <p><strong>Whoops!</strong> Something went wrong!</p>
              <br>
              <div v-if="errorsPasswordForm.errors">

                  {{ errorsPasswordForm.errors }}

              </div>
            </div>

            <!-- Edit user Password Form-->
            <form class="form-horizontal" role="form">

              <!-- New Password -->
              <div class="form-group">
                <label class="col-md-3 control-label">New Password</label>

                <div class="col-md-7">
                  <input id="password" type="password" name="password" type="text" class="form-control"
                                              @keyup.enter="updatePassword"  v-model="userPassword.password"/>


                </div>
              </div>
              <!-- Confirmation Password -->
              <div class="form-group">
                <label class="col-md-3 control-label">Confirmation Password</label>

                <div class="col-md-7">
                  <input id="password-confirm" type="password" name="password_confirmation" type="text" class="form-control"
                                              @keyup.enter="updatePassword"  v-model="userPassword.password_confirmation"/>


                </div>
              </div>
            </form>
          </div>

          <!-- Modal Actions -->
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <button type="button" class="btn btn-primary" @click="updatePassword">
             Update Password
            </button>
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
    this.fetchOAuthClients();
    this.fetchPersonalAccessTokens();
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
      oauthclients: {},
      personalAccessTokens: {},
      errorsEditForm:{
        name:null,
        email:null
      },

      errorsPasswordForm:{
        errors:null
      },

      editForm: {
        name: '',
        email: ''
      },

      userPassword: {
        password:'',
        password_confirmation:''
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
        'post', '/api/user/' + this.userPassword.id +'/updatePassword',
        this.userPassword, '#modal-edit-password'
      );
    },
    /**
     * Persist the Users to storage using the given form.
     */
    persistUsersPassword(method, uri, form, modal) {
      form.errors = [];
      console.log(method, uri, form, modal, "whole data");
      this.$http[method](uri, form)
        .then(response => {
          this.fetchUsers();

          form.password = '';
          form.password_confirmation = '';
          form.errors = [];

          $(modal).modal('hide');
        })
        .catch(response => {
          var Data = JSON.parse(response.body);
          if (typeof response.data === 'object') {
              this.errorsPasswordForm.errors = Data.errors;
          } else {
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
          this.errorsEditForm.name = this.errorsEditForm.email = null;
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

    fetchOAuthClients () {
      this.$http({url: '/oauth/clients', method: 'GET'}).then(function (response) {
        console.log(response.data);
        this.$set('oauthclients', response.data)
      })
    },

    fetchPersonalAccessTokens () {
      this.$http({url: '/oauth/personal-access-tokens', method: 'GET'}).then(function (response) {
        console.log(response.data);
        this.$set('personalAccessTokens', response.data)
      })
    }
  }
}
</script>
