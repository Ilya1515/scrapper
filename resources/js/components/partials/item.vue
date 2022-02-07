<template>
  <div class="col-md-4 mb-3">
    <div class="card">
      <img class="card-img-top" :src="item.image" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">{{ item.brand }}</h5>
        <p class="card-text">
          {{ item.name }}
        </p>
        <p class="card-text">
          {{ item.description }}
        </p>
        <div>
          <span class="itemOldPrice">{{ item.old_price }}</span>
          <span class="itemNewPrice"> {{ item.price }} ₽</span>
        </div>
        <a :href="item.url" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Item",
  props: ["item"],
  data() {
    return {};
  },
};
</script>

<style scoped>
.itemOldPrice {
  text-decoration: line-through;
}
.itemNewPrice {
  color: #bf1429;
}
</style>
