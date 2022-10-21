export function formatDate(date) {
    var tzoffset = new Date().getTimezoneOffset() * 60000;
    return new Date(date - tzoffset)
        .toISOString()
        .slice(0, 19)
        .replace("T", " ");
}
