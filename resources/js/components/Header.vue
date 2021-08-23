<template>
  <nav id="navbar" class="navbar navbar-expand-md navbar-blue bg-light shadow-sm">
         <div class="container">
        <div class="navbar-brand d-block d-sm-none">
            <span class="">Menu</span>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="collapse navbar-collapse" id="layout-navbar-collapse">
            <ul class="navbar-nav">
                <li v-if="user.role == 'admin'" class="nav-item">
                    <router-link to="/" class="sidenav-link"><div class="pr-3"> User List</div></router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/todo-list" class="sidenav-link">Todo List</router-link>
                </li>
            </ul>
        </div>
    </div>
  </nav>
</template>
<script>
export default {
    props:['user'],
}
</script>

<style scoped>
#navbar {
    overflow: static;
    position: relative;
    z-index: 000;
}
</style>