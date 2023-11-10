import { defineStore } from "pinia";
import { ref } from "vue";
export const useFacilityStore = defineStore(
    "facilityStore",
    () => {

        let steps = ref(1);
        let setOne = ref([]);
        let aisleListing = ref([]);
        let unitListing = ref([]);

        const stepsProgress = (position) => {
            steps.value = position;
        }

        const setSectionAisle = (form) => {

            setOne.value = form;

            if (form.aisle != '') {
                aisleListing.value = [];
                for (let i = 1; i <= form.aisle; i++) {
                    let item = { name: 'Aisle ' + i, units: '', size: '', dimension: '', weight: '' }
                    aisleListing.value.push(item);
                }
                console.log(aisleListing.value)
            }
        }
        const setAisleUnit = (aisle) => {
            console.log(aisle);
        }
        return { steps, setOne, aisleListing, stepsProgress, setSectionAisle, setAisleUnit };
    },
    {
        persist: true,
    }
)
