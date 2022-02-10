<template>
  <div class="container">
    <h2 @click="login()">Войти</h2>
    <div class="row">
      <form v-on:keyup.enter="login()">
        <input type="text" v-model="email" placeholder="Почта" />
        <input type="password" v-model="password" placeholder="Пароль" />
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      password: null,
      email: null,
    };
  },

  methods: {
    login: function () {
      axios
        .post("/api/auth/login", {
          password: this.password,
          email: this.email,
        })
        .then((res) => {
          let date = new Date(Date.now() + 60 * 24 * 30);
          date = date.toUTCString();

          let token = "Bearer " + res.data.access_token;
          this.$root.$data.setCookie("Authorization", token, {
            // expires: date,
            samesite: "lax",
          });
          this.$root.$data.auth = true;
          this.$root.$data.setApiToken(token);
          this.$router.push({ name: "index" });
        })
        .catch((err) => {
          alert(err);
        });
    },
  },
};
</script>

<style>
</style>