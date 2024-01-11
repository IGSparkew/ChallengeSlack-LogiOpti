export function isDriverUser() {
    let role = localStorage.getItem("role");
    return role != null && role == "ROLE_DRIVER"
}

export function isOfficeUser() {
    let role = localStorage.getItem("role");
    return role != null && role == "ROLE_OFFICE"
}

export function isAdminUser() {
    let role = localStorage.getItem("role");
    return role != null && role == "ROLE_ADMIN"
}