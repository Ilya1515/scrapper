<template>
  <div>
    <div class="card">
      <div class="card-header">Фильтр</div>
      <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01"
          >Сортировка цены</label
        >
      </div>

      <div
        class="input-group"
        style="display: flex; justify-content: space-between"
      >
        <label>От</label>

        <input
          type="number"
          @input="$emit('min-price', $event.target.value)"
          :value="minPrice"
        />
      </div>
      <div
        class="input-group"
        style="display: flex; justify-content: space-between"
      >
        <label>До</label>
        <input
          type="number"
          @input="$emit('max-price', $event.target.value)"
          :value="maxPrice"
        />
      </div>

      <select
        @change="$emit('sort-price', $event.target.value)"
        class="custom-select"
        id="inputGroupSelect01"
      >
        <option v-on:click="$emit('sort-price-max')" selected value="1">
          По убыванию
        </option>
        <option v-on:click="$emit('sort-price-min')" value="2">
          По возрастанию
        </option>
      </select>
    </div>

    <div class="input-group mt-3">
      <label
        class="input-group-text"
        style="width: 100%; justify-content: space-between"
        >Магазин
        <strong class="expand" @click="isExpanded = !isExpanded">
          +
        </strong></label
      >

      <VueAccordion v-cloak style="width: 100%" :expanded="isExpanded">
        <div class="input-group-text" style="width: 100%">
          <div v-bind:key="i" v-for="(store, key, i) in this.stores">
            <input
              type="checkbox"
              :id="key"
              :value="store.store"
              v-model="filterStores"
            />
            <label style="margin-left: 10px" :for="key">{{
              store.store
            }}</label>
          </div>
        </div>
      </VueAccordion>
    </div>

    <div class="input-group mt-3">
      <label
        class="input-group-text"
        style="width: 100%; justify-content: space-between"
        >Бренд
        <strong class="expand" @click="isExpanded2 = !isExpanded2">
          +
        </strong></label
      >

      <VueAccordion v-cloak style="width: 100%" :expanded="isExpanded2">
        <div
          class="input-group-text"
          style="width: 100%; flex-direction: column; align-items: baseline"
        >
          <div
            style="display: flex; justify-content: space-between"
            v-bind:key="i"
            v-for="(brand, key, i) in brands"
          >
            <input
              type="checkbox"
              :id="brand.brand"
              :value="brand.brand"
              v-model="filterBrands"
              v-on:change="$emit('filter-brands', filterBrands)"
            />
            <label style="margin-left: 10px" :for="brand.brand">{{
              brand.brand
            }}</label>
          </div>
        </div>
      </VueAccordion>
    </div>
  </div>
</template>

<script>
import VueAccordion from "@ztrehagem/vue-accordion";

export default {
  props: ["brands", "stores", "minPrice", "maxPrice"],
  components: { VueAccordion },
  data() {
    return {
      sortedItems: null,
      isExpanded: true,
      isExpanded2: true,
      filterBrands: [],
      filterStores: [],
      checked: 0,
      priceSortFlag: null,
    };
  },
};
</script>

<style>
</style>