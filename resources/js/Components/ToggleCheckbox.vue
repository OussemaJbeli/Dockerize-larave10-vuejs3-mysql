<template>
  <div class="w-full p-0 m-0 flex">
    <label :for="inputId" class="form-label">{{ label }}</label>
    <div class="form-input flex items-center p-0 m-0 flex flex-row w-56 bg-transparent border-transparent">
      <input
        :id="inputId"
        type="checkbox"
        class="hidden"
        :checked="isChecked"
        @change="toggleHandle"
      />

      <label :for="inputId" class="flex items-center flex-row bg-transparent cursor-pointer">
        <div class="relative">
          <div
            id="second_div"
            class="block w-10 h-6 rounded-full"
            :class="{ 'bg-gray-400': !isChecked, 'bg-green-500': isChecked }"
          ></div>

          <div
            class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transform transition"
            :class="{ 'translate-x-4': isChecked }"
          ></div>
        </div>
        &nbsp; &nbsp;
        <div class="ml-3 text-white" id="first_div">
          <span v-if="isChecked">{{ active_value }}</span>
          <span v-else>{{ inactive_value }}</span>
        </div>
      </label>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    isChecked: Boolean,
    label: String,
    active_value: String,
    inactive_value: String,
  },
  computed: {
    inputId() {
      return `toggle-${Math.random().toString(36).substr(2, 10)}`;
    },
  },
  methods: {
    toggleHandle() {
      this.$emit("toggle");
    },
  },
};
</script>
