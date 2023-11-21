<template>
  <nav v-if="hasPagination">
    <p v-if="!hasData || pagination.total < 1">
      {{ translations.no_results_found }}
    </p>

    <!-- simple and mobile -->
    <div v-if="hasData">
      <component
        :is="previousPageUrl ? 'a' : 'div'"
        :href="previousPageUrl"
        :data-test-js="previousPageUrl ? 'pagination-simple-previous' : null"
        @click.prevent="onClick(previousPageUrl)"
      >
<!--        <svg-->
<!--          xmlns="http://www.w3.org/2000/svg"-->
<!--          fill="none"-->
<!--          viewBox="0 0 24 24"-->
<!--          stroke="currentColor"-->
<!--          stroke-width="2"-->
<!--        >-->
<!--          <path-->
<!--            stroke-linecap="round"-->
<!--            stroke-linejoin="round"-->
<!--            d="M7 16l-4-4m0 0l4-4m-4 4h18"-->
<!--          />-->
<!--        </svg>-->
        <span class="hidden sm:inline ml-2">{{ translations.previous }}</span>
      </component>
      <PerPageSelector
        data-test-js="per-page-mobile"
        :value="perPage"
        :options="perPageOptions"
        :on-change="onPerPageChange"
      />
      <component
        :is="nextPageUrl ? 'a' : 'div'"
        :href="nextPageUrl"
        :data-test-js="nextPageUrl ? 'pagination-simple-next' : null"
        @click.prevent="onClick(nextPageUrl)"
      >
        <span>{{ translations.next }}</span>
<!--        <svg-->
<!--          xmlns="http://www.w3.org/2000/svg"-->
<!--          fill="none"-->
<!--          viewBox="0 0 24 24"-->
<!--          stroke="currentColor"-->
<!--          stroke-width="2"-->
<!--        >-->
<!--          <path-->
<!--            stroke-linecap="round"-->
<!--            stroke-linejoin="round"-->
<!--            d="M17 8l4 4m0 0l-4 4m4-4H3"-->
<!--          />-->
<!--        </svg>-->
      </component>
    </div>

    <!-- full pagination -->
    <div v-if="hasData && hasLinks">
      <div>
        <PerPageSelector
          data-test-js="per-page-full"
          :value="perPage"
          :options="perPageOptions"
          :on-change="onPerPageChange"
        />

        <p>
          <span>{{ pagination.from }}</span>
          {{ translations.to }}
          <span>{{ pagination.to }}</span>
          {{ translations.of }}
          <span>{{ pagination.total }}</span>
          {{ translations.results }}
        </p>
      </div>
      <div>
        <nav aria-label="Pagination">
          <component
            :is="previousPageUrl ? 'a' : 'div'"
            :href="previousPageUrl"
            :data-test-js="previousPageUrl ? 'pagination-previous' : null"
            @click.prevent="onClick(previousPageUrl)"
          >
            <span class="sr-only">{{ translations.previous }}</span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </component>

          <div v-for="(link, key) in pagination.links" :key="key">
            <slot name="link">
              <component
                  :is="link.url ? 'a' : 'div'"
                  v-if=" !isNaN(link.label) || link.label === '...'"
                :href="link.url"
                :data-test-js="link.url ? `pagination-${link.label}` : null"
                @click.prevent="onClick(link.url)"
              >{{ link.label }}</component>
            </slot>
          </div>

          <component
            :is="nextPageUrl ? 'a' : 'div'"
            :href="nextPageUrl"
            :data-test-js="nextPageUrl ? 'pagination-next' : null"
            @click.prevent="onClick(nextPageUrl)"
          >
            <span class="sr-only">{{ translations.next }}</span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </component>
        </nav>
      </div>
    </div>
  </nav>
</template>

<script setup>
import PerPageSelector from "./PerPageSelector.vue";
import {computed} from "vue";
import {getTranslations} from "../translations.js";

const translations = getTranslations();

const props = defineProps({
    onClick: {
        type: Function,
        required: false,
    },
    perPageOptions: {
        type: Array,
        default() {
            return () => [15, 30, 50, 100];
        },
        required: false
    },
    onPerPageChange: {
        type: Function,
        default() {
            return () => {};
        },
        required: false,
    },
    hasData: {
        type: Boolean,
        required: true,
    },
    meta: {
        type: Object,
        required: false,
    }
});

const hasLinks = computed(() => {
    if(!("links" in pagination.value)) {
        return false;
    }

    return pagination.value.links.length > 0;
});

const hasPagination = computed(() => {
    return Object.keys(pagination.value).length > 0;
});

const pagination = computed(() => {
    return props.meta;
});

const previousPageUrl = computed(() => {
    if ("prev_page_url" in pagination.value) {
        return pagination.value.prev_page_url;
    }

    return null;
});

const nextPageUrl = computed(() => {
    if ("next_page_url" in pagination.value) {
        return pagination.value.next_page_url;
    }

    return null;
});

const perPage = computed(() => {
    return parseInt(pagination.value.per_page);
});
</script>
