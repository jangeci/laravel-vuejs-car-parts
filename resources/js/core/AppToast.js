export default {
    install(app) {
        const toast = (message, type = "success") => {
            const toast = document.createElement("div");
            toast.className = `toast align-items-center text-bg-${type} border-0 show position-fixed top-0 end-0 m-3`;
            toast.style.zIndex = 1050;
            toast.setAttribute("role", "alert");
            toast.setAttribute("aria-live", "assertive");
            toast.setAttribute("aria-atomic", "true");

            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove("show");
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        };

        app.provide("toast", toast);
    }
};
