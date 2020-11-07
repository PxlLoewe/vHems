const notifi = {
    init() {
        this.hideTimeout = null;

        this.el = document.createElement("div");
        this.el.className = "notifi";
        document.body.appendChild(this.el);
    },
    show(message, state) {
        clearTimeout(this.hideTimeout);
        this.el.textContent = message;
        this.el.className = "notifi notifi--visible";

        if(state){
            this.el.classList.add(`notifi-${state}`);
        }
        this.hideTimeout = setTimeout(() => {
            this.el.classList.remove("notifi--visible");
        }, 3000);
    }
};

document.addEventListener("DOMContentLoaded", () => notifi.init())
