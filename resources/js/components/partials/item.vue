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
          <span class="itemNewPrice ml-2"> {{ item.price }} ₽</span>
        </div>
        <a :href="item.url" class="btn btn-primary">Перейти</a>

        <span
          v-if="!this.deleteFlag"
          @click="$emit('add-wish', item.id)"
          style="font-size: 30px; cursor: pointer"
          >+</span
        >
        <span
          v-else
          @click="$emit('delete-wish', item.id)"
          style="font-size: 30px; cursor: pointer"
          >Удалить</span
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Item",
  props: ["item", "deleteFlag"],
  data() {
    return {};
  },
};
</script>

<style scoped>
.itemOldPrice {
  text-decoration: line-through;
  font-size: 17px;
  line-height: 25px;
}
.itemNewPrice {
  color: #bf1429;
  font-size: 17px;
  line-height: 25px;
}
</style>
