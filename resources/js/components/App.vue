<template>
<div>
    <div class="page-loader">
    <div class="bg-primary"></div>
  </div>

  <div class="layout-wrapper layout-2" id="app">
    <div class="layout-inner">
      <div class="layout-container">
        <navbar :user="user"/>
     <div class="layout-content">
         <div class="container-fluid flex-grow-1 container-p-y">
            <div class="row">
                <router-view></router-view>
                <vue-progress-bar></vue-progress-bar>
            </div>
         </div>
        </div>
      </div>

    </div>

    <div class="layout-overlay layout-sidenav-toggle"></div>
  </div>

</div>
</template>

<script>

import Navbar from './Header';

export default {
    props:['user'],
    components:{
        Navbar
    },
    created () {

  }
}

</script>

