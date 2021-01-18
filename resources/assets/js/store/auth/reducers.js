// import ApiService from "../../services/api";
// import { saveSession, destroySession } from "../../services/oauth";
//
// import {
//     LOGIN,
//     LOGIN_RESET,
//     LOGIN_SUCCESS,
//     LOGIN_SUCCESS_REMEMBER,
//     LOGIN_FAIL,
//     LOGIN_PURGE,
//     LOGIN_RESTORE,
//     LOGOUT,
//     LOGOUT_SUCCESS,
//     LOGOUT_FAIL,
//     RESET_PASSWORD,
//     RESET_PASSWORD_SUCCESS,
//     RESET_PASSWORD_FAIL,
//     UPDATE_PASSWORD,
//     UPDATE_PASSWORD_SUCCESS,
//     UPDATE_PASSWORD_FAIL,
//     REGISTER,
//     REGISTER_RESET,
//     REGISTER_SUCCESS,
//     REGISTER_FAIL,
// } from "./actions";
//
// import {
//     STORE_USER,
//     FORGET_USER,
// } from "../user/actions";
//
//
//
//
// const state = {
//     loading: false,
//     success: false,
//     fail: false,
//     error: null,
//     isAuthenticated: false,
//     resetPasswordRequest: {
//         fail: false,
//         loading: false,
//         success: false,
//         errors: {}
//     },
//
//     registerRequest: {
//         fail: false,
//         loading: false,
//         success: false,
//         errors: {}
//     },
// };
//
// const getters = {
//
// };
// const actions = {
//     [LOGIN](context, {email, password, isRemember}) {
//         context.state.loading = true;
//
//         return new Promise((resolve) => {
//             ApiService
//                 .post('auth/login', {
//                     email,
//                     password,
//                 })
//                 .then((response) => {
//                     const result = response.data.result;
//
//                     if (!result) {
//                         return Promise.reject(response.data);
//                     }
//
//                     if (!isRemember) {
//                         context.commit(LOGIN_SUCCESS, result.tokens);
//                     } else {
//                         context.commit(LOGIN_SUCCESS_REMEMBER, result.tokens);
//                     }
//
//                     context.dispatch(STORE_USER, result.user);
//
//                     resolve(response.data);
//                 })
//                 .catch((response) => {
//                     context.commit(LOGIN_FAIL, response.error.message);
//                 });
//
//         })
//     },
//
//     [REGISTER] (context, { name, email, password, password_confirmation }) {
//         context.state.registerRequest.loading = true;
//
//         return new Promise((resolve) => {
//             ApiService
//                 .post('auth/register', {
//                     name,
//                     email,
//                     password,
//                     password_confirmation,
//                     get_access_tokens: true
//                 })
//                 .then((response) => {
//                     const result = response.data.result;
//
//                     if (!result) {
//                         return Promise.reject(response.data);
//                     }
//
//                     context.commit(LOGIN_SUCCESS, result.access_tokens);
//                     delete result['access_tokens'];
//                     context.dispatch(STORE_USER, result);
//                     context.commit(REGISTER_SUCCESS, result);
//                     resolve(result);
//                 })
//                 .catch((response) => {
//                     context.commit(REGISTER_FAIL, response.error);
//                 });
//         })
//     },
//
// };
//
// const mutations = {
//     [LOGIN_FAIL] (state, data) {
//         state.loading = false;
//         state.success = false;
//         state.fail = true;
//         state.error = data;
//     },
//     [LOGIN_SUCCESS] (state, data) {
//         state.loading = false;
//         state.success = true;
//         state.fail = false;
//         state.isAuthenticated = true;
//         state.error = null;
//         saveSession(data);
//     },
//     [LOGIN_SUCCESS_REMEMBER] (state, data) {
//         state.loading = false;
//         state.success = true;
//         state.fail = false;
//         state.isAuthenticated = true;
//         state.error = null;
//         saveSession(data, true);
//     },
//
//     [REGISTER_FAIL] (state, data) {
//         state.registerRequest = {
//             fail: true,
//             loading: false,
//             success: false,
//             errors: data.error || {}
//         };
//     },
//     [REGISTER_SUCCESS] (state, data) {
//         state.registerRequest = {
//             fail: false,
//             loading: false,
//             success: true,
//             errors: {},
//         };
//     },
//
//
// };
//
//
//
// export default {
//     state,
//     actions,
//     mutations,
//     getters
// }
