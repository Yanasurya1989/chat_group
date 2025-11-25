import "./bootstrap";

const chatForm = document.getElementById("chat-form");
const chatBox = document.getElementById("chat-box");

chatForm.addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(chatForm);

    fetch("/chat/send", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": formData.get("_token"),
        },
        body: formData,
    })
        .then((res) => res.json())
        .then((res) => {
            if (res.status === "ok") {
                chatForm.reset();
            }
        });
});
