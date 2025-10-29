/**
 * Convert number to Indonesian words (Terbilang)
 * @param {number} angka - The number to convert
 * @returns {string} - The number in words
 */
function angkaTerbilang(angka) {
    // Handle decimal numbers
    angka = Math.floor(angka);

    const bilangan = [
        "",
        "Satu",
        "Dua",
        "Tiga",
        "Empat",
        "Lima",
        "Enam",
        "Tujuh",
        "Delapan",
        "Sembilan",
        "Sepuluh",
        "Sebelas",
    ];

    // Handle zero
    if (angka === 0) {
        return "Nol";
    }

    // Handle negative numbers
    if (angka < 0) {
        return "Minus " + angkaTerbilang(Math.abs(angka));
    }

    if (angka < 12) {
        return bilangan[angka];
    } else if (angka < 20) {
        return bilangan[angka - 10] + " Belas";
    } else if (angka < 100) {
        const puluhan = Math.floor(angka / 10);
        const satuan = angka % 10;
        return bilangan[puluhan] + " Puluh " + bilangan[satuan];
    } else if (angka < 200) {
        return "Seratus " + angkaTerbilang(angka - 100);
    } else if (angka < 1000) {
        const ratusan = Math.floor(angka / 100);
        const sisa = angka % 100;
        return bilangan[ratusan] + " Ratus " + angkaTerbilang(sisa);
    } else if (angka < 2000) {
        return "Seribu " + angkaTerbilang(angka - 1000);
    } else if (angka < 1000000) {
        const ribuan = Math.floor(angka / 1000);
        const sisa = angka % 1000;
        return angkaTerbilang(ribuan) + " Ribu " + angkaTerbilang(sisa);
    } else if (angka < 1000000000) {
        const jutaan = Math.floor(angka / 1000000);
        const sisa = angka % 1000000;
        return angkaTerbilang(jutaan) + " Juta " + angkaTerbilang(sisa);
    } else if (angka < 1000000000000) {
        const miliaran = Math.floor(angka / 1000000000);
        const sisa = angka % 1000000000;
        return angkaTerbilang(miliaran) + " Miliar " + angkaTerbilang(sisa);
    } else if (angka < 1000000000000000) {
        const triliunan = Math.floor(angka / 1000000000000);
        const sisa = angka % 1000000000000;
        return angkaTerbilang(triliunan) + " Triliun " + angkaTerbilang(sisa);
    } else {
        return "Angka terlalu besar";
    }
}

/**
 * Format terbilang output by removing extra spaces
 * @param {string} text - The text to clean
 * @returns {string} - Cleaned text
 */
function cleanTerbilang(text) {
    return text.replace(/\s+/g, " ").trim();
}

/**
 * Format number with thousand separator
 * @param {number} number - The number to format
 * @returns {string} - Formatted number
 */
function formatRupiah(number) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(number);
}

// Make functions available globally
if (typeof module !== "undefined" && module.exports) {
    module.exports = { angkaTerbilang, cleanTerbilang, formatRupiah };
}
