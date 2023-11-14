import { defineStore } from "pinia";
import { ref } from "vue";
export const useFacilityStore = defineStore(
    "facilityStore",
    () => {

        let steps = ref(1);
        let setOne = ref([]);
        let aisleListing = ref([]);

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
            }
        }

        const setAisleUnit = (aisle) => {
            let units = [];
            aisle.forEach(aisle => {
                for (let x = 1; x <= aisle.units; x++) {
                    let un = { aisleName: aisle.name, unitName: 'Unit ' + x, size: aisle.size, dimension: aisle.dimension, weight: aisle.weight };
                    units.push(un);
                }
                aisle.unitsDetails = units;
                units = [];
            });
        }
        return { steps, setOne, aisleListing, stepsProgress, setSectionAisle, setAisleUnit };
    },
    {
        persist: true,
    }
)
