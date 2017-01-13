<template>
  <div class="container body">
    <div class="main_container">
      <sidebar></sidebar>
      <navbar></navbar>
      <user></user>
      <Footers></Footers>
    </div>
  </div>
</template>


<script>
import Navbar from './layouts/Navbar.vue'
import Sidebar from './layouts/Sidebar.vue'
import Footers from './layouts/Footers.vue'
import user from './user.vue'

export default {
  components: {
    Navbar,
    Sidebar,
    Footers,
    user
  },
  replace: false
}
</script>
