import "./bootstrap";
import "flowbite";

// form dashboard
function updateTime() {
    const now = new Date();
    const options = { hour: "2-digit", minute: "2-digit", second: "2-digit" };
    const timeString = now.toLocaleTimeString("en-GB", options);
    document.getElementById("currentTime").textContent = `${timeString} WIB`;
}

setInterval(updateTime, 1000);
updateTime();
