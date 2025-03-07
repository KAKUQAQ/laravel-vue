export function getCsrfToken() {
    return fetch('/sanctum/csrf-cookie', { credentials: 'include' });
}

export function login(email, password) {
    return fetch('/api/login', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    }).then(res => res.json());
}
