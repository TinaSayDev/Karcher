export function formatPrice(value) {
    if (!value) return '';
    const number = typeof value === 'number' ? value : parseInt(value, 10);
    return new Intl.NumberFormat('ru-RU', { maximumFractionDigits: 0 }).format(number);
}
