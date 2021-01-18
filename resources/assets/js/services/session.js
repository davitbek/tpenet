import Cookies from 'universal-cookie';

export default class SessionService {
    constructor () {
        this.cookies = new Cookies();
    }

    /**
     * Get key
     *
     * @param key
     * @returns {*}
     */
    static get(key) {
        const instance = new SessionService();
        return instance.cookies.get(key);
    }

    /**
     * Set key
     *
     * @param key
     * @param value
     * @param options
     * @returns {*}
     */
    static set(key, value, options = {}) {
        const instance = new SessionService();
        return instance.cookies.set(key, value, options);
    }

    /**
     * Remove key
     *
     * @param key
     * @param options
     * @returns {*}
     */
    static remove(key, options = {}) {
        const instance = new SessionService();
        return instance.cookies.remove(key, options);
    }

    /**
     * Get all keys
     *
     * @returns {*}
     */
    static getAll() {
        const instance = new SessionService();
        return instance.cookies.getAll();
    }
}
