// import ApiService from '@/services/api';
// import {
//     GET_USER,
//     GET_USER_SUCCESS,
//     GET_USER_FAIL,
//     GET_USER_SINGLE,
//     GET_USER_SINGLE_SUCCESS,
//     GET_USER_SINGLE_FAIL,
//     GET_USER_STATISTICS,
//     GET_USER_STATISTICS_SUCCESS,
//     GET_USER_STATISTICS_FAIL,
//     UPDATE_USER,
//     UPDATE_USER_SUCCESS,
//     UPDATE_USER_FAIL,
//     CHANGE_PASSWORD,
//     CHANGE_PASSWORD_SUCCESS,
//     CHANGE_PASSWORD_FAIL,
//     STORE_USER,
//     FORGET_USER,
//     GET_USER_PROFILE,
//     GET_USER_PROFILE_SUCCESS,
//     GET_USER_PROFILE_FAIL,
//     GET_USER_TIP,
//     GET_USER_TIP_SUCCESS,
//     GET_USER_TIP_FAIL,
//     FOLLOW_UN_FOLLOW_USER,
//     FOLLOW_UN_FOLLOW_USER_SUCCESS,
//     FOLLOW_UN_FOLLOW_USER_FAIL,
//     GET_USER_EDITING_DATA,
//     GET_USER_EDITING_DATA_SUCCESS,
//     GET_USER_EDITING_DATA_FAIL,
//     GET_USER_ENDED_TIPS,
//     GET_USER_ENDED_TIPS_SUCCESS,
//     GET_USER_ENDED_TIPS_FAIL,
//     GET_USER_ACTIVE_TIPS,
//     GET_USER_ACTIVE_TIPS_SUCCESS,
//     GET_USER_ACTIVE_TIPS_FAIL,
//     GET_USER_FAVORITE_TEAMS,
//     GET_USER_FAVORITE_TEAMS_SUCCESS,
//     GET_USER_FAVORITE_TEAMS_FAIL,
//     GET_USER_FAVORITE_LEAGUES,
//     GET_USER_FAVORITE_LEAGUES_SUCCESS,
//     GET_USER_FAVORITE_LEAGUES_FAIL,
//     GET_USERS_SUGGEST,
//     GET_USERS_SUGGEST_SUCCESS,
//     GET_USERS_SUGGEST_FAIL,
//     GET_USERS_SUGGEST_RESET,
// } from "./actions";
//
// import {
//     CHANGE_LOCALE,
//     LOAD_MAIN_DATA
// } from "../app/actions";
//
// const state = {
//     getUserRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         errors: {},
//     },
//     getUserSingleRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         data: {},
//         errors: {},
//     },
//     getUserStatisticsRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         data: {},
//         errors: {},
//     },
//     updateUserRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         errors: {},
//     },
//     changePasswordRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         errors: {},
//     },
//     getUserProfileRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         data: {},
//         errors: {},
//     },
//     getUserTipRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         data: {},
//         errors: {},
//     },
//     followUserRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         errors: {},
//     },
//     getUserEditingDataRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         data: {},
//         errors: {},
//     },
//     getEndedTipsRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         data: {},
//         errors: {},
//     },
//     getActiveTipsRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         data: {},
//         errors: {},
//     },
//     getFavoriteTeamsRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         data: [],
//         errors: {},
//     },
//     getFavoriteLeaguesRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         data: [],
//         errors: {},
//     },
//     getUsersSuggestRequest: {
//         loading: false,
//         success: false,
//         fail: false,
//         data: [],
//         errors: {},
//     },
//     userData: {}
// };
//
// const getters = {
//
// };
//
// const actions = {
//     [GET_USER] (context) {
//         context.state.getUserRequest.loading = true;
//
//         return new Promise((resolve) => {
//             ApiService
//                 .get('users/auth')
//                 .then((response) => {
//                     context.commit(GET_USER_SUCCESS, response.data.result);
//                     resolve(response.data.result)
//                 })
//                 .catch((response) => {
//                     context.commit(GET_USER_FAIL, response)
//                 });
//         })
//     },
//     [GET_USER_SINGLE] (context, id) {
//         context.state.getUserSingleRequest.loading = true;
//
//         return new Promise((resolve) => {
//             ApiService
//                 .get(`users/${id}`)
//                 .then((response) => {
//                     context.commit(GET_USER_SINGLE_SUCCESS, response.data.result);
//                     resolve(response.data.result)
//                 })
//                 .catch((response) => {
//                     context.commit(GET_USER_SINGLE_FAIL, response)
//                 });
//         })
//     },
//     [GET_USER_STATISTICS] (context, { id, params }) {
//         context.state.getUserStatisticsRequest.loading = true;
//
//         return new Promise((resolve) => {
//             ApiService
//                 .query(`users/${id}/statistics/monthly`, params)
//                 .then((response) => {
//                     context.commit(GET_USER_STATISTICS_SUCCESS, response.data.result);
//                     resolve(response.data.result)
//                 })
//                 .catch((response) => {
//                     context.commit(GET_USER_STATISTICS_FAIL, response)
//                 });
//         })
//     },
//     [UPDATE_USER] (context, { id, data }) {
//         context.state.updateUserRequest.loading = true;
//
//         data._method = 'PUT';
//
//         return new Promise((resolve) => {
//             ApiService
//                 .postUpload(`user/${id}`, data)
//                 .then((response) => {
//                     context.commit(UPDATE_USER_SUCCESS, response.data.data);
//
//                     context.dispatch(LOAD_MAIN_DATA, true);
//
//                     resolve(response.data)
//                 })
//                 .catch(({response}) => {
//                     context.commit(UPDATE_USER_FAIL, response.data);
//                 })
//         })
//     },
//     [CHANGE_PASSWORD] (context, params) {
//         context.state.changePasswordRequest.loading = true;
//
//         return new Promise((resolve) => {
//             ApiService
//                 .put(`auth/user/update/password`, params)
//                 .then((response) => {
//                     const result = response.data.result;
//
//                     if (!result) {
//                         return Promise.reject(response.data);
//                     }
//
//                     context.commit(CHANGE_PASSWORD_SUCCESS, result);
//                     resolve(response.data);
//                 })
//                 .catch((response) => {
//                     context.commit(CHANGE_PASSWORD_FAIL, response.error);
//                 });
//         });
//     },
//     [STORE_USER] (context, data) {
//         context.dispatch(CHANGE_LOCALE, data.lang);
//         context.state.userData = data;
//     },
//     [FORGET_USER] (context) {
//         context.state.userData = {};
//     },
//     [GET_USER_PROFILE] (context, { id, page, pageName }) {
//         context.state.getUserProfileRequest.loading = !page;
//
//         let params = {};
//
//         if (page && pageName) {
//             params[pageName] = page;
//         }
//
//         ApiService
//             .query(`user/profile/${id}`, params)
//             .then((response) => {
//                 context.commit(GET_USER_PROFILE_SUCCESS, response.data.data);
//             })
//             .catch((response) => {
//                 context.commit(GET_USER_PROFILE_FAIL, response)
//             })
//     },
//     [GET_USER_TIP] (context, id) {
//         context.state.getUserTipRequest.loading = true;
//
//         ApiService
//             .get(`user/tip/${id}`)
//             .then((response) => {
//                 context.commit(GET_USER_TIP_SUCCESS, response.data.data);
//             })
//             .catch((response) => {
//                 context.commit(GET_USER_TIP_FAIL, response)
//             })
//     },
//     [FOLLOW_UN_FOLLOW_USER] (context, id) {
//         context.state.followUserRequest.loading = true;
//
//         ApiService
//             .post(`users/${id}/follow`)
//             .then((response) => {
//                 context.commit(FOLLOW_UN_FOLLOW_USER_SUCCESS, response.data.result);
//             })
//             .catch((response) => {
//                 context.commit(FOLLOW_UN_FOLLOW_USER_FAIL, response)
//             });
//     },
//     [GET_USER_EDITING_DATA] (context, id) {
//         context.state.getUserEditingDataRequest.loading = true;
//
//         ApiService
//             .get(`user/${id}/edit`)
//             .then((response) => {
//                 context.commit(GET_USER_EDITING_DATA_SUCCESS, response.data.data);
//             })
//             .catch((response) => {
//                 context.commit(GET_USER_EDITING_DATA_FAIL, response)
//             })
//     },
//     [GET_USER_ACTIVE_TIPS] (context, {id, page}) {
//         context.state.getActiveTipsRequest.loading = true;
//
//         ApiService
//             .query(`users/${id}/tips/active`, {
//                 page
//             })
//             .then((response) => {
//                 context.commit(GET_USER_ACTIVE_TIPS_SUCCESS, response.data.result);
//             })
//             .catch((response) => {
//                 context.commit(GET_USER_ACTIVE_TIPS_FAIL, response)
//             });
//     },
//     [GET_USER_ENDED_TIPS] (context, {id, page}) {
//         context.state.getEndedTipsRequest.loading = true;
//
//         ApiService
//             .query(`users/${id}/tips/ended`, {
//                 page
//             })
//             .then((response) => {
//                 context.commit(GET_USER_ENDED_TIPS_SUCCESS, response.data.result);
//             })
//             .catch((response) => {
//                 context.commit(GET_USER_ENDED_TIPS_FAIL, response)
//             });
//     },
//     [GET_USER_FAVORITE_TEAMS] (context) {
//         context.state.getFavoriteTeamsRequest.loading = true;
//
//         ApiService
//             .get(`users/auth/enet-teams`)
//             .then((response) => {
//                 context.commit(GET_USER_FAVORITE_TEAMS_SUCCESS, response.data.result);
//             })
//             .catch((response) => {
//                 context.commit(GET_USER_FAVORITE_TEAMS_FAIL, response)
//             });
//     },
//     [GET_USER_FAVORITE_LEAGUES] (context) {
//         context.state.getFavoriteLeaguesRequest.loading = true;
//
//         ApiService
//             .get(`users/auth/enet-leagues`)
//             .then((response) => {
//                 context.commit(GET_USER_FAVORITE_LEAGUES_SUCCESS, response.data.result);
//             })
//             .catch((response) => {
//                 context.commit(GET_USER_FAVORITE_LEAGUES_FAIL, response)
//             });
//     },
//     [GET_USERS_SUGGEST] (context, params) {
//         context.state.getUsersSuggestRequest.loading = true;
//
//         ApiService
//             .query(`users/suggest`, params)
//             .then((response) => {
//                 context.commit(GET_USERS_SUGGEST_SUCCESS, response.data.result);
//             })
//             .catch((response) => {
//                 context.commit(GET_USERS_SUGGEST_FAIL, response.data.errors)
//             });
//     },
//     [GET_USERS_SUGGEST_RESET] (context) {
//         context.state.getUsersSuggestRequest = {
//             loading: false,
//             success: false,
//             fail: false,
//             data: [],
//             errors: {},
//         }
//     }
// };
//
// const mutations = {
//     [GET_USER_SUCCESS] (state, data) {
//         state.getUserRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             errors: {},
//         };
//         state.userData = data;
//     },
//     [GET_USER_FAIL] (state, data) {
//         state.getUserRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             errors: data.errors,
//         };
//         state.userData = {};
//     },
//     [GET_USER_SINGLE_SUCCESS] (state, data) {
//         state.getUserSingleRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             errors: {},
//             data: data,
//         };
//     },
//     [GET_USER_SINGLE_FAIL] (state, data) {
//         state.getUserSingleRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             errors: data.errors,
//             data: {},
//         };
//     },
//     [GET_USER_STATISTICS_SUCCESS] (state, data) {
//         state.getUserStatisticsRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             errors: {},
//             data: data,
//         };
//     },
//     [GET_USER_STATISTICS_FAIL] (state, data) {
//         state.getUserStatisticsRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             errors: data.errors,
//             data: {},
//         };
//     },
//     [UPDATE_USER_SUCCESS] (state, data) {
//         state.updateUserRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             errors: {},
//         };
//         state.userData = data;
//     },
//     [UPDATE_USER_FAIL] (state, data) {
//         state.updateUserRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             errors: data.errors,
//         };
//     },
//     [CHANGE_PASSWORD_SUCCESS] (state, data) {
//         state.changePasswordRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             errors: {},
//         };
//     },
//     [CHANGE_PASSWORD_FAIL] (state, errors) {
//         state.changePasswordRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             errors: errors,
//         };
//     },
//     [GET_USER_PROFILE_SUCCESS] (state, data) {
//         state.getUserProfileRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             errors: {},
//             data: data,
//         };
//     },
//     [GET_USER_PROFILE_FAIL] (state, data) {
//         state.getUserProfileRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             errors: data.errors,
//             data: {},
//         };
//     },
//     [GET_USER_TIP_SUCCESS] (state, data) {
//         state.getUserTipRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             errors: {},
//             data: data,
//         };
//     },
//     [GET_USER_TIP_FAIL] (state, data) {
//         state.getUserTipRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             errors: data.errors,
//             data: {},
//         };
//     },
//     [FOLLOW_UN_FOLLOW_USER_SUCCESS] (state, data) {
//         state.followUserRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             errors: {},
//         };
//
//         state.getUserSingleRequest.data.follow_status = !state.getUserSingleRequest.data.follow_status;
//     },
//     [FOLLOW_UN_FOLLOW_USER_FAIL] (state, data) {
//         state.followUserRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             errors: data.errors,
//         };
//     },
//     [GET_USER_EDITING_DATA_SUCCESS] (state, data) {
//         state.getUserEditingDataRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             data: data,
//             errors: {},
//         };
//     },
//     [GET_USER_EDITING_DATA_FAIL] (state, data) {
//         state.getUserEditingDataRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             data: {},
//             errors: data.errors,
//         };
//     },
//     [GET_USER_ACTIVE_TIPS_SUCCESS] (state, data) {
//         state.getActiveTipsRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             data: data,
//             errors: {},
//         };
//     },
//     [GET_USER_ACTIVE_TIPS_FAIL] (state, data) {
//         state.getActiveTipsRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             data: {},
//             errors: data.errors,
//         };
//     },
//     [GET_USER_ENDED_TIPS_SUCCESS] (state, data) {
//         state.getEndedTipsRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             data: data,
//             errors: {},
//         };
//     },
//     [GET_USER_ENDED_TIPS_FAIL] (state, data) {
//         state.getEndedTipsRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             data: {},
//             errors: data.errors,
//         };
//     },
//     [GET_USER_FAVORITE_TEAMS_SUCCESS] (state, data) {
//         state.getFavoriteTeamsRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             data: data,
//             errors: {},
//         };
//     },
//     [GET_USER_FAVORITE_TEAMS_FAIL] (state, data) {
//         state.getFavoriteTeamsRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             data: [],
//             errors: data.errors,
//         };
//     },
//     [GET_USER_FAVORITE_LEAGUES_SUCCESS] (state, data) {
//         state.getFavoriteLeaguesRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             data: data,
//             errors: {},
//         };
//     },
//     [GET_USER_FAVORITE_LEAGUES_FAIL] (state, data) {
//         state.getFavoriteLeaguesRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             data: [],
//             errors: data.errors,
//         };
//     },
//     [GET_USERS_SUGGEST_SUCCESS] (state, data) {
//         state.getUsersSuggestRequest = {
//             loading: false,
//             success: true,
//             fail: false,
//             data: data,
//             errors: {},
//         };
//     },
//     [GET_USERS_SUGGEST_FAIL] (state, errors) {
//         state.getUsersSuggestRequest = {
//             loading: false,
//             success: false,
//             fail: true,
//             data: [],
//             errors: errors,
//         };
//     },
// };
//
// export default {
//     state,
//     actions,
//     mutations,
//     getters
// }
