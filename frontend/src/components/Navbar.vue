<template>
  <div>
    <BNavbar toggleable="lg" type="dark" variant="white">
      <BNavbarBrand href="/">NAZWA PROJEKTU</BNavbarBrand>

      <BNavbarToggle target="nav-collapse"></BNavbarToggle>

      <BCollapse id="nav-collapse" is-nav>
        <BNavbarNav>
          <BNavItem href="#">{{ t('navbar.category') }}</BNavItem>
        </BNavbarNav>

        <BNavbarNav class="mx-auto">
          <BNavItem>
            <BFormInput size="sm" class="mr-sm-2" placeholder="Search" style="width: 300px;"></BFormInput>
          </BNavItem>
        </BNavbarNav>

        <BNavbarNav class="ml-auto">
          <BNavItem href="#" disabled>
            <BButton size="sm" class="my-2 mr-sm-2"><i class="bi bi-heart"></i></BButton>
          </BNavItem>
          <BNavItem href="#" disabled>
            <BButton size="sm" class="my-2 mr-sm-2"><i class="bi bi-basket3"></i></BButton>
          </BNavItem>

          <BNavItemDropdown text="Twoje konto" right>
            <BDropdownItem v-if="!authStore.user" @click="router.push('/login')">{{ t('navbar.login') }}</BDropdownItem>
            <BDropdownItem v-if="!authStore.user" @click="router.push('/register')">{{ t('navbar.register') }}</BDropdownItem>
            <BDropdownItem v-if="authStore.user" @click="router.push('/user/profile/setup')">{{ t('navbar.profile') }}</BDropdownItem>
            <BDropdownItem v-if="authStore.user" @click="router.push('/user/product/list')">{{ t('navbar.products') }}</BDropdownItem>
            <BDropdownItem v-if="authStore.user" @click="logout">{{ t('navbar.logout') }}</BDropdownItem>
          </BNavItemDropdown>
        </BNavbarNav>
      </BCollapse>
    </BNavbar>
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
