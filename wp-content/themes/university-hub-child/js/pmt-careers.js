document.addEventListener("DOMContentLoaded", function () {

    const applyModal = document.getElementById("pmtApplyModal");
    const salaryModal = document.getElementById("resume-modal");

    const applyBtn = document.querySelector(".pmt-btn-apply");
    const salaryBtn = document.querySelector(".pmt-btn-salary");

    const salaryCloseBtn = document.querySelector(".salary-close-btn");

    const salaryPdfContainer = document.getElementById("salaryPdfContainer");


    // Move modals outside Gutenberg container
    if (applyModal) {
        document.body.appendChild(applyModal);
    }

    if (salaryModal) {
        document.body.appendChild(salaryModal);
    }


    // Apply Modal Open
    if (applyBtn) {
        applyBtn.addEventListener("click", function () {
            applyModal.style.display = "flex";

            setTimeout(function () {
                injectCancelBtn();
                initExperienceToggle();
            }, 300);
        });
    }


    // Salary Modal Open + Lazy PDF Load
    if (salaryBtn) {
        salaryBtn.addEventListener("click", function (e) {
            e.preventDefault();

            salaryModal.style.display = "flex";

            if (!salaryPdfContainer.innerHTML.trim()) {
                salaryPdfContainer.innerHTML = `
                    <iframe 
                        src="https://docs.google.com/viewer?url=https://staging-ad1a-pmtpe2026-zilbu.wpcomstaging.com/wp-content/uploads/2026/04/PMTCPE-Salary-structure.pdf&embedded=true"
                        width="100%"
                        height="100%"
                        style="border:none; width:100%; min-height:500px;">
                    </iframe>
                `;
            }
        });
    }


    // Salary Modal Close
    if (salaryCloseBtn) {
        salaryCloseBtn.addEventListener("click", function (e) {
            e.preventDefault();
            salaryModal.style.display = "none";
        });
    }


    // Close when clicking outside modal
    window.addEventListener("click", function (e) {
        if (e.target === applyModal) {
            applyModal.style.display = "none";
        }

        if (e.target === salaryModal) {
            salaryModal.style.display = "none";
        }
    });


    function injectCancelBtn() {
        const submitContainer = document.querySelector(
            "#pmtApplyModal .wpforms-submit-container"
        );

        if (
            submitContainer &&
            !document.getElementById("pmt-cancel-btn")
        ) {
            const cancelBtn = document.createElement("button");

            cancelBtn.id = "pmt-cancel-btn";
            cancelBtn.type = "button";
            cancelBtn.textContent = "Cancel";

            cancelBtn.addEventListener("click", function () {
                applyModal.style.display = "none";
            });

            submitContainer.appendChild(cancelBtn);
        }
    }


    function initExperienceToggle() {
        const form = document.querySelector(
            "#pmtApplyModal .wpforms-form"
        );

        if (!form) return;

        const radios = form.querySelectorAll(
            'input[type="radio"]'
        );

        let yearsField = null;

        form.querySelectorAll(".wpforms-field").forEach(function (field) {
            const label = field.querySelector(
                ".wpforms-field-label"
            );

            if (
                label &&
                label.textContent.toLowerCase().includes("years")
            ) {
                yearsField = field;
            }
        });

        if (!yearsField) return;

        yearsField.style.display = "none";

        radios.forEach(function (radio) {
            radio.addEventListener("change", function () {
                const val = this.value.toLowerCase();

                if (val.includes("exp")) {
                    yearsField.style.display = "block";
                } else {
                    yearsField.style.display = "none";

                    const input =
                        yearsField.querySelector("input");

                    if (input) {
                        input.value = "";
                    }
                }
            });
        });
    }


    const observer = new MutationObserver(function () {
        injectCancelBtn();
        initExperienceToggle();
    });

    if (applyModal) {
        observer.observe(applyModal, {
            childList: true,
            subtree: true
        });
    }
});