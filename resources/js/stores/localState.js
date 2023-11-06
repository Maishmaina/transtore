import { defineStore } from "pinia";
import { ref } from "vue";

export const useNewStore = defineStore(
    "newStore",
    () => {
        const browni = ref(null);
        const loggers = () => {
            browni.value = 'Mr brown';
            return true;
        };
        return { browni, loggers };
    }
);
