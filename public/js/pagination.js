document.addEventListener("DOMContentLoaded", function () {
    let paginationCheckbox = document.querySelectorAll(".paginationCheckbox");
    paginationCheckbox.forEach((link) => {
        link.addEventListener("click", function (event) {
            event.preventDefault(); //預防重載
            const url = this.getAttribute("href");
            saveCheckboxState(url);
        });
    });
});

async function saveCheckboxState(url) {
    let selectedIds = Array.from(
        document.querySelectorAll('input[name="staff_id[]"]:checked')
    ).map((checkbox) => checkbox.value);

    try {
        let response = await fetch("/staff_checkbox", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ selectedIds: selectedIds }),
        });

        if (response.ok) {
            window.location.href = url;
        }
    } catch (error) {
        console.error("Fetch Error:", error);
    }
}
