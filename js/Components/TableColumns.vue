<template>
  <ButtonWithDropdown placement="bottom-end" data-test-js="columns-dropdown" :active="hasHiddenColumns">
    <template #button>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
            <path fill-rule="evenodd"
                  d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                  clip-rule="evenodd"/>
        </svg>
    </template>

    <div role="menu" aria-orientation="horizontal" aria-labelledby="toggle-columns-menu">
      <div>
        <ul>
          <li v-for="(column, key) in props.columns" v-show="column.can_be_hidden" :key="key">
            <p>{{ column.label }}</p>

            <button
              type="button"
              :aria-pressed="!column.hidden"
              :aria-labelledby="`toggle-column-${column.key}`"
              :aria-describedby="`toggle-column-${column.key}`"
              :data-test-js="`toggle-column-${column.key}`"
              @click.prevent="onChange(column.key, column.hidden)"
            >
              <span class="sr-only">Column status</span>
              <span aria-hidden="true"/>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </ButtonWithDropdown>
</template>

<script setup>
import ButtonWithDropdown from "./ButtonWithDropdown.vue";

const props = defineProps({
    columns: {
        type: Object,
        required: true,
    },

    hasHiddenColumns: {
        type: Boolean,
        required: true,
    },

    onChange: {
        type: Function,
        required: true,
    },
});
</script>
