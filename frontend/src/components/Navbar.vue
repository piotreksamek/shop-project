<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="white">
      <b-navbar-brand href="/">NAZWA PROJEKTU</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item href="#">{{ t('navbar.category') }}</b-nav-item>
        </b-navbar-nav>

        <b-navbar-nav class="mx-auto">
          <b-nav-item>
            <b-form-input size="sm" class="mr-sm-2" placeholder="Search" style="width: 300px;"></b-form-input>
          </b-nav-item>
        </b-navbar-nav>

        <b-navbar-nav class="ml-auto">
          <b-nav-item href="#" disabled>
            <b-button size="sm" class="my-2 mr-sm-2"><i class="bi bi-heart"></i></b-button>
          </b-nav-item>
          <b-nav-item href="#" disabled>
            <b-button size="sm" class="my-2 mr-sm-2"><i class="bi bi-basket3"></i></b-button>
          </b-nav-item>

          <b-nav-item-dropdown text="Twoje konto" right>
            <b-dropdown-item v-if="!authStore.user" @click="router.push('/login')">{{ t('navbar.login') }}</b-dropdown-item>
            <b-dropdown-item v-if="!authStore.user" @click="router.push('/register')">{{ t('navbar.register') }}</b-dropdown-item>
            <b-dropdown-item v-if="authStore.user" @click="router.push('/product/create')">{{ t('navbar.products') }}</b-dropdown-item>
            <b-dropdown-item v-if="authStore.user" @click="logout">{{ t('navbar.logout') }}</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>
<script setup lang="ts">
import router from "@/router";
import {useAuthStore} from "@/stores/authStore.ts";
import {useI18n} from "vue-i18n";
const { t } = useI18n();
const authStore = useAuthStore();

function logout() {
  authStore.logout();

  router.push('login');
}
</script>
