window.addEventListener('load', () => {
    document.querySelectorAll('[data-include]').forEach(el => {
        const url = el.getAttribute('data-include');
        fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to load fragment: ${response.statusText}`);
            }
            return response.text();
        })
        .then(html => el.outerHTML = html)
        .catch(error => {
            console.error(error);
            el.innerHTML = error.message;
        });
    });
});

