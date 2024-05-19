import { createStore } from 'vuex';

const state = {
  user: null
}

export const store = createStore({
    strict:true,
    state,
    getters: {
      user: (state) => {
        return state.user;
      },
      isLoggedIn: (state) => state.user !== null
    },
    actions: {
      user(context, user) {
        context.commit('user', user);
      }
    },
    mutations: {
      user(state, user) {
        state.user = user;
      }
    }
});

