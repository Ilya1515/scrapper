<template>
  <div class="container">
    <h1>Избранное</h1>

    <h2 v-if="items.length == 0">Пусто</h2>
    <div class="row">
      <Item
        v-for="(item, index) in this.items"
        v-on:delete-wish="deleteWish($event)"
        :item="item"
        :deleteFlag="true"
        v-bind:key="index"
        class="feed"
      >
      </Item>
    </div>
  </div>
</template>

<script>
import Item from "./partials/Item";

export default {
  components: { Item },
  data() {
    return {
      items: [],
    };
  },

  mounted() {
    setTimeout(() => {
      this.getItems();
    }, 1000);
  },
  methods: {
    getItems: function () {
      let app = this;
      axios
        .post("api/user/get-wish", {
          id: this.$root.$data.user.id,
        })
        .then(function (res) {
          app.items = res.data.items;
        })
        .catch((err) => alert(err.data));
    },
    deleteWish: function (id) {
      let app = this;
      axios
        .post("api/user/delete-wish", {
          item_id: id,
          user_id: this.$root.$data.user.id,
        })
        .then(function (res) {
          app.items = res.data.items;
          alert(res.data.messege);
        })
        .catch((err) => alert(err.data.error));
    },
  },
};
</script>

<style>
</style>