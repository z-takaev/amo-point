(() => {
    const script = document.currentScript || document.querySelector('script[data-endpoint][src*="visitor-tracker.js"]');

    if (!script) {
        return;
    }

    const endpoint = script.dataset.endpoint?.trim();

    if (!endpoint) {
        return;
    }

    collectLocation()
        .then((location) => {
            if (!location) {
                return;
            }

            sendBeacon({
                ip: location.ip,
                city: location.city,
                device: detectDevice(),
            });
        })
        .catch(() => {
            //
        });

    async function collectLocation() {
        if (typeof fetch !== 'function') {
            return null;
        }

        const response = await fetch('https://ipapi.co/json/?token=etLtD0gLBpAdVGiQoM8eBnaF4v3VeGtjLLE2RMwOlMYNJmrka9', {
            method: 'GET',
            credentials: 'omit',
            mode: 'cors',
        });

        if (!response.ok) {
            return null;
        }

        const data = await response.json();
        const ip = String(data.ip ?? '').trim();
        const city = String(data.city ?? '').trim();

        if (!ip || !city) {
            return null;
        }

        return {
            ip,
            city,
        };
    }

    function detectDevice() {
        const userAgent = navigator.userAgent.toLowerCase();

        if (/mobi|android|iphone|ipod/.test(userAgent)) {
            return 'mobile';
        }

        if (/ipad|tablet/.test(userAgent)) {
            return 'tablet';
        }

        return 'desktop';
    }

    function sendBeacon(data) {
        if (typeof navigator.sendBeacon !== 'function') {
            return;
        }

        navigator.sendBeacon(endpoint, new URLSearchParams({
            ip: data.ip,
            city: data.city,
            device: data.device,
        }));
    }

})();
