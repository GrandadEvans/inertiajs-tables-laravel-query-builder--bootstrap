<template>
  <div class="relative">
      <div class="input-group">
    <input
      :placeholder="label"
      :value="value"
      type="text"
      name="global"
      @input="onChange($event.target.value)"
      style="border: 1px solid var(--color-highlight); border-bottom-left-radius: var(--bs-border-radius); border-top-left-radius: var(--bs-border-radius);"
    >
          <span class="input-group-text">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="height: 1.5rem;">
        <path
          fill-rule="evenodd"
          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
          clip-rule="evenodd"
        />
      </svg>
          </span>
    </div>
  </div>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        default: "Search...",
        required: false,
    },

    value: {
        type: String,
        default: "",
        required: false,
    },

    onChange: {
        type: Function,
        required: true,
    },
});
</script>

