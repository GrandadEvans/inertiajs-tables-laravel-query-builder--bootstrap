<template>
  <OnClickOutside :do="hide">
    <div>
      <button
        ref="button"
        type="button"
        :data-test-js="dusk"
        :disabled="disabled"
        aria-haspopup="true"
        @click.prevent="toggle"
      >
        <slot name="button" />
      </button>

      <div v-show="opened" ref="tooltip">
        <div>
          <slot />
        </div>
      </div>
    </div>
  </OnClickOutside>
</template>

<script setup>
import OnClickOutside from "./OnClickOutside.vue";
import {createPopper} from "@popperjs/core/lib/popper-lite";
import preventOverflow from "@popperjs/core/lib/modifiers/preventOverflow";
import flip from "@popperjs/core/lib/modifiers/flip";
import {onMounted, ref, watch} from "vue";

const props = defineProps({
    placement: {
        type: String,
        default: "bottom-start",
        required: false,
    },

    active: {
        type: Boolean,
        default: false,
        required: false,
    },

    dusk: {
        type: String,
        default: null,
        required: false,
    },

    disabled: {
        type: Boolean,
        default: false,
        required: false,
    },
});

const opened = ref(false);
const popper = ref(null);

function toggle() {
    opened.value = !opened.value;
}

function hide() {
    opened.value = false;
}

watch(opened, () => {
    popper.value.update();
});

const button = ref(null);
const tooltip = ref(null);

onMounted(() => {
    popper.value = createPopper(button.value, tooltip.value, {
        placement: props.placement,
        modifiers: [flip, preventOverflow],
    });
});

defineExpose({ hide });
</script>
