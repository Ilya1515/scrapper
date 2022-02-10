<template>
  <div class="coninater">
    <router-link to="/"> <h1>Finder</h1></router-link>
    <div @click="root()">auth - {{ $root.$data.auth }}</div>

    <router-link v-if="!$root.$data.auth" to="/login">Логин</router-link>
    <router-link v-if="!$root.$data.auth" to="/register"
      >Регистрация</router-link
    >
    <router-link v-if="$root.$data.auth" to="/wish">Wish-list</router-link>
    <router-link v-if="$root.$data.auth" to="/user">Личный кабинет</router-link>
    <div
      style="color: grey, text-decoration: underline;"
      v-if="$root.$data.auth"
      @click.prevent="logout()"
    >
      Выход
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  watch: {},

  created() {},
  methods: {
    root: function () {
      this.$root.$data.auth = !this.$root.$data.auth;
    },

    logout: function () {
      axios.post("/api/auth/logout", {}).then((res) => console.log(res));
      this.$root.$data.deleteCookie("Authorization");
      this.$root.$data.auth = false;
    },
  },
};
</script>

<style>
</style>