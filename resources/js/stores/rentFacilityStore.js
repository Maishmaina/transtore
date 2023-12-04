import { defineStore } from "pinia";
import { ref } from "vue";

export const useRentFacilityStore = defineStore(
    "rentFacilityStore",
    () => {
        const facility_type = ref(null);
        const rent_dates = ref(null);
        const rent_location = ref("");

        const saveSelectedFacility = (store_type) => {
            facility_type.value = store_type;
        }
        const saveSelectedRage = (dates, location) => {
            rent_dates.value = dates
            rent_location.value = location
        }
        return { facility_type, rent_dates, rent_location, saveSelectedFacility, saveSelectedRage };
    },
    {
        persist: true,
    }
);
