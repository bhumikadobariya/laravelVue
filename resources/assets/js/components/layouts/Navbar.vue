<template>
  <!-- top navigation -->
  <div class="top_nav">
    <div class="nav_menu">
      <nav>
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
          <li class="">
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              {{users.name}}
              <span class=" fa fa-angle-down"></span>
            </a>
            <ul class="dropdown-menu dropdown-usermenu pull-right">
              <li><a @click="logout()" class="btn btn-default col-sm-12" ><i class="fa fa-sign-out pull-right"></i>Logout</a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <!-- /top navigation -->
</template>

<script>

export default {
  ready() {
      this.getProfile();
  },
  data () {
    return {
      users: {},
    }
  },
  methods: {
    getProfile () {
      this.$http({url: '/api/getProfile', method: 'GET'}).then(function (response) {
        console.log(response.data);
        this.$set('users', response.data)
      })
    },
  logout () {
      this.$http({url: '/logout', method: 'POST'}).then(function (response) {
          console.log(response.data);
          setTimeout(function(){
            window.location.reload();
          }, 200);
        })
      }
    }

}
</script>
