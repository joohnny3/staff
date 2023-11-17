let excelCheckbox;

document.addEventListener("DOMContentLoaded", () => {
    excelCheckbox = document.querySelectorAll('input[name="staff_id[]"]');
});

function selectAll() {
    const checkboxesArray = Array.from(excelCheckbox);
    const isAllChecked = checkboxesArray.every(checkbox => checkbox.checked);

    checkboxesArray.forEach(function (checkbox) {
        checkbox.checked = !isAllChecked;
    });
}


function deselectAll() {
    excelCheckbox.forEach(function (checkbox) {
        checkbox.checked = false;
    });
}

// async function deleteStaff(staffId) {
//     if (confirm("確定刪除嗎？")) {
//         try {
//             const response = await fetch("/staff/" + staffId, {
//                 method: "DELETE",
//                 headers: {
//                     "X-CSRF-TOKEN": document
//                         .querySelector('meta[name="csrf-token"]')
//                         .getAttribute("content"),
//                     "Content-Type": "application/json",
//                 },
//             });

//             if (response.ok) {
//                 alert("Staff deleted successfully");
//                 window.location.reload();
//             }
//         } catch (error) {
//             alert("Fetch Error:", error);
//         }
//     }
// }

function deleteStaff(staffId) {
    if (confirm("確定刪除嗎？")) {
        const deleteForm = document.querySelector("#deleteForm");
        deleteForm.action = "/staff/" + staffId;
        deleteForm.submit();
    }
}

function excelDownload() {
    const checkBoxs = document.querySelectorAll(
        'input[name="staff_id[]"]:checked'
    );
    const excelDownloadForm = document.getElementById("excelDownloadForm");


    checkBoxs.forEach(function (checkbox) {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "staff_id[]";
        input.value = checkbox.value;
        excelDownloadForm.appendChild(input);
    });

    excelDownloadForm.action = "/staff_export/";
    excelDownloadForm.submit();
}

// async function excelDownload() {
//     const checkBoxs = document.querySelectorAll(
//         'input[name="staff_id[]"]:checked'
//     );
//     const formData = new FormData();

//     checkBoxs.forEach(function (checkbox) {
//         formData.append("staff_id[]", checkbox.value);
//     });

//     // for (let [key, value] of formData.entries()) {
//     //     console.log(key, value);
//     // }
//     // 檢查form表單的值

//     try {
//         const response = await fetch("/staff_export", {
//             method: "POST",
//             body: formData,
//             headers: {
//                 "X-CSRF-TOKEN": document
//                     .querySelector('meta[name="csrf-token"]')
//                     .getAttribute("content"),
//             },
//         });

//         if (response.ok) {
//             const blob = await response.blob();
//             const url = window.URL.createObjectURL(blob);
//             const a = document.createElement("a");
//             a.href = url;
//             a.download = "staff.xlsx";
//             document.body.appendChild(a);
//             a.click();
//             window.URL.revokeObjectURL(url);
//             a.remove();
//             window.location.reload();
//         }
//     } catch (error) {
//         alert("Fetch Error:", error);
//     }
// }

document.addEventListener("DOMContentLoaded", function () {
    const paginationCheckbox = document.querySelectorAll(".paginationCheckbox");
    paginationCheckbox.forEach((link) => {
        link.addEventListener("click", function (event) {
            event.preventDefault(); //預防重載
            const url = this.getAttribute("href");
            saveCheckboxState(url);
        });
    });
});

async function saveCheckboxState(url) {
    const selectedIds = Array.from(
        document.querySelectorAll('input[name="staff_id[]"]:checked')
    ).map((checkbox) => checkbox.value);

    try {
        const response = await fetch("/staff_checkbox", {
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
        alert("Fetch Error:", error);
    }
}
