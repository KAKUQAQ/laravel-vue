// src/store/user.js
import { defineStore } from 'pinia'
import { apiRequest } from '../utils/api.js'

export const useUserStore = defineStore('user', {
  state: () => ({
    // 当前登录用户的信息（null 表示未登录）
    user: null,
  }),
  actions: {
    // 从后端获取当前登录用户信息
    async fetchUser() {
      try {
        const response = await apiRequest("http://laravel-vue.local/api/user", {
          method: "GET"
        });
        if (response.ok) {
          this.user = await response.json();
        } else {
          this.user = null;
        }
      } catch (error) {
        console.error("Fetch user error:", error);
        this.user = null;
      }
    },

    // 登录操作：传入 email, password, 以及是否记住账号（可选）
    async login(email, password, rememberMe = false) {
      try {
        const response = await apiRequest("http://laravel-vue.local/api/login", {
          method: "POST",
          body: JSON.stringify({ email, password })
        });
        if (response.ok) {
          // 登录成功后更新用户状态
          await this.fetchUser();
          // 记住账号：仅保存 email，不保存密码
          if (rememberMe) {
            localStorage.setItem("rememberedEmail", email);
          } else {
            localStorage.removeItem("rememberedEmail");
          }
        } else {
          const errorData = await response.json();
          throw new Error(errorData.message || "登录失败");
        }
      } catch (error) {
        console.error("Login error:", error);
        throw error;
      }
    },

    // 登出操作
    async logout() {
      try {
        const response = await apiRequest("http://laravel-vue.local/api/logout", {
          method: "POST"
        });
        if (response.ok) {
          this.user = null;
        } else {
          console.error("Logout failed", await response.text());
        }
      } catch (error) {
        console.error("Logout error:", error);
      }
    },

    // 可选：手动设置用户信息
    setUser(userData) {
      this.user = userData;
    }
  }
});
