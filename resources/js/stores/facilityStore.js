import { defineStore } from "pinia";
import { ref } from "vue";
export const useFacilityStore = defineStore(
    "facilityStore",
    () => {

        let steps = ref(1);
        let setOne = ref([]);
        const stepsProgress = (position) => {
            steps.value = position;
        }
        const setSectionAisle = (form) => {
            console.log(form);
        }
        return { steps, stepsProgress, setSectionAisle };
    },
    {
        persist: true,
    }
)
