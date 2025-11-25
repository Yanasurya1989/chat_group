window.Echo.channel("chat").listen(".MessageSent", (e) => {
    console.log("Realtime message:", e.message);
});
