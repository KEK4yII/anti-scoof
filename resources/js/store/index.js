import { createStore } from "vuex";

const store = createStore({
    state () {
        return {
            user: {
                
                jwt: "",
                refresh: ""
            }
        }
    }
})

export default store
