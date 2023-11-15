let excelCheckbox;

document.addEventListener("DOMContentLoaded", () => {
    excelCheckbox = document.querySelectorAll('input[name="staff_id[]"]');
});

function selectAll() {
    excelCheckbox.forEach(function (checkbox) {
        checkbox.checked = true;
    });
}

function deselectAll() {
    excelCheckbox.forEach(function (checkbox) {
        checkbox.checked = false;
    });
}

function deleteStaff(staffId) {
    if (confirm("確定刪除嗎？")) {
        const deleteForm = document.querySelector("#deleteForm");
        deleteForm.action = "/staff/" + staffId;
        deleteForm.submit();
    }
}

// function excelDownload() {
//     const checkBoxs = document.querySelectorAll(
//         'input[name="staff_id[]"]:checked'
//     );
//     const excelForm = document.querySelector("#excelDownloadForm");

//     checkBoxs.forEach(function (checkbox) {
//         const checkboxInput = document.createElement("input");
//         checkboxInput.name = "staff_id[]";
//         checkboxInput.value = checkbox.value;
//         excelForm.appendChild(checkboxInput);
//     });

//     excelForm.action = "/staff_export";
//     excelForm.submit();
// }

async function excelDownload() {
    const checkBoxs = document.querySelectorAll(
        'input[name="staff_id[]"]:checked'
    );
    const formData = new FormData();

    checkBoxs.forEach(function (checkbox) {
        formData.append("staff_id[]", checkbox.value);
    });

    // for (let [key, value] of formData.entries()) {
    //     console.log(key, value);
    // }
    // 檢查form表單的值

    try {
        const response = await fetch("/staff_export", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        });

        if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "staff.xlsx";
            document.body.appendChild(a); 
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();
            window.location.reload(); 
        }
    } catch (error) {
        console.error("Fetch Error:", error);
    }
}

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
