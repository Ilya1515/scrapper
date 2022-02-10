<template>
  <div>
    <div class="container">
      <h1 @click="register()">Зарегистрироваться</h1>
      <div class="row">
        <form v-on:keyup.enter="register()">
          <input type="text" v-model="name" placeholder="Ваше имя" />
          <input type="email" v-model="email" placeholder="Электронный адрес" />
          <input type="password" v-model="password" placeholder="Пароль" />
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      password: null,
      name: null,
      email: null,
    };
  },

  methods: {
    register: function () {
      axios
        .post("api/auth/register", {
          name: this.name,
          password: this.password,
          email: this.email,
        })
        .then((res) => {
          this.$router.push({ name: "login" });
        });
    },
  },
};
</script>

<style>
</style>