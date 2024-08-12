import { usePage } from "@inertiajs/inertia-vue3";

export const spatieMixin = {
    methods: {
        hasPermission(permission) {
            const auth = getAuth();

            if (!auth) return false;

            const userPermissions = getPermissions(auth);
            const userRoles = getRoles(auth);

            return (
                userPermissions.includes(permission) ||
                userRoles.includes("Superadmin")
            );
        },
        hasRole(role) {
            const auth = getAuth();

            if (!getAuth()) return false;

            const userRoles = getRoles(auth);

            return userRoles.includes(role) || userRoles.includes("Superadmin");
        },
    },
};

const getAuth = () => usePage().props.value.auth;

const getRoles = (auth) => auth.roles || [];

const getPermissions = (auth) => auth.permissions || [];
