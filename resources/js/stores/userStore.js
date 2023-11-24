import { defineStore } from "pinia";
import { ref } from "vue";

export const useUserStore = defineStore(
    "userStore",
    () => {
        const user = ref(null);

        const registerUser = async (data) => {
            let response = null;
            try {
                response = await axios.post("register", data);
                user.value = response.data.user;
            } catch (error) {
                response = error.response;
            }
            return response;
        }
        const loginUser = async (data) => {

            let result = null;
            try {
                result = await axios.post('login', data);
                user.value = result.data
            } catch (error) {
                result = error.response;
            }
            return result;
        }
        return { user, registerUser, loginUser };
    },
    {
        persist: true,
    }
)
