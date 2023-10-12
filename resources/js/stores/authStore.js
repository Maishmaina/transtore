import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useAuthStore = defineStore(
    "authStore",
    () => {
        const authUser = ref(null);

        return { authUser };
    },
    {
        persist: true,
    }
);
