<template>
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div @click="filterItems()">Фильтровать</div>
        <FilterSide
          v-on:sort-price="sortPrice($event)"
          v-on:sort-price-max="sortPriceMax()"
          v-on:sort-price-min="sortPriceMin()"
          v-on:min-price="minPrice = $event"
          v-on:max-price="maxPrice = $event"
          v-on:filter-brands="filterBrands = $event"
          :brands="brands"
          :stores="stores"
          :minPrice="minPrice"
          :maxPrice="maxPrice"
        >
        </FilterSide>
      </div>

      <div class="col-md-9">
        <div class="row">
          <Item
            v-show="
              !loading && item.price >= minPrice && item.price <= maxPrice
            "
            v-for="(item, index) in this.items"
            v-on:add-wish="addWish($event)"
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
import VueAccordion from "@ztrehagem/vue-accordion";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import FilterSide from "./partials/filter.vue";
export default {
  //   props: ["item"],
  components: { Item, ClipLoader, VueAccordion, FilterSide },
  data() {
    return {
      items: null,
      brands: null,
      maxPrice: null,
      minPrice: null,
      isExpanded: true,
      isExpanded2: true,
      filterBrands: [],
      stores: [{ store: "farfetch" }],

      checked: 0,
      priceSortFlag: 1,
      loading: true,
      color: "#222",
      size: "24px",
      apiToken: null,
      errText: null,
      error: false,
    };
  },
  mounted() {
    this.getItems();
  },
  watch: {
    filterBrands: function () {
      let app = this;
      if (app.filterBrands.length == 0) {
        app.getItems();
      } else {
        app.filterItems();
      }
    },
    error: function () {
      alert(this.errText);
    },
  },
  methods: {
    getItems: function () {
      let app = this;
      axios
        .post("api/index")

        .then(function (res) {
          app.items = res.data.items;
          app.brands = res.data.brands;
          app.minPrice = res.data.min_price;
          app.maxPrice = res.data.max_price;
          app.loading = false;
          if (app.priceSortFlag == 2) {
            app.sortPriceMin();
          }
        })
        .catch(function (err) {
          app.errText = err.response.statusText;
          app.error = true;

          // console.log();
        });
    },
    filterItems: function () {
      let data = {
        brand: this.filterBrands,
        max_price: this.maxPrice,
        min_price: this.minPrice,
        sort_flag: this.priceSortFlag,
      };

      axios.post("api/filter", data).then(function (res) {
        this.items = res.data.items;
        this.minPrice = res.data.min_price;
        this.maxPrice = res.data.max_price;
      });
    },

    addWish: function (id) {
      axios
        .post("api/user/add-wish", {
          item_id: id,
          user_id: this.$root.$data.user.id,
        })
        .then(function (res) {
          alert(res.data);
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
  },
};
</script>
<style lang="scss" scoped>
</style>
