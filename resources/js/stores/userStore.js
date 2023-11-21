import { defineStore } from "pinia";
import { ref } from "vue";

export const useUserStore = defineStore(
    "userStore",
    () => {
        const user = ref(null);

        const userLogin = () => {
            console.log(response.value);
            user.value = {};
        }

        return { user, userLogin };
    }
)
