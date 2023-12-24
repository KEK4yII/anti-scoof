import axios from "axios";
import store from "./store/index.js";

class API {
    baseUri = "/api/"
    refreshingJWT = false
    queue = []

    async fetch(method, uri, body) {
        let res = await axios({
            url: this.baseUri + uri,
            method,
            body: body.json()
        })
        let data = await JSON.parse(res)
        if (data.status === "ok") {
            return data.data
        } else {
            if (!data.errors[0]) {
                switch (data.errors[0]) {
                    case "JWT expired":
                        this.queue.push()

                        break
                }
            }
        }
    }

    async refreshJWT() {
        axios({
            url: "/api/auth/refresh"
        })
    }
}

export default new API
