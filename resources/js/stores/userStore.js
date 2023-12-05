import { defineStore } from "pinia";
import { ref, computed } from "vue";

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
        const userLogout = async () => {
            let response = null;

            try {
                response = await axios.post("logout", user_config.value);
            } catch (error) {
                response = error.response;
            }
            if (response.status == 200) {
                user.value = [];
            }

            return response;
        };

        const user_config = computed(() => {
            return {
                headers: {
                    Authorization: `Bearer ${user.value.token}`,
                },
            };
        });
        return { user, user_config, registerUser, loginUser, userLogout };
    },
    {
        persist: true,
    }
)
