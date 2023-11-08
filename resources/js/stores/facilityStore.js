import { defineStore } from "pinia";
import { ref } from "vue";
export const useFacilityStore = defineStore(
    "facilityStore",
    () => {

        let steps = ref(1);
        const stepsProgress = (position) => {
            steps.value = position;
        }
        return { steps, stepsProgress };
    },
    {
        persist: true,
    }
)
