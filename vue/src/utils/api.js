// src/utils/api.js
export async function apiRequest(url, options = {}) {
    // 第一步：确保 CSRF Cookie 已经获取
    await fetch("http://laravel-vue.local/sanctum/csrf-cookie", {
      method: "GET",
      credentials: "include",
    });
  
    // 如果不是 GET 请求，需要在请求头中附加 X-XSRF-TOKEN
    if (options.method && options.method.toUpperCase() !== "GET") {
      const xsrfToken = document.cookie
        .split("; ")
        .find(row => row.startsWith("XSRF-TOKEN="))
        ?.split("=")[1];
  
      if (!xsrfToken) {
        throw new Error("无法获取 CSRF 令牌");
      }
      
      options.headers = {
        ...options.headers,
        "Content-Type": "application/json",
        "X-XSRF-TOKEN": decodeURIComponent(xsrfToken)
      };
    } else {
      // 如果是 GET 请求，也设置 Content-Type 方便后端解析
      options.headers = {
        ...options.headers,
        "Content-Type": "application/json",
      };
    }
  
    // 确保请求带上 Cookie
    options.credentials = "include";
  
    // 发起 API 请求
    const response = await fetch(url, options);
    return response;
  }
  