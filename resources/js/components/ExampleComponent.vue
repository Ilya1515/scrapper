<template>
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">Фильтр</div>
          <div class="dc">
            {{ filterStores }}
          </div>
          <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01"
              >Сортировка цены</label
            >
          </div>
          <select
            @change="sortPrice($event.target.value)"
            class="custom-select"
            id="inputGroupSelect01"
          >
            <option @click="sortPriceMax" selected value="1">
              По убыванию
            </option>
            <option @click="sortPriceMin" value="2">По возрастанию</option>
          </select>
        </div>

        <div class="input-group">
          <div
            class="input-group-text"
            style="width: 100%"
            v-bind:key="i"
            v-for="(store, key, i) in this.stores"
          >
            <input
              type="checkbox"
              aria-label="Checkbox for following text input"
              :id="key"
              :value="store.store"
              v-model="filterStores"
            />
            <label style="margin-left: 10px" :for="key">{{
              store.store
            }}</label>
          </div>
        </div>

        <div class="input-group">
          <div
            class="input-group-text"
            style="width: 100%"
            v-bind:key="i"
            v-for="(brand, key, i) in this.brands"
          >
            <input
              type="checkbox"
              aria-label="Checkbox for following text input"
              :id="key"
              :value="brand.brand"
              v-model="filterBrands"
            />
            <label style="margin-left: 10px" :for="key">{{
              brand.brand
            }}</label>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div class="row">
          <Item
            v-show="!loading"
            v-for="(item, index) in this.items"
            :item="item"
            v-bind:key="index"
            class="feed"
          >
          </Item>
        </div>

        <clip-loader
          :loading="loading"
          :color="color"
          :size="size"
        ></clip-loader>
      </div>
    </div>
  </div>
</template>

<script>
import Item from "./partials/Item";

import ClipLoader from "vue-spinner/src/ClipLoader.vue";
export default {
  //   props: ["item"],
  components: { Item, ClipLoader },
  data() {
    return {
      items: null,
      sortedItems: null,
      brands: null,
      filterBrands: [],
      stores: [{ store: "farfetch" }],
      filterStores: [],
      checked: 0,
      priceSortFlag: null,
      loading: true,
      color: "#222",
      size: "24px",
    };
  },
  mounted() {
    console.log("Component mounted.");
    // setTimeout(() => {
    //   this.getItems();
    // }, 6000);
    this.getItems();
  },
  watch: {
    filterBrands: function () {
      let app = this;
      if (app.filterBrands.length == 0) {
        app.getItems();
        console.log("empty");
      } else {
        app.getSortedByBrand(app.filterBrands);
      }
      app.filterBrands.forEach(function (item, index, array) {
        app.sortedItems = app.items.filter((i) => i.brand == item);
      });

      //   return this.items.reverse();
      //   // console.log(this.items);
    },
    filterStores: function () {
      let app = this;
      if (app.filterStores.length == 0) {
        app.getItems();
        console.log("empty");
      } else {
        app.getSortedByStore(app.filterStores);
      }
      app.filterBrands.forEach(function (item, index, array) {
        app.sortedItems = app.items.filter((i) => i.store_name == item);
      });

      //   return this.items.reverse();
      //   // console.log(this.items);
    },
  },
  methods: {
    getSortedByBrand: function (arr) {
      let app = this;
      app.loading = true;
      axios.post("api/brand", arr).then(function (res) {
        console.log(res.data);
        app.items = res.data.items;
        // app.brands = res.data.brands;
        app.loading = false;
        if (app.priceSortFlag == 2) {
          app.sortPriceMin();
          console.log("items");
        }
      });
    },
    getSortedByStore: function (arr) {
      let app = this;
      app.loading = true;
      axios.post("api/stores", arr).then(function (res) {
        console.log(res.data);
        app.items = res.data.items;
        // app.brands = res.data.brands;
        app.loading = false;
        if (app.priceSortFlag == 2) {
          app.sortPriceMin();
          console.log("items");
        }
      });
    },
    getItems: function () {
      let app = this;

      axios.post("api/index").then(function (res) {
        console.log(res.data);
        app.items = res.data.items;
        app.brands = res.data.brands;
        app.loading = false;
        if (app.priceSortFlag == 2) {
          app.sortPriceMin();
          console.log("items");
        }
      });
    },
    sortPriceMin: function () {
      return this.items.sort((a, b) => {
        return a.price - b.price;
      });
    },
    sortPriceMax: function () {
      return this.items.sort((a, b) => {
        return b.price - a.price;
      });
    },
    sortPrice: function (value) {
      this.priceSortFlag = value;
      if (value == 1) {
        this.sortPriceMax();
      } else {
        this.sortPriceMin();
      }
    },
    sortBrand: function (value) {
      console.log(value);
    },
  },
};
</script>
<style lang="scss" scoped>
[v-cloak] {
  display: none !important;
}
// [v-cloak] {
//   display: block;
//   padding: 50px 0;

//   @keyframes spinner {
//     to {
//       transform: rotate(360deg);
//     }
//   }

//   &:before {
//     content: "";
//     box-sizing: border-box;
//     position: absolute;
//     top: 50%;
//     left: 50%;
//     width: 20px;
//     height: 20px;
//     margin-top: -10px;
//     margin-left: -10px;
//     border-radius: 50%;
//     border: 2px solid #ccc;
//     border-top-color: #333;
//     animation: spinner 0.6s linear infinite;
//     text-indent: 100%;
//     white-space: nowrap;
//     overflow: hidden;
//   }

//   & > div {
//     display: none;
//   }
// }
</style>
