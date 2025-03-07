export function getUsers() {
    return fetch(`${import.meta.env.VITE_APP_API_URL}/user`, {
        credentials: 'include' // 确保 Laravel Sanctum 认证可用
    }).then(res => res.json());
}
