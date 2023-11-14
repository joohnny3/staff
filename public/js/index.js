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

function excelDownload() {
    const checkBoxs = document.querySelectorAll(
        'input[name="staff_id[]"]:checked'
    );
    const excelForm = document.querySelector("#excelDownloadForm");

    checkBoxs.forEach(function (checkbox) {
        const checkboxInput = document.createElement("input");
        checkboxInput.name = "staff_id[]";
        checkboxInput.value = checkbox.value;
        excelForm.appendChild(checkboxInput);
    });

    excelForm.action = "/staff_export";
    excelForm.submit();
}
