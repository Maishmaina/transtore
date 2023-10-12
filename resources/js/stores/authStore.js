import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useAuthStore = defineStore(
    "authStore",
    () => {
        const authUser = ref(null);
        const token = ref(null);

        const login = async (data) => {
            let response = null;
            try {
                response = await axios.post("login", data);
            } catch (error) {
                response = error.response;
            }

            if (response.status == 200) {
                authUser.value = response.data.admin;
                token.value = response.data.token;
            }

            return response;
        };

        const logout = async () => {
            let response = null;
            try {
                response = await axios.delete("logout", {
                    headers: {
                        Authorization: `Bearer ${token.value}`,
                    },
                });
            } catch (error) {
                response = error.response;
            }

            if (response.status == 200) {
                authUser.value = null;
                token.value = null;
            }

            return response;
        };

        return { authUser, token, login, logout };
    },
    {
        persist: true,
    }
);
