<template>
  <div class="container">
    <div class="row">
      <h1 v-if="user">{{ user.name }}</h1>
      <h2 v-if="user">{{ user.email }}</h2>
      {{ user.email_delivery }} - email
      <div v-if="!user.email_delivery" @click="subEmail()">
        Подписаться на рассылку
      </div>
      <div v-else @click="unsubEmail()">Отписаться от рассылки</div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: null,
    };
  },

  mounted() {
    setTimeout(() => {
      this.getUser();
    }, 1000);
  },
  watch: {
    user: function () {
      this.user = this.$root.$data.user;

      console.log(this.$root.$data.user, "mounted");
    },
  },
  methods: {
    getUser: function () {
      this.user = this.$root.$data.user;
      console.log(this.$root.$data.user, "mounted");
      // this.user = this.$root.$data.user;
    },

    subEmail: function () {
      axios
        .post("/api/user/sub-email", { id: this.$root.$data.user.id })
        .then((res) => {
          this.$root.$data.user = res.data.succses;
          this.user = res.data.succses;
        });
      // console.log(this.$root.$data.user, "mounted");
      // this.user = this.$root.$data.user;
    },
    unsubEmail: function () {
      axios
        .post("/api/user/unsub-email", { id: this.$root.$data.user.id })
        .then((res) => {
          this.$root.$data.user = res.data.succses;
          this.user = res.data.succses;
        });
      // console.log(this.$root.$data.user, "mounted");
      // this.user = this.$root.$data.user;
    },
  },
};
</script>

<style>
</style>