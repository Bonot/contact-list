<template>
  <nav aria-label="...">
    <ul class="pagination pagination-lg justify-content-center">
      <li
        v-if="showPrevious"
        class="page-item"
        @click="changePage(current - 1)">
        <a class="page-link" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <li
        v-for="(page) in pages"
        :key="page"
        class="page-item"
        :class="{ current: page === current }"
        @click="changePage(page)">
        <a class="page-link" href="#">
          {{ page }}
        </a>
      </li>

      <li
        v-if="showNext"
        class="page-item"
        @click="changePage(current + 1)">
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>

    </ul>
  </nav>
</template>

<script>
export default {
  name: 'Pagination',
  props: {
    offset: {
      type: [String, Number],
      default: 0,
    },
    total: {
      type: [String, Number],
      required: true,
    },
    limit: {
      type: [String, Number],
      default: 10,
    },
  },
  computed: {
    showPrevious() {
      return this.current > 1;
    },
    showNext() {
      return this.total > this.limit * this.current;
    },
    current() {
      return this.offset == 0 ? 1 : this.offset;
    },
    pages() {
      const qty = Math.ceil(this.total / this.limit);
      if (qty <= 1) return [1];
      return Array.from(Array(qty).keys(), (i) => i + 1);
    },
  },
  methods: {
    changePage(offset) {
      this.$emit('change-page', offset);
    },
  },
};
</script>