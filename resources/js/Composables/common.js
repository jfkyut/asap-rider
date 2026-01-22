import { ref } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();


export const useCommon = () => {

    const isCopied = ref(false);

    const copyText = async (text) => {
        try {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                await navigator.clipboard.writeText(text);
                console.log("Text copied to clipboard using Clipboard API!");
            } else {
                // Fallback for insecure contexts
                const tempInput = document.createElement("input");
                tempInput.value = text;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                console.log("Text copied using fallback!");
            }

            toast.success('Copied successfully')

        } catch (err) {
            console.error("Failed to copy text: ", err);
        }
    }

    const years = [];

    const date = new Date();

    const currentYear = date.getFullYear();

    for (let year = 1970; year <= currentYear; year++) {
        years.unshift(year);
    }

    const tableHeaderClass = 'text-xs bg-zinc-200 text-zinc-700 uppercase dark:bg-zinc-700 dark:text-zinc-400 gold:bg-gold-300 teal:bg-teal-200';

    const barangays = [
        'Alimanguan',
        'Binga',
        'Caruray',
        'Kemdeng',
        'New Agutaya',
        'New Canipo',
        'Poblacion',
        'Port Barton',
        'San Isidro',
        'Sto. Niño',
    ]

    const redirectToNewTab = (url) => window.open(url, '_blank');

    const handleCouncilChange = async (council_id) => {
        const { data } = await axios.get(route('council.data', council_id));

        return {
            committees: data.committees,
            councilMembers: data.councilMembers
        }
    }

    const convertToOrdinal = (num) => {
        if (!num) return "N/A";

        const strNum = String(num);

        // handle special cases: 11, 12, 13
        const lastTwo = strNum.slice(-2);
        if (lastTwo === "11" || lastTwo === "12" || lastTwo === "13") {
            return `${num}th Council`;
        }

        // check last digit
        const lastDigit = strNum.slice(-1);
        let suffix = "th";
        if (lastDigit === "1") suffix = "st";
        else if (lastDigit === "2") suffix = "nd";
        else if (lastDigit === "3") suffix = "rd";

        return `${num}${suffix}`;
    }

    // set nested property by dot path (supports "scanned_attachment.agenda")
    const setNestedValue = (obj, path, value) => {
        if (!path) return;
        const parts = path.split('.');
        let cur = obj;
        for (let i = 0; i < parts.length - 1; i++) {
            const key = parts[i];
            if (cur[key] == null || typeof cur[key] !== 'object') {
                // create intermediate object if missing
                cur[key] = {};
            }
            cur = cur[key];
        }
        cur[parts[parts.length - 1]] = value;
    };

    const setFiles = (e, cb) => {
        cb(e.target.files);
    }

    const generateRandomColor = () => {
        // 1. Generate a random integer between 0 and 16,777,215 (0xFFFFFF).
        const randomValue = Math.floor(Math.random() * 16777215);

        // 2. Convert the integer to a hexadecimal string (radix 16).
        const hexString = randomValue.toString(16);

        // 3. Pad the string with leading zeros to ensure it's exactly 6 digits long.
        const paddedHex = hexString.padStart(6, '0');

        return `#${paddedHex}`;
    };

    const jsonToList = (jsonData) => {
        if (typeof jsonData === 'string') {
            try {
                jsonData = JSON.parse(jsonData);
            } catch (e) {
                return [{ key: 'Error', value: 'Invalid JSON' }];
            }
        }

        const items = [];

        const flattenObject = (obj, parentKey = '') => {
            if (obj === null || obj === undefined) {
                return;
            }

            if (Array.isArray(obj)) {
                obj.forEach((item, index) => {
                    const key = parentKey ? `${parentKey}[${index}]` : `Item ${index + 1}`;
                    if (typeof item === 'object' && item !== null) {
                        flattenObject(item, key);
                    } else {
                        items.push({ key, value: String(item) });
                    }
                });
            } else if (typeof obj === 'object') {
                Object.keys(obj).forEach(key => {
                    const value = obj[key];
                    const displayKey = parentKey ? `${parentKey}.${key}` : key;
                    
                    if (value === null || value === undefined) {
                        items.push({ key: displayKey, value: String(value) });
                    } else if (typeof value === 'object') {
                        if (Array.isArray(value) && value.length === 0) {
                            items.push({ key: displayKey, value: '[]' });
                        } else if (!Array.isArray(value) && Object.keys(value).length === 0) {
                            items.push({ key: displayKey, value: '{}' });
                        } else {
                            flattenObject(value, displayKey);
                        }
                    } else {
                        items.push({ key: displayKey, value: String(value) });
                    }
                });
            } else {
                items.push({ key: 'Value', value: String(obj) });
            }
        };

        flattenObject(jsonData);
        return items;
    };

    const statusSeverity = {
        pending: 'warning',
        accepted: 'info',
        in_progress: 'secondary',
        completed: 'success'
    };

    const getStatusSeverity = (status) => statusSeverity[status] || 'secondary';

    const formatDate = (date) => {
        return new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    };

    const formatTime = (date) => {
        return new Date(date).toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    return { 
        isCopied, 
        years, 
        tableHeaderClass, 
        barangays, 

        copyText, 
        redirectToNewTab,
        handleCouncilChange,
        convertToOrdinal,
        setNestedValue,
        setFiles,
        generateRandomColor,
        jsonToList,
        getStatusSeverity,
        formatDate,
        formatTime
    }
}
