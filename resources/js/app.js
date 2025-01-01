import "./bootstrap";

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: process.env.PUSHER_APP_KEY,
    cluster: process.env.PUSHER_APP_CLUSTER,
    forceTLS: true,
});

// Listen for the low stock update event
window.Echo.channel("stock-updates").listen("LowStockUpdated", (event) => {
    // Get the list of low stock items
    const lowStockItems = event.lowStockItems;

    // If there are low stock items, update the notification
    if (lowStockItems.length > 0) {
        updateNotificationBell(lowStockItems);
    }
});

// Function to update the notification bell
function updateNotificationBell(lowStockItems) {
    const notificationCount = document.getElementById("notification-count");
    const notificationTitle = document.getElementById("notification-title");
    const notificationList = document.getElementById("notification-list");

    // Update the count
    notificationCount.innerText = lowStockItems.length;

    // Update the notification title
    notificationTitle.innerText = lowStockItems.length + " Low Stock Item(s)";

    // Clear existing notifications
    notificationList.innerHTML = "";

    // Add new low stock item notifications
    lowStockItems.forEach((item) => {
        const listItem = document.createElement("div");
        listItem.classList.add("dropdown-item");
        listItem.innerHTML = `
            <span><strong>${item.name}</strong> has low stock (Quantity: ${item.quantity})</span>
        `;
        notificationList.appendChild(listItem);
    });
}
